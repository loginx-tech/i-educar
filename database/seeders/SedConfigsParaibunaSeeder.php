<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedConfigsParaibunaSeeder extends Seeder
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
                'value' => 'PARAIBUNA',
                'is_enabled' => true, // Marca se o sistema esta com as funções do sed habilitadas, caso false nenhuma das funções serao executadas, apenas ieducar rodando.
            ],
            [
                'key' => 'diretoria',
                'description' => 'ID da diretoria no sed',
                'value' => '20207',
                'is_enabled' => true, //Nessa configuração é necessário habilitar o sed para que o sistema funcione
            ],
            [
                'key' => 'municipio',
                'description' => 'ID do municipio no sed',
                'value' => '9267',
                'is_enabled' => true, //Nessa configuração é necessário habilitar o sed para que o sistema funcione
            ]
        ];
        DB::table('sed_configs')->delete();
        DB::table('sed_configs')->insert($configs);
    }
}
