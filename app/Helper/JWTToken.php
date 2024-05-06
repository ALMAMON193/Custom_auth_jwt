<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
  public static  function generateToken($userEmail): string
  {
    $key = env('JWT_SECRET');
    $payload = array(
      'iss' => "laravel-token",
      'iat' => time(),
      'userEmail' => $userEmail,
  
      'exp' => time() + 3600,


    );
    return JWT::encode($payload, $key, 'HS256');
  }

  //Reset password

  public static  function CreateTokenForSetPassword($userEmail): string
  {
    $key = env('JWT_SECRET');
    $payload = array(
      'iss' => "laravel-token",
      'iat' => time(),
      'userEmail' => $userEmail,
      'userID' => '0',
      'exp' => time() + 60 * 20,


    );
    return JWT::encode($payload, $key, 'HS256');
  }

  public static function VerifyToken($token): string
  {
   
    try {
      $key = env('JWT_SECRET');
      $decoded = JWT::decode($token, new Key($key, 'HS256'));
      return $decoded;
    } catch (\Exception $e) {
      return 'unauthorized';
    }
  }
}
