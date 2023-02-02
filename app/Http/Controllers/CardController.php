<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\CollectionCard;
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
            $card = new Card();
            $card->name = $data->name;
            $card->description = $data->description;
            $card->collection_id = $data->collection_id;
            try {
                $card->save();
            } catch (Exception $e) {
                return response([
                    "message" => "Algo no ha ido como debería"
                ], 500);
            } 
            $collectionCard = new CollectionCard();
            $collectionCard->cards_id = $card->id;
            $collectionCard->collections_id = $data->collection_id;
            try {
                $collectionCard->save();
            } catch (Exception $e) {
                return response([
                    "message" => "Algo no ha ido como debería"
                ], 500);
            }
        }
        return response()->json([
            'Carta' => $card,
            'Message' => 'Carta creada correctamente'
        ], 200);
    }
}
