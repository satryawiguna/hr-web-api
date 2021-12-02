<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            //Group: System
            //Role: Super Admin
            ['name' => 'Manage application', 'slug' => 'manage-application', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/application', 'created_by' => 'system'],
            ['name' => 'Manage group', 'slug' => 'manage-group', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/group', 'created_by' => 'system'],
            ['name' => 'Manage role', 'slug' => 'manage-role', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/role', 'created_by' => 'system'],
            ['name' => 'Manage permission', 'slug' => 'manage-permission', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/permission', 'created_by' => 'system'],
            ['name' => 'Manage access', 'slug' => 'manage-access', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/access', 'created_by' => 'system'],
            ['name' => 'Manage bank', 'slug' => 'manage-bank', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/bank', 'created_by' => 'system'],
            ['name' => 'Manage company', 'slug' => 'manage-company', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/company', 'created_by' => 'system'],
            ['name' => 'Manage degree', 'slug' => 'manage-degree', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/degree', 'created_by' => 'system'],
            ['name' => 'Manage employee number scale', 'slug' => 'manage-employee-number-scale', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/employee-number-scale', 'created_by' => 'system'],
            ['name' => 'Manage gender', 'slug' => 'manage-gender', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/gender', 'created_by' => 'system'],
            ['name' => 'Manage major', 'slug' => 'manage-major', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/major', 'created_by' => 'system'],
            ['name' => 'Manage marital status', 'slug' => 'manage-marital-status', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/marital-status', 'created_by' => 'system'],
            ['name' => 'Manage religion', 'slug' => 'manage-religion', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/religion', 'created_by' => 'system'],
            ['name' => 'Manage user', 'slug' => 'manage-user', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/user', 'created_by' => 'system'],
            ['name' => 'Manage user role (system)', 'slug' => 'manage-user-role-system', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/user/role/system', 'created_by' => 'system'],
            ['name' => 'Manage user permission (system)', 'slug' => 'manage-user-permission-system', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/user/permission/system', 'created_by' => 'system'],
            ['name' => 'Manage setting (system)', 'slug' => 'manage-setting-system', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/setting/system', 'created_by' => 'system'],

            //Group: Company
            //Role: Admin, Owner
            //Master Data
            ['name' => 'Manage competence', 'slug' => 'manage-competence', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/competence', 'created_by' => 'system'],
            ['name' => 'Manage letter type', 'slug' => 'manage-letter-type', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/letter-type', 'created_by' => 'system'],
            ['name' => 'Manage position', 'slug' => 'manage-position', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/sposition', 'created_by' => 'system'],
            ['name' => 'Manage work area', 'slug' => 'manage-work-area', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/work-area', 'created_by' => 'system'],
            ['name' => 'Manage work unit', 'slug' => 'manage-work-unit', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/work-unit', 'created_by' => 'system'],

            //Role: Admin, Owner, Manager, Operator
            //Personal
            ['name' => 'Manage employee', 'slug' => 'manage-employee', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/employee', 'created_by' => 'system'],
            ['name' => 'Manage child', 'slug' => 'manage-child', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/child', 'created_by' => 'system'],
            ['name' => 'Manage formal education history', 'slug' => 'manage-formal-education-history', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/formal-education-history', 'created_by' => 'system'],
            ['name' => 'Manage non formal education history', 'slug' => 'manage-non-formal-education-history', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/non-formal-education-history', 'created_by' => 'system'],
            ['name' => 'Manage organization history', 'slug' => 'manage-organization-history', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/organization-history', 'created_by' => 'system'],
            ['name' => 'Manage other equipment', 'slug' => 'manage-other-equipment', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/other-equipment', 'created_by' => 'system'],
            ['name' => 'Manage work experience', 'slug' => 'manage-work-experience', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/work-experience', 'created_by' => 'system'],
            ['name' => 'Manage work competence', 'slug' => 'manage-work-competence', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/work-competence', 'created_by' => 'system'],
            ['name' => 'Manage position mutation', 'slug' => 'manage-position-mutation', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/position-mutation', 'created_by' => 'system'],
            ['name' => 'Manage project mutation', 'slug' => 'manage-project-mutation', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/project-mutation', 'created_by' => 'system'],
            ['name' => 'Manage registration letter', 'slug' => 'manage-registration-letter', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/registration-letter', 'created_by' => 'system'],
            ['name' => 'Manage termination', 'slug' => 'manage-termination', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/termination', 'created_by' => 'system'],
            ['name' => 'Manage work agreement letter', 'slug' => 'manage-work-agreement-letter', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/work-agreement-letter', 'created_by' => 'system'],
            ['name' => 'Manage work unit mutation', 'slug' => 'manage-work-unit-mutation', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/work-unit-mutation', 'created_by' => 'system'],

            //Project
            ['name' => 'Manage project', 'slug' => 'manage-project', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/project', 'created_by' => 'system'],
            ['name' => 'Manage project addendum', 'slug' => 'manage-project-addendum', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/project-addendum', 'created_by' => 'system'],
            ['name' => 'Manage project terms', 'slug' => 'manage-project-terms', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/project-terms', 'created_by' => 'system'],

            //Attendance
            ['name' => 'Manage attendance', 'slug' => 'manage-attendance', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/attendance', 'created_by' => 'system'],
            ['name' => 'Manage setting (company)', 'slug' => 'manage-setting-company', 'server' => 'https://api.smartbiz.id/', 'path' => '/api/v1/setting/company', 'created_by' => 'system'],
        ]);
    }
}
