<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    private $key;

    public function __construct(){
        $this->key = 'lua';
    }
 
    
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $this->getBearerToken($request);
        if(!$token){
            return response()->json(['error'=> 'token expiorado ou invalido'], 401);
        }
        $valid = $this->valid_token($token);

        if(!$valid){
            return response()->json(['error'=> 'token expiorado ou invalido'], 401);
        }

        $request->merge(['auth' => (array) $valid]);

        // return $request;
        return $next($request);
    }
  
    
    private function getBearerToken($request)
    {
        $data = $request->header('Authorization');
        if(empty($data)){
            return false;
        }
        $token = explode(' ', $data);
        return  $token[1];
        
       
    }
    public function valid_token($token){

        list($header, $payload, $sing) = explode('.', $token);

        $dec_payload = json_decode(base64_decode($payload));
        $valid_sing = base64_encode(hash_hmac('sha256', $header . "." . $payload, $this->key, true));

        if($sing !== $valid_sing){
            return false;
        }
        if($dec_payload->exp < time()){
            return false;
        }
        return $dec_payload;

    }
}
