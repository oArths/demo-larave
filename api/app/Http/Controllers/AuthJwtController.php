<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthJwtController extends Controller
{
private $key;

public function __construct(){
    $this->key = 'lua';
}

public function Create_Jwt(Request $email){

    $email = $email['email'];
    $header = [
        'typ' => 'JWT',
        'alg' => 'HSR256'
    ];

    $now = time();
    
    $payload = [
        'create' => $now,
        'exp' => $now + 3600,
        'email' => $email
    ];

    $header = base64_encode(json_encode($header));
    $payload = base64_encode(json_encode($payload));

    $sing = base64_encode(hash_hmac('sha256', $header . "." . $payload, $this->key, true));

    $token = "Bearer " . $header . "." . $payload . "." . $sing;

    return response()->json(['message' => $token], 201);
    // return

}



}
