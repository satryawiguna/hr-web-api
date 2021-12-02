<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:43 PM
 */

namespace App\Helpers;


use Illuminate\Support\Collection;

class Common
{
    /**
     * @param $data
     * @return bool
     */
    public static function isDataExist($data): bool
    {
        if ($data) {
            if (is_array($data)) {
                if (count($data) > 0) {
                    return true;
                }

                return false;
            }

            if ($data instanceof Collection) {
                if ($data->count() > 0) {
                    return true;
                }

                return false;
            }

            return true;
        }

        return false;
    }

    public static function levelUp(&$array, $level = 0)
    {
        foreach($array as $key => &$value) {
            $value->level = $level;

            if(property_exists($array[$key], 'children')) {
                self::levelUp($value->children, $level + 1);
            }
        }
    }

    public static function removeExistingKeyOfSetting(array $settings, array $additionalSettings)
    {
        foreach ($additionalSettings as $key => $value) {
            if (array_key_exists($key, $settings)) {
                unset($additionalSettings[$key]);
            }
        }

        return $additionalSettings;
    }

    public static function splitStringByPattern(string $pattern, string $subject)
    {
        $subject = str_replace(PHP_EOL, '', $subject);

        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $result = [];

        foreach ($matches as $item) {
            $result[$item[1]] = $item[2];
        }

        $result['response'] = (substr($result['response'], -2) != "\"}") ? json_decode($result['response'] . "\"}") : json_decode($result['response']);

        return $result;
    }
}