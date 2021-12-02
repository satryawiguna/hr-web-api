<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Database
        Schema::defaultStringLength(191);

        //Sync Has Many
        HasMany::macro('sync', function (array $data, $deleting = true) {
            $changes = [
                'created' => [], 'deleted' => [], 'updated' => [],
            ];

            /** @var HasMany $this */

            $relatedKeyName = $this->getRelated()->getKeyName();

            $current = $this->newQuery()->pluck($relatedKeyName)->all();

            $castKey = function ($value) {
                if (is_null($value)) {
                    return $value;
                }

                return is_numeric($value) ? (int) $value : (string) $value;
            };

            $castKeys = function ($keys) use ($castKey) {
                return (array) array_map(function ($key) use ($castKey) {
                    return $castKey($key);
                }, $keys);
            };

            $deletedKeys = array_diff($current, $castKeys(
                    Arr::pluck($data, $relatedKeyName))
            );

            if ($deleting && count($deletedKeys) > 0) {
                $this->getRelated()->destroy($deletedKeys);
                $changes['deleted'] = $deletedKeys;
            }

            $newRows = Arr::where($data, function ($row) use ($relatedKeyName) {
                return Arr::get($row, $relatedKeyName) === null;
            });

            $updatedRows = Arr::where($data, function ($row) use ($relatedKeyName) {
                return Arr::get($row, $relatedKeyName) !== null;
            });

            if (count($newRows) > 0) {
                $newRecords = $this->createMany($newRows);
                $changes['created'] = $castKeys(
                    $newRecords->pluck($relatedKeyName)->toArray()
                );
            }

            foreach ($updatedRows as $row) {
                $this->getRelated()->where($relatedKeyName, $castKey(Arr::get($row, $relatedKeyName)))
                    ->update($row);
            }

            $changes['updated'] = $castKeys(Arr::pluck($updatedRows, $relatedKeyName));

            return $changes;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
