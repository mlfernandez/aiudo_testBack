<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

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
}
