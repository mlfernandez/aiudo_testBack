<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



        // crear una cuenta bancaria para un usuario - requiere token admin
        // POST http://localhost:8000/api/accounts
     
    public function store(Request $request)
    {
        //

        $user = auth()->user();

        if($user->profile === "admin"){

            $this->validate($request, [
                'number' => 'required|min:10',
                'type' => 'required',
                'currency' => 'required',
                'user_id' => 'required',

            ]);

            $account = Account::create([
                'number' => $request->number,
                'type' => $request->type,
                'currency' => $request->currency,
                'user_id' => $request->user_id,
            ]);

            if (!$account) {
                return response() ->json([
                    'success' => false,
                    'data' => 'No es posible realizar esta acción.'], 400);
            } else {
                return response() ->json([
                    'success' => true,
                    'data' => $account,
                ], 200);
            }
        } else {

            return response() ->json([
                'success' => false,
                'message' => 'Debes ser administrador.',
            ], 400);

        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */

     // ver las cuentas de un usuario, solo necesita token del usuario
     // GET http://localhost:8000/api/accounts/userid
    public function show(Request $request)
    {
        $user = auth()->user();

        if($user){

            $account = Account::where('user_id', '=', $user->id)->get();

            if(!$account){
                return response() ->json([
                    'success' => false,
                    'message' => 'No tiene ninguna cuenta.',
                ], 400);
    
            } elseif ($account->isEmpty()) {
                return response() ->json([
                    'success' => false,
                    'message' => 'No se encontró ninguna cuenta.',
                    ], 400);
            } else {    
            return response() ->json([
                'success' => true,
                'data' => $account,
            ], 200);
            }
    
        } else {
    
            return response() ->json([
                'success' => false,
                'message' => 'Necesitas ser el usuario creador para realizar esta acción.',

            ], 400);
    
        }
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
