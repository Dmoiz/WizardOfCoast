<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
use App\Models\Card;

class CardController extends Controller
{
    public function create(Request $request) {
        $json = $request->getContent();
        $data = json_decode($json);

        $validator = Validator::make(json_decode($json, true),[
            'name' => 'required|max:30',
            'description' => 'required|max:50',
            'collection_id' => 'required|exists:collections,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'Errores' => $validator->errors(),
            ], 422);
        } else {
            try {
                // TODO: Comprobar que el usuario esté logeado
                // TODO: Comprobar que el usuario logeado sea admin
                // TODO: Si no hay colección OK, pero si no hay carta ?? 
            } catch (Exception $e) {
                return response([
                    "message" => "Algo no ha ido como debería"
                ], 500);
            }
        }
    }
}
