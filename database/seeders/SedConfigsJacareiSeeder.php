<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedConfigsJacareiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            [
                'key' => 'system',
                'description' => 'Marca o sistema de qual cidade esta em execução',
                'value' => 'JACAREI',
                'is_enabled' => true, // Marca se o sistema esta com as funções do sed habilitadas, caso false nenhuma das funções serao executadas, apenas ieducar rodando.
            ],
        ];

        DB::table('sed_configs')->insert($configs);
    }


}
