<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MediaLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from \r
        "public/media/commons/company" to "storage/app/media/commons/company"\r
        "public/media/user/profile" to "storage/app/media/user/profile"\r
        "public/media/human-resources/personal/employee" to "storage/app/media/human-resources/personal/employee"\r
        "public/media/human-resources/project" to "storage/app/media/human-resources/project"\r
        "public/media/human-resources/project/project-addendum" to "storage/app/media/human-resources/project/project-addendum"';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!file_exists(public_path('media/commons/company/collections'))) {
            $this->laravel->make('files')->link(
                storage_path('app/media/commons/company'), public_path('media/commons/company/collections')
            );

            $this->info('The [public/media/commons/company] directory has been linked.');
        } else {
            $this->error('The [public/media/commons/company] directory already linked.');
        }

        if (!file_exists(public_path('media/user/profile/collections'))) {
            $this->laravel->make('files')->link(
                storage_path('app/media/user/profile'), public_path('media/user/profile/collections')
            );

            $this->info('The [public/media/user/profile] directory has been linked.');
        } else {
            $this->info('The [public/media/user/profile] directory already linked.');
        }

        if (!file_exists(public_path('media/human-resources/personal/employee/collections'))) {
            $this->laravel->make('files')->link(
                storage_path('app/media/human-resources/personal/employee'), public_path('media/human-resources/personal/employee/collections')
            );

            $this->info('The [public/media/human-resources/personal/employee] directory has been linked.');
        } else {
            $this->info('The [public/media/human-resources/personal/employee] directory already linked.');
        }

        if (!file_exists(public_path('media/human-resources/project/collections'))) {
            $this->laravel->make('files')->link(
                storage_path('app/media/human-resources/project'), public_path('media/human-resources/project/collections')
            );

            $this->info('The [public/media/human-resources/project] directory has been linked.');
        } else {
            $this->info('The [public/media/human-resources/project] directory already linked.');
        }

        if (!file_exists(public_path('media/human-resources/project/project-addendum/collections'))) {
            $this->laravel->make('files')->link(
                storage_path('app/media/human-resources/project/project-addendum'), public_path('media/human-resources/project/project-addendum/collections')
            );

            $this->info('The [public/media/human-resources/project/project-addendum] directory has been linked.');
        } else {
            $this->info('The [public/media/human-resources/project/project-addendum] directory already linked.');
        }


    }
}
