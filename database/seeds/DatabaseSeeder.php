<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    ini_set('memory_limit', '512M');

    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    //Delete table records
    DB::table('media_libraries')->truncate();

    DB::table('company_applications')->truncate();
    DB::table('user_companies')->truncate();
    DB::table('user_applications')->truncate();
    DB::table('user_groups')->truncate();
    DB::table('user_roles')->truncate();
    DB::table('role_permissions')->truncate();
    DB::table('permission_accesses')->truncate();

    DB::table('other_equipments')->truncate();
    DB::table('work_competences')->truncate();
    DB::table('organization_histories')->truncate();
    DB::table('non_formal_education_histories')->truncate();
    DB::table('formal_education_histories')->truncate();
    DB::table('childs')->truncate();
    DB::table('employees')->truncate();

    DB::table('competences')->truncate();
    DB::table('letter_types')->truncate();
    DB::table('work_areas')->truncate();

    DB::table('religions')->truncate();
    DB::table('offices')->truncate();
    DB::table('marital_status')->truncate();
    DB::table('majors')->truncate();
    DB::table('genders')->truncate();
    DB::table('degrees')->truncate();
    DB::table('contract_types')->truncate();
    DB::table('banks')->truncate();
    DB::table('permissions')->truncate();
    DB::table('accesses')->truncate();

    DB::table('profiles')->truncate();
    DB::table('users')->truncate();
    DB::table('companies')->truncate();
    DB::table('company_categories')->truncate();
    DB::table('employee_number_scales')->truncate();

    DB::table('roles')->truncate();
    DB::table('groups')->truncate();
    DB::table('applications')->truncate();
    DB::table('countries')->truncate();
    DB::table('states')->truncate();
    DB::table('cities')->truncate();

    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    //Call seeder
    $this->call(ApplicationSeeder::class);
    $this->call(GroupSeeder::class);
    $this->call(RoleSeeder::class);

    $this->call(EmployeeNumberScaleSeeder::class);
    $this->call(CompanyCategorySeeder::class);
    $this->call(CompanySeeder::class);
    $this->call(UserSeeder::class);
    $this->call(ProfileSeeder::class);

    $this->call(AccessSeeder::class);
    $this->call(PermissionSeeder::class);
    $this->call(BankSeeder::class);
    $this->call(ContractTypeSeeder::class);
    $this->call(DegreeSeeder::class);
    $this->call(GenderSeeder::class);
    $this->call(MajorSeeder::class);
    $this->call(MaritalStatusSeeder::class);
    $this->call(OfficeSeeder::class);
    $this->call(ReligionSeeder::class);

    $this->call(CompetenceSeeder::class);
    $this->call(LetterTypeSeeder::class);
    $this->call(WorkAreaSeeder::class);

    $this->call(EmployeeSeeder::class);
    $this->call(ChildSeeder::class);
    $this->call(FormalEducationHistorySeeder::class);
    $this->call(NonFormalEducationHistorySeeder::class);
    $this->call(OrganizationHistorySeeder::class);
    $this->call(WorkCompetenceSeeder::class);
    $this->call(OtherEquipmentSeeder::class);

    $this->call(PermissionAccessSeeder::class);
    $this->call(RolePermissionSeeder::class);
    $this->call(UserRoleSeeder::class);
    $this->call(UserGroupSeeder::class);
    $this->call(UserApplicationSeeder::class);
    $this->call(UserCompanySeeder::class);
    $this->call(CompanyApplicationSeeder::class);

    $this->call(MediaLibrarySeeder::class);

    $this->call(CountrySeeder::class);
    $this->call(StateSeeder::class);
    $this->call(CitySeeder::class);
  }
}
