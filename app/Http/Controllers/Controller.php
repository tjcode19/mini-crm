<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use \Firebase\JWT\JWT;

class Controller extends BaseController
{
    public $input;

    protected function createToken($auth) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $data = json_decode($auth);
        return JWT::encode([
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'type' => $data->type,
            'company_id' => $data->company_id,
            'employee_id' => $data->employee_id,
        ], config('const.AUTH_KEY'));
    }

    function generate_string($strength = 10) {
        $input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
    
        return $random_string;
    }
}
