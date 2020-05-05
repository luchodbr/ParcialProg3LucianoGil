<?php
use \Firebase\JWT\JWT;
    class Autenticar{

        static function GenerarToken($email){
            $payload = array(
            "iss" => "example.org",
            "aud" => "example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "email"=> $email
        );
        $jwt = JWT::encode($payload, "pro3-parcial");
        return $jwt;
    }

    static function ValidarToken($token){
        try {
            if( $token == "" )
            {return null;}
            $decoded = JWT::decode($token, "pro3-parcial", array('HS256'));
            return $decoded;
            
        } catch (\Throwable $th) {
            return null;
        }
    }

}