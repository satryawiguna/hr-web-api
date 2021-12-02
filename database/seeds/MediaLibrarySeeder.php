<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class MediaLibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $datas = [
            [
                'id' => null,
                'user_id' => 1,
                'collection' => 'COMPANY',
                'original_file' => null,
                'generate_file' => null,
                'extension' => 'jpg',
                'type' => null,
                'mime_type' => 'image/jpeg',
                'disk' => 'storage',
                'path' => 'media/commons/company/',
                'width' => 1024,
                'height' => 800,
                'size' => 100,
                'created_by' => 'system'
            ],
            [
                'id' => null,
                'user_id' => 1,
                'collection' => 'PROFILE',
                'original_file' => null,
                'generate_file' => null,
                'extension' => 'jpg',
                'type' => null,
                'mime_type' => 'image/jpeg',
                'disk' => 'storage',
                'path' => 'media/user/profile/',
                'width' => 800,
                'height' => 600,
                'size' => 100,
                'created_by' => 'system'
            ],
            [
                'id' => null,
                'user_id' => 1,
                'collection' => 'EMPLOYEE',
                'original_file' => null,
                'generate_file' => null,
                'extension' => 'jpg',
                'type' => null,
                'mime_type' => 'image/jpeg',
                'disk' => 'storage',
                'path' => 'media/human-resources/personal/employee/',
                'width' => 640,
                'height' => 480,
                'size' => 100,
                'created_by' => 'system'
            ],
            [
                'id' => null,
                'user_id' => 1,
                'collection' => 'PROJECT',
                'original_file' => null,
                'generate_file' => null,
                'extension' => 'pdf',
                'type' => null,
                'mime_type' => 'application/pdf',
                'disk' => 'storage',
                'path' => 'media/human-resources/project/',
                'width' => null,
                'height' => null,
                'size' => 100,
                'created_by' => 'system'
            ],
            [
                'id' => null,
                'user_id' => 1,
                'collection' => 'PROJECT_ADDENDUM',
                'original_file' => null,
                'generate_file' => null,
                'extension' => 'pdf',
                'type' => null,
                'mime_type' => 'application/pdf',
                'disk' => 'storage',
                'path' => 'media/human-resources/project-addendum/',
                'width' => null,
                'height' => null,
                'size' => 100,
                'created_by' => 'system'
            ]
        ];

        $mediaLibraries = [];

        foreach ($datas as $data) {
            $uuid = Uuid::uuid4();

            switch ($data['mime_type']) {
                case "image/jpeg":
                    $ext = '.jpg';
                    break;

                case "application/pdf":
                    $ext = '.pdf';
                    break;
            }
            $originalFile = 'original_file_' . rand(100, 999) . $ext;
            $generateFile = Carbon::now()->timestamp . '_' . uniqid() . $ext;

            $data['id'] = $uuid;
            $data['original_file'] = $originalFile;
            $data['generate_file'] = $generateFile;

            array_push($mediaLibraries, $data);
        }

        DB::table('media_libraries')->insert($mediaLibraries);

        foreach ($mediaLibraries as $mediaLibrary) {
            DB::table('media_libraryables')->insert([
                'media_library_id' => $mediaLibrary['id'],
                'media_libraryable_id' => rand(1, 2),
                'media_libraryable_type' => 'companies'
            ]);
        }
    }
}
