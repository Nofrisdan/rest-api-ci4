<?php

// load tabel akses
use App\Models\Tb_akses;
use App\Models\Tb_user;

use Firebase\JWT\JWT;


// cek jwt
function getJWT($header_auth)
{
    if (is_null($header_auth)) {
        throw new Exception("Otentikasi JWT Gagal");
    }

    return explode(" ", $header_auth)[1];
}


// memvalidasi JWT
function validateJWT($encodeJWT)
{
    // ambil jwt key dari .env
    $key = getenv("JWT_SECRET_KEY");
    $decodedJWT = JWT::decode($encodeJWT, $key, ['HS256']);

    // return $decodedJWT;

    // cek email tb_akses;
    $tb_user = new Tb_user();
    $tb_akses = new Tb_akses();

    if ($tb_user->cekEmail($decodedJWT->email) !== false) {
        return $tb_akses->getIdUser($tb_user->cekEmail($decodedJWT->email));
    }
}


// membuat JWT
function createJWT($email)
{
    // ambil waktu skrg
    $waktuRequest = time();
    $key = getenv("JWT_SECRET_KEY");
    $waktuToken = getenv("JWT_TIME_LIVE");
    $waktuExpired = $waktuRequest + $waktuToken;
    $payload = [
        "email" => $email,
        "iat" => $waktuRequest,
        "exp" => $waktuExpired
    ];

    // membuat jwt
    $jwt = JWT::encode($payload, $key, ['HS256']); // ['H256'] merupakan algoritma code jwt

    return $jwt;
}
