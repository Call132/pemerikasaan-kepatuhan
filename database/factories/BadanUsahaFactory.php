<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as faker;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BadanUsaha>
 */
class BadanUsahaFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('id_ID');
        $jumlahTunggakan = $this->faker->randomFloat(2, 100, 10000, 100000);


        return [
            'nama_badan_usaha' => $faker->company,
            'kode_badan_usaha' => $this->faker->unique()->ean8,
            'alamat' => $faker->address,
            'kota_kab' => $faker->city,
            'jenis_ketidakpatuhan' => $faker->word,
            'tanggal_terakhir_bayar' => $faker->date('Y_m_d'),
            'jumlah_tunggakan' => $jumlahTunggakan,
            'jenis_pemeriksaan' => $faker->word,
            'jadwal_pemeriksaan' => $faker->date,
            'perencanaan_id' => '1',
        ];
    }
}
