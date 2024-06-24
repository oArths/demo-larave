<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\AuthJwtController;
use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth')->only('store');
    }
  
    public function index()
    {
        // retonado o UserRecource(Resource faz tratamento de dados)
        // uso ::collection
        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $a = 'iegfifsd';

        return $a;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $data = [
            'fistName' => isset($request['fistName']) && !empty($request['fistName']) ? $request['fistName'] : null,
            'lastName' => isset($request['lastName']) && !empty($request['lastName']) ? $request['lastName'] : null,
            'email' => isset($request['email']) && !empty($request['email']) ? $request['email'] : null,
            'password' => isset($request['password']) && !empty($request['password']) ? $request['password'] : null,
        ];
        if(is_null($data['fistName']) || is_null($data['email']) || is_null($data['password']) || is_null($data['lastName'])){
            return response()->json(['deu ruim' => $data], 400);
        }
        // $a = User::get('fistName');
        // return $a;

        $exist = User::where('email', $data['email']);
         
        if($exist){
            return response()->json(['message' => 'usuario ja cadastrado'], 404);
        }

        $create = User::create([
            'fistName' => $data['fistName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        if($create){
            return response()->json(['message' => 'usuario cadastradoi com saucesso'], 201);
        }else{
            return response()->json(['message' => 'usuario não cadast5ror'], 401);

        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::where('id', $id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('fullName');
        $update = User::where('id', $id)->update($data);

    if($update){
        return response()->json(['message' => 'User foi atualizado com sucesso'], 200);
    }else{
        return response()->json(['message' => 'User não foi atualixado '], 500);

    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = null)
    {
         if(!isset($id) || empty($id)){
            return response()->json(['message' => 'valor vazio ou não definido'], 404);

         } 
         $delete = User::where('id', $id)->delete();

         if($delete ){
            return response()->json(['message' => "usuario com o id $id foi deletado"]);
         }else{
            return response()->json(['message' => "usuario não deletada"]);

         }
        // return $id;
    }
}
