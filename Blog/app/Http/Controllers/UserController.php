<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);

        $email    = $request->input('email');
        $password = Hash::make($request->input('password'));

        User::create([
            'email'    => $email,
            'password' => $password
        ]);

        try {
            $response = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => [],
            ];
        } catch (\Throwable $th) {
            $response = [
                'code'    => 500,
                'message' => 'Success',
                'data'    => $th->getMessage(),
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        $email    = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'code'    => 500,
                'message' => 'Email not found',
            ], 500);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json([
                'code'    => 500,
                'message' => 'Password matchless',
            ], 500);
        }

        $generateToken = bin2hex(random_bytes(40));

        $dataToken = [
            'token' => $generateToken
        ];
        $user->update($dataToken);

        try {
            $response = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => $dataToken,
            ];
        } catch (\Throwable $th) {
            $response = [
                'code'    => 500,
                'message' => 'Failed',
                'data'    => $th->getMessage(),
            ];
        }

        return response()->json($response);
    }

    public function getDataUser(Request $request)
    {
        $token = $request->header('SUNTOKEN');

        if (!$token) {
            return response()->json([
                'code'    => 404,
                'message' => 'SUNTOKEN not found',
            ], 404);
        }

        $getDataUser = User::where('token', $token)->first();
        $response = [
            'code'    => 200,
            'message' => 'Success',
            'data'    => $getDataUser,
        ];

        return response()->json($response, $response['code']);
    }
}
