<?php

namespace Database\Seeders;

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
            [
                'key' => 'diretoria',
                'description' => 'ID da diretoria no sed',
                'value' => '',
                'is_enabled' => true,
            ],
            [
                'key' => 'municipio',
                'description' => 'ID do municipio no sed',
                'value' => '',
                'is_enabled' => true,
            ]
        ];
        DB::table('sed_configs')->where('key', 'system')->delete();
        DB::table('sed_configs')->insert($configs);
    }
}
