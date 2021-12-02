<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('cities')->insert([
      [
        'state_id' => 1,
        'city_name' => 'Kota Langsa',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kota Lhokseumawe',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kota Sabang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kota Banda Aceh',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Bener Meriah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Tamiang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Nagan Jaya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Jaya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Gayo Lues',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Barat Daya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Bireun',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Singkil',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Simeulue',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Pidie',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Besar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Tengah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Tenggara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 1,
        'city_name' => 'Kab. Aceh Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kota Padang Sidempuan",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kota Tebing Tinggi",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kota Binjai",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kota Tanjung Balai",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kota Sibolga",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kota Pematang Siantar",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kota Medan",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Serdang Bedagai ",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Samosir ",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Humbang Hasundutan",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Pakpak Barat",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Nias Selatan",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Mandailing Natal",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Toba Samosir",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Dairi",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Labuhan Batu",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Asahan",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Simalungun",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Deli Serdang",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Karo",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Langkat",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Nias",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Tapanuli Selatan",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Tapanuli Utara",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 2,
        'city_name' => "Kab. Tapanuli Tengah",
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kota Pariaman',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kota Payakumbuh',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kota Bukittinggi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kota Padang Panjang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kota Sawhlunto',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kota Solok',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kota Padang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Pasaman Barat ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Solok Selatan ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Dharmasraya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Kepulauan Mentawai',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Pasaman ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Lima Puluh Kota',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Agam',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Padang Pariaman',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Tanah Datar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Sw. lunto',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Solok',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 3,
        'city_name' => 'Kab. Pesisir Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kota Dumai',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kota Pekan Baru',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Kuantan Singingi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Siak',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Rokan Hilir',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Rokan Hulu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Pelalawan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Indragiri Hilir',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Bengkalis',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Indragiri Hulu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 4,
        'city_name' => 'Kab. Kampar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Kerinci',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Tebo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Bungo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Tanjung Jabung Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Tanjung Jabung Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Muaro Jambi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Batanghari',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Sarolangun',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kab. Merangin',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 5,
        'city_name' => 'Kota Jambi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kota Prabumulih',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kota Lubuk Linggau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kota Pagar Alam',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kota Palembang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Ogan Ilir ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Oku Selatan ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Oku Timur ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Banyuasin',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Musi Banyuasin',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Musi Rawas',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Lahat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Muara Enim',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Ogan Komering Ilir',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 6,
        'city_name' => 'Kab. Ogan Komering Ulu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kota Bengkulu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Kepahiang ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Lebong ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Muko Muko',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Seluma',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Kaur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Bengkulu Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Rejang Lebong ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 7,
        'city_name' => 'Kab. Bengkulu Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kota Metro',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kota Bandar Lampung',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Way Kanan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Lampung Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Tanggamus',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Tulang Bawang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Lampung Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Lampung Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Lampung Tengah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 8,
        'city_name' => 'Kab. Lampung Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 9,
        'city_name' => 'Kota Pangkal Pinang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 9,
        'city_name' => 'Kab. Bangka Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 9,
        'city_name' => 'Kab. Bangka Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 9,
        'city_name' => 'Kab. Bangka Tengah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 9,
        'city_name' => 'Kab. Bangka Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 9,
        'city_name' => 'Kab. Belitung',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 9,
        'city_name' => 'Kab. Bangka',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 10,
        'city_name' => 'Kota Tanjung Pinang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 10,
        'city_name' => 'Kota Batam',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 10,
        'city_name' => 'Kab. Lingga ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 10,
        'city_name' => 'Kab. Natuna',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 10,
        'city_name' => 'Kab. Karimun',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 10,
        'city_name' => 'Kab. Kepulauan Riau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 11,
        'city_name' => 'Kodya Jakarta Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 11,
        'city_name' => 'Kodya Jakarta Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 11,
        'city_name' => 'Kodya Jakarta Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 11,
        'city_name' => 'Kodya Jakarta Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 11,
        'city_name' => 'Kodya Jakarta Pusat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 11,
        'city_name' => 'Kab. Adm. Kep. Seribu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Banjar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Tasikmalaya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Cimahi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Depok',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Bekasi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Cirebon',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Bandung',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Sukabumi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kota Bogor',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Bekasi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Karawang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Purwakarta',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Subang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Indramayu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Sumedang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Majalengka',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Cirebon',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Kuningan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Ciamis',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Tasikmalaya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Garut',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Bandung',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Cianjur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Sukabumi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 12,
        'city_name' => 'Kab. Bogor',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kota Tegal',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kota Pekalongan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kota Semarang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kota Salatiga',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kota Surakarta',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kota Magelang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kab. Brebes',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kab. Tegal',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kab. Pemalang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kab. Pekalongan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kab. Batang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kab. Blora',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 13,
        'city_name' => 'Kab. Banyumas',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 14,
        'city_name' => 'Kota Yogyakarta',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 14,
        'city_name' => 'Kab. Sleman',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 14,
        'city_name' => 'Kab. Gunung Kidul',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 14,
        'city_name' => 'Kab. Bantul',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 14,
        'city_name' => 'Kab. Kulon Progo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Batu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Surabaya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Madiun',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Mojokerto',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Pasuruan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Probolinggo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Malang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Blitar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kota Kediri',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Sumenep',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Pamekasan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Sampang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Bangkalan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Gresik',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Lamongan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Tuban',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Bojonegoro',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Ngawi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Magetan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Madiun',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Nganjuk',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Jombang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Mojokerto',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Sidoarjo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Pasuruan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Probolinggo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Situbondo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Bondowoso',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 15,
        'city_name' => 'Kab. Banyuwangi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 16,
        'city_name' => 'Kota Cilegon',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 16,
        'city_name' => 'Kota Tangerang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 16,
        'city_name' => 'Kab. Serang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 16,
        'city_name' => 'Kab. Tangerang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 16,
        'city_name' => 'Kab. Lebak',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 16,
        'city_name' => 'Kab. Pandeglang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kota Denpasar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Buleleng',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Karangasem',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Bangli',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Klungkung',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Gianyar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Badung',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Tabanan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 17,
        'city_name' => 'Kab. Jembarana',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kota Bima',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kota Mataram',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kab. Sumbawa Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kab. Bima',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kab. Dompu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kab. Sumbawa',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kab. Lombok Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kab. Lombok Tengah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 18,
        'city_name' => 'Kab. Lombok Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kota Kupang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Manggarai Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Rote Ndao',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Lembata',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Sumba Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Sumba Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Manggarai',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Ngada',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Ende',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Sikka',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Flores Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Alor',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Belu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Timor Tengah Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Timor Tengah Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 19,
        'city_name' => 'Kab. Kupang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kota Singkawang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kota Pontianak',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Sekadau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Melawi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Landak',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Bengkayang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Kapuas Hulu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Sintang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Ketapang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Sanggau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Pontianak',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 20,
        'city_name' => 'Kab. Sambas',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kota Palangkaraya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Barito Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Murung Raya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Pulang Pisau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Gunung Mas',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Lamandau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Sukamara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Seruyan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Katingin',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Barito Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Barito Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Kapuas',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Kotawaringin Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 21,
        'city_name' => 'Kab. Kotawaringin Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kota Banjarbaru',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kota Banjarmasin',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Balangan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Tanah Bambu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Tabalong',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Hulu Sungai Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Hulu Sungai Tengah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Hulu Sungai Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Tapin',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Barito Kuala',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Banjar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Kotabaru',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 22,
        'city_name' => 'Kab. Tanah Laut',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kota Bontang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kota Tarakan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kota Samarinda',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kota Balikpapan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Penajam Paser Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Kutai Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Kutai Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Malinau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Nunukan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Bulungan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Berau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Kutai Kertanegara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 23,
        'city_name' => 'Kab. Pasir',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kota Tomohon',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kota Bitung',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kota Manado',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kab. Minahasa Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kab. Minahasa Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kab. Kepulauan Talaud',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kab. Kepulauan Sangihe',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kab. Minahasa ',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 24,
        'city_name' => 'Kab. Bolaang Mangondow',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kota Palu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Tojo Una Una',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Parigi Moutong',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Banggai Kepulauan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Morowali',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Buol',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Toloi Toli',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Donggala',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Poso',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 25,
        'city_name' => 'Kab. Banggai',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kota Palopo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kota Pare Pare',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kota Makasar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Luwu Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Luwu Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Tana Toraja',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Luwu',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Enrekang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Pinrang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Sidenreng Rapang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Wajo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Soppeng',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Barru',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Pangkajene Kep.',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Maros',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Bone',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Sinjai',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Gowa',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Takalar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Jeneponto.',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Bantaeng',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Bulukumba',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 26,
        'city_name' => 'Kab. Selayar',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kota Bau Bau',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kota Kendari',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Kolaka Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Wakatobi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Bombana',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Konawe Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Buton',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Muna',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Konawe',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 27,
        'city_name' => 'Kab. Kolaka',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 28,
        'city_name' => 'Kota Gorontalo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 28,
        'city_name' => 'Kab. Pohuwato',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 28,
        'city_name' => 'Kab. Bone Bolango',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 28,
        'city_name' => 'Kab. Boalemo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 28,
        'city_name' => 'Kab. Gorontalo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 28,
        'city_name' => 'Kab. Gorontalo Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 29,
        'city_name' => 'Kab. Majene',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 29,
        'city_name' => 'Kab. Polowali Mamasa',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 29,
        'city_name' => 'Kab. Mamasa',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 29,
        'city_name' => 'Kab. Mamuju',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 29,
        'city_name' => 'Kab. Mamuju Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kota Ambon',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kab. Kepulauan Aru',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kab. Seram Bagian Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kab. Seram Bagian Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kab. Buru',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kab. Maluku Tenggara Brt',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kab. Maluku Tenggara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 30,
        'city_name' => 'Kab. Maluku Tengah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kota Tidore Kepulauan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kota Ternate',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kab. Halmahera Timur',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kab. Kepulauan Sula',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kab. Halmahera Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kab. Halmahera Utara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kab. Halmahera Tengah',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 31,
        'city_name' => 'Kab. Halmahera Barat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kota Jayapura',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Supiori',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Asmat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Mappi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Boven Digoel',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Waropen',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Tolikara',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Yahukimo',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Pegunungan Bintang',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Keerom',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Sarmi',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Mimika',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Paniai',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Puncak Jaya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Biak Numfor',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Yapen Waropen',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Nabire',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Jayapura',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Jayawijaya',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 32,
        'city_name' => 'Kab. Merauke',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kota Sorong',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Kaima',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Teluk Wondama',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Teluk Bentuni',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Raja Ampat',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Sorong Selatan',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Fak Fak',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Manokwari',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
      [
        'state_id' => 33,
        'city_name' => 'Kab. Sorong',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
      ],
    ]);
  }
}
