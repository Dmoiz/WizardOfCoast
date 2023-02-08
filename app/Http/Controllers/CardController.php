<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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
            'collection_id' => 'exists:collections,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'Errores' => $validator->errors(),
            ], 422);
        } else {
            $card = new Card();
            $card->name = $data->name;
            $card->description = $data->description;
            if(isset($data->collection_id)) {
                try {
                    $card->save();
                    $collection = Collection::find($data->collection_id);
                    $collection->cards()->attach($card->id);
                    return response([
                        'Carta' => $card,
                        'Message' => 'Carta creada correctamente'
                    ]);
                } catch (Exception $e) {
                    return response([
                        "message" => "Algo no ha ido como debería"
                    ], 500);
                } 
            } else if(isset($data->collection_name) && isset($data->collection_symbol) && isset($data->collection_release_day)) {
                $newCollection = new Collection();
                $newCollection->name = $data->collection_name;
                $newCollection->symbol = $data->collection_symbol;
                $newCollection->release_date = $data->collection_release_day;
                try {
                    $card->save();
                    $newCollection->save();
                    $cardFind = Card::find($card->id);
                    $cardFind->collections()->attach($newCollection->id);
                    return response([
                        'Colección' => $newCollection,
                        'Carta' => $card,
                        'Message' => 'Carta creada correctamente'
                    ]);
                } catch (Exception $e) {
                    return response([
                        "message" => "Algo no ha ido como debería"
                    ], 500);
                }
            } else {
                return response([
                    "message" => "Si no hay una colección asignada, crea o añade una por favor"
                ]);
            }
        }
        return response()->json([
            'Carta' => $card,
            'Message' => 'Carta creada correctamente'
        ], 200);
    }

    public function searcher($name) {
        try {
            $card = Card::select('id', 'name', 'description')
            ->where('name','like','%'.$name.'%')->get();
        } catch(Exception $e) {
            return response([
                'message' => 'No se ha encontrado una carta que coincida con el nombre'
            ]);
        }
        return response([
            'card' => $card
         ]);
        
    }

    public function sell(Request $request, $name) {
        // Buscar carta por nombre
        $json = $request->getContent();
        $data = json_decode($json);

        $validator = Validator::make(json_decode($json, true),[
            //'card_id' => 'required|exists:cards,id',
            'price' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'Errores' => $validator->errors(),
            ], 422);
        } else {
            //$user = Auth::id();
            $searchCard = Card::where('name', 'like', '%'.$name.'%')->get();
            //$card = Card::find($searchCard->id);
            //$searchCard->users()->attach($user, ['price' => $data->price, 'amount' => $data->amount]);

            return response([
                'Carta' => $searchCard
            ]);
        }
        return response([
            'Carta' => 'Bien'
        ]);
        // Comprobar que la carta exista 
        // Mostrar las cartas que coincidan
        // Mostrar los datos de cada carta
    }

    public function buy($name) {

    }

    public function edit(Request $request, $id) {
        $json = $request->getContent();
        $data = json_decode($json);

        $validator = Validator::make(json_decode($json, true),[
            'name' => 'filled|max:30',
            'description' => 'filled|max:50',
            'collection_id' => 'filled|exists:collections,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'Errores' => $validator->errors(),
            ], 422);
        } else {
            $card = Card::find($id);
            $card->name = $data->name;
            $card->description = $data->description;
            try {
                $card->save();
                $collection = Collection::find($data->collection_id);
                $collection->cards()->attach($card->id);
                return response([
                    'Carta' => $card,
                    'Message' => 'Carta editada correctamente'
                ]);
            } catch (Exception $e) {
                return response([
                    "message" => "Algo no ha ido como debería"
                ], 500);
            } 
        }
        return response()->json([
            'Carta' => $card,
            'Message' => 'Carta editada correctamente'
        ], 200);
    }
}
