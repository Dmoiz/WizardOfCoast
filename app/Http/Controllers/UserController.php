<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserController extends Controller
{
    public function create(Request $request) {
        $json = $request->getContent();
        $data = json_decode($json);

        $validator = Validator::make(json_decode($json, true),[
            'name' => 'required|min:3|max:10|unique:users,name',
            'email' => 'required|email|max:30',
            'password' => ['required', Password::min(4)->mixedCase()],
            'role' => 'required|in:Particular,Profesional,Administrador'
        ]);

        if($validator->fails()) {
            return response()->json([
                'Errores' => $validator->errors(),
            ], 422);
        };

        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->role = $data->role;

        try {
            $user->save();
        } catch (Exception $e){

        }
        

        return response()->json($data, 201);
    }

    public function login(Request $request) {
        $json = $request->getContent();
        $data = json_decode($json);

        $validator = Validator::make(json_decode($json, true),[
            'name' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        if($validator->fails()) {
            return response()->json([
                'Errores' => $validator->errors(),
            ], 422);
        } else {
            try {
                $user = User::where('name', 'like', $data->name)->firstOrFail();

                if(!Hash::check($data->password, $user->password)) {
                    return "La contraseña es incorrecta";
                } else {
                    $user->tokens()->delete();
                    $token = $user->createToken($user->name, [$user->role]);
 
                    return ['token' => $token->plainTextToken];
                    return "Todo piola";
                }

            } catch(\Exception $e) {
                return response()->json([
                    'Message' => 'Ha ocurrido un error al hacer login'
                ], 500);
            }
        }
        return response()->json($data, 201);
    }

    public function recover_password(Request $request) {
        $json = $request->getContent();
        $data = json_decode($json);

        $validator = Validator::make(json_decode($json, true),[
            'email' => 'required|email|exists:users,email'
        ]);

        if($validator->fails()) {
            return response()->json([
                'Errores' => $validator->errors(),
            ], 422);
        } else {
            try {
                $user = User::where('email', 'like', $data->email)->firstOrFail();
                $newPassword = Str::random(10);
                $user->password = Hash::make($newPassword);
                $user->save();
                if($user) {
                    return response([
                        "Contraseña" => $newPassword
                    ]);
                }
            } catch(Exception $e) {
                return response([
                    "message" => "Ha habido un problema validando el usuario"
                ]);
            }
        }
    }
}
