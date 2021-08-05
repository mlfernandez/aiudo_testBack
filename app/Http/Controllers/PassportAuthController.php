<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;


class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2',
            'lastName' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'DNI'=> 'required|min:9',
            'dateBirth'=> 'required',
            'address'=> 'required|min:4',
            'city' => 'required|min:3',
            'zipCode'=> 'required',
            'country'=> 'required|min:3',
            'movilPhone' => 'required|min:9'
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'DNI' => $request->DNI,
            'dateBirth' => $request->dateBirth,
            'address' => $request->address,
            'city' => $request->city,
            'zipCode' => $request->zipCode,
            'country' => $request->country,
            'movilPhone' => $request->movilPhone,
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function forgot(ForgotRequest $request) {

        $email = $request->input(key:'email');

        if (User::where('email', $email)->doesntExist()){
            return response([
                'message' => 'Usuario no encontrado.'
            ], status:404);
        }

        $token = Str::random(length: 10);

        try {

            DB::table(table: 'password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);


            Mail::send('Mails.forgot', ['token' => $token], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Cambie su contraseña');
                $message->setBody('Hola');

            });

            return response([
                'message' => 'Verifica tu email'
            ]);

        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], status: 400);
        }

    }


    /** @var User $user */
    public function reset (ResetRequest $request) {

        $token = $request->input(key: 'token'); 

        if (!$passwordResets = DB::table('password_resets')->where('token', $token)->first()) {
            return response([
                'message' => 'Token inválido.'
            ], status:400);
        }

        if (!$user = User::where('email', $passwordResets->email)->first()) {
            return response([
                'message' => 'Usuario no existe.'
            ], status:404);
        }

        $user->password = Hash::make($request->input(key: 'password'));
        $user->save();

        return response([
            'message' => 'Cambio realizado con exito.'
        ]);
    }

}
