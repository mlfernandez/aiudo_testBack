<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        // El administrador busca a todos los usuarios
        // GET http://localhost:8000/api/users
        // Por postman el "token" del administrador 
    public function index()
    {
        $user = auth()->user();
        $users = User::all();

        if($user->profile==="admin"){
            return response() ->json([
                'success' => true,
                'data' => $users,
            ]);
        }
        return response() ->json([
            'success' => false,
            'data' => 'Necesitas ser administrador.'
        ], 400);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

        // El user puede buscar sus datos por id
        // GET http://localhost:8000/api/users/{$id}
        // se pasa la "id" por url
    public function show($id)
    {
        //
            $user = auth()->user()->find($id);
            if(!$user){
                return response() ->json([
                    'success' => false,
                    'message' => 'User no encontrado',
                ], 400);
            }
            return response() ->json([
                'success' => true,
                'data' => $user,
            ], 200);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

     

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */


    public function destroy()
    {
        //

    }

        // funcion logout de usuario 
        // POST http://localhost:8000/api/users/logout
        // pasar "token" por postman
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token ->revoke();

        return response()->json('Gracias por confiar en nosotros, ¡hasta luego!');
    }
}

