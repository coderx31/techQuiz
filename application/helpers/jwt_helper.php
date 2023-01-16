<?php

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    // TODO: need to find a way to get the jwt_key
    //$key = 'example_key';

    function generateJWTToken($data) {
        $token = JWT::encode($data, 'example_key', 'HS256');
        return $token;
    }

    function decodeJWTToken($token) {
        try {
            $data = JWT::decode($token, new Key('example_key', 'HS256'));
            return $data;
        } catch (Exception $e) {
            $data = [
                'user_id' => '',
                'username' => ''
            ];
            // TODO: need to handle the error gracefully
            return $data;
        }
    }

    function validateJWTToken($token) {
        // TODO
        try {
           $data = decodeJWTToken($token);
           return true;
        } catch (Exception $e) {
            return false;
        }
    }

?>