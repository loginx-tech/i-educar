<?php

namespace App\Services\Sed;

use App\Enums\{SedRouters};
use Illuminate\Support\Facades\{DB, Http, Schema};

class AuthService
{
    /**
     * Verifica se o sed está habilitado
     *
     * @return string
     */
    public function getConfigSystemSed()
    {
        if (Schema::hasTable('sed_configs')) {
            $sed = DB::table('sed_configs')->where('key', 'system')->first();
            if ($sed) {
                $cidade = $sed->value;

                if ($sed->is_enabled) {
                    return $cidade;
                }
            }
        }
        return null;
    }

    /**
     * Pega o token de autentificação do sed no banco de dados
     *
     * @return string
     */
    public function getAccessToken()
    {
        $accessToken = DB::table('sed_access_token')->first();
        // Caso token não esteja cadastrado no banco de dados
        if (!$accessToken) {
            self::generateAccessToken(new: true);
            $accessToken = DB::table('sed_access_token')->first();
        }

        return $accessToken->token;
    }

    /**
     * Função responsavel por gerar novos tokens
     *
     * @return void
     */
    public function generateAccessToken($new = false): void
    {
        $cidade = self::getConfigSystemSed();
        if (!$cidade) {
            abort(403, 'Sistema não configurado para utilizar o sed');
        }

        //Acessa a config de cada cidade
        $user_sed = env('SED_USER_' . strtoupper($cidade));
        $password_sed = env('SED_PASSWORD_' . strtoupper($cidade));

        if (!$user_sed || !$password_sed) {
            abort(403, 'Sistema não configurado para utilizar o sed em ' . $cidade . '.');
        }

        $response = Http::withOptions(
                ['verify' => false]
            )->withBasicAuth(
                $user_sed,
                $password_sed
            )->get(
                config('sed.url') . SedRouters::VALIDA_USUARIO->value
            );

        self::storeAccessToken($response->object()->outAutenticacao, $new);
    }

    /**
     * Salva o token de autentificação no banco de dados
     *
     * @param string $token
     *
     * @return void
     */
    public function storeAccessToken($token, $new): void
    {
        if ($new) {
            DB::table('sed_access_token')
                ->insert([
                    'token' => $token,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('sed_access_token')
                ->update([
                    'token' => $token,
                    'updated_at' => now(),
                ]);
        }

        // Implementar fila
    }

    /**
     * Abstrai a lógica de de consumo de api do sed em rotas GET
     *
     * @param string $route
     * @param  array?  $body
     * @param  array?  $headers
     *
     * @return void
     */
    public function get($route, $body = [], $headers = [])
    {
        $response = Http::withOptions(['verify' => false])->withToken($this->getAccessToken())->retry(3, 100, function ($exception, $request) {
            // Caso o token esteja expirado, gera um novo token e tenta novamente
            if ($exception->response->status() !== 401) {
                return false;
            }

            self::generateAccessToken();
            $request->withToken($this->getAccessToken());

            return true;
        })
        ->withHeaders($headers)
        ->get(config('sed.url') . $route, $body);

        // if ($response->failed()) {
        //     dd('Erro get do auth do sed', $response->object());
        // }

        return $response;
    }

    /**
     * Abstrai a lógica de de consumo de api do sed em rotas POST
     *
     * @param string $route
     * @param  array?  $body
     * @param  array?  $headers
     *
     * @return void
     */
    public function post($route, $body = [], $headers = [])
    {
        $response = Http::withOptions(['verify' => false])->withToken($this->getAccessToken())->retry(3, 100, function ($exception, $request) {
            // Caso erros comuns, retorna false para tentar novamente
            if ($exception->response->status() !== 401) {
                return false;
            }

            self::generateAccessToken();
            $request->withToken($this->getAccessToken());

            return true;
        }, throw: false)
        ->withHeaders($headers)
        ->post(config('sed.url') . $route, $body);

        return $response;
    }
}
