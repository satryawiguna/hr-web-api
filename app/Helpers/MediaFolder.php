<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 1/19/20
 * Time: 1:26 PM
 */

namespace App\Helpers;


class MediaFolder
{
    const
        STORAGE = "storage",
        COMPANY = "media/commons/company/collections",
        PROFILE = "media/user/profile/collections",
        EMPLOYEE = "media/human-resources/personal/employee/collections",
        PROJECT = "media/human-resources/project/collections",
        PROJECT_ADDENDUM = "media/human-resources/project/project-addendum/collections";

    public static function getFileType(string $ext) {
        $fileTypes = [
            'image' => [
                'jpg', 'jpeg', 'png', 'gif', 'bmp'
            ],
            'document' => [
                'doc', 'docx', 'pdf', 'xlx', 'xlxs'
            ],
            'script' => [
                'php', 'asp', 'aspx', 'js', 'ts', 'py', 'rb'
            ]
        ];

        foreach ($fileTypes as $key => $value) {
            if (in_array($ext, $value)) {
                return $key;
            }
        }

        return 'other';
    }
}