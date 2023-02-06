<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Card;

class CollectionController extends Controller
{
    public function create(Request $request) {
        $json = $request->getContent();
        $data = json_decode($json);

        $validator = Validator::make(json_decode($json, true),[
            'name' => 'required|max:30',
            'symbol' => 'required|max:50',
            'release_date' => 'required|date',
            'card_id' => 'exists:cards,id'
        ]);

        /* $card_validator = Validator::make(json_decode($json, true), [
            'name' => 'required|max:30',
            'symbol' => 'required|max:50',
            'release_date' => 'required|date',
            'card_name' => 'required|max:30',
            'card_description' => 'required|max:50'
        ]);  */

        if($validator->fails() /* || $card_validator->fails() */) {
            return response([
                'Errores' => $validator->errors()
                /* 'Errores' => $card_validator->errors() */

            ], 422);
        } else {
            $collection = new Collection();
            $collection->name = $data->name;
            $collection->symbol = $data->symbol;
            $collection->release_date = $data->release_date;
            if(isset($data->card_id)) {
                try {
                    $collection->save();
                    $card = Card::find($data->card_id);
                    $card->collections()->attach($collection->id);
                    return response([
                        'Colección' => $collection,
                        'Carta' => $card,
                        'Message' => 'Colección creada correctamente'
                    ]);
                } catch (Exception $e) {
                    return response([
                        "message" => "Algo no ha ido como debería"
                    ], 500);
                } 
            } else if(isset($data->card_name) && isset($data->card_description)) {
                $newCard = new Card();
                $newCard->name = $data->card_name;
                $newCard->description = $data->card_description;
                try {
                    $collection->save();
                    $newCard->save();
                    $collectionFind = Collection::find($collection->id);
                    $collectionFind->cards()->attach($newCard->id);
                    return response([
                        'Colección' => $collection,
                        'Carta' => $newCard,
                        'Message' => 'Carta creada correctamente'
                    ]);
                } catch(Exception $e) {
                    return response([
                        "message" => "Algo no ha ido como debería"
                    ], 500);
                }
            } else {
                return response([
                    "message" => "Si no hay una carta asignada, crea o añade una por favor"
                ]);
            }
        }
        return response()->json([
            'Message' => 'Todo ha funcionado correctamente'
        ], 200);
    }
}
