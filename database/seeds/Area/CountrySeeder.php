<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('countries')->insert([
      [
        'country_name' => 'Indonesia',
        'two_letter_code' => 'ID',
        'phone_code' => '+62',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
    ]);
  }
}
