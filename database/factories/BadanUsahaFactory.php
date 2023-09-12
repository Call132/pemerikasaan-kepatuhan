<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


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
        $jumlahTunggakan = $this->faker->randomFloat(2, 100, 10000);


        return [
            'nama_badan_usaha' => $this ->faker->company,
            'kode_badan_usaha' => $this ->faker->unique()->ean8,
            'alamat' => $this ->faker->address,
            'kota_kab' => $this ->faker->city,
            'jenis_ketidakpatuhan' => $this ->faker->word,
            'tanggal_terakhir_bayar' => $this ->faker->date,
            'jumlah_tunggakan' => $jumlahTunggakan,
            'jenis_pemeriksaan' => $this ->faker->word,
            'jadwal_pemeriksaan' => $this ->faker->date,
        ];
    }
}
