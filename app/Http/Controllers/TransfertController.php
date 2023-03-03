<?php

namespace App\Http\Controllers;

use App\Models\Transfert;
use App\Models\Organisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferts = Transfert::all();
        return response()->json([
            "success" => true,
            "data" => $transferts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'somme' => 'required|numeric|between:0,999999.99',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'organisateur_id' => 'required|exists:organisateurs,id',
            ]);

            if (!$validate->fails()) {
                $transferts = Transfert::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $transferts,
                ], 201);
            }

            return response()->json([
                "success" => false,
                "message" => "Echec de l'enregistrement",
                "errors" => $validate->errors()
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $transfert = Transfert::find($id);
            if ($transfert !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $transfert
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de transfert n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'somme' => 'required|numeric|between:0,999999.99',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'est_confirmer' => 'required|boolean',
                'organisateur_id' => 'required|exists:organisateurs,id',            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }

            $transfert = Transfert::find($id);

            if ($transfert !== null) {
                $transfert->fill($request->all());
                $transfert->save();

                return response()->json([
                    "success" => true,
                    "data" => $transfert
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de transfert n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $transfert = Transfert::find($id);

            if ($transfert !== null) {
                $transfert->delete();
                return response()->json([
                    "success" => true,
                    "data" => $transfert
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de transfert n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Validate a transfert
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function valider(Request $request, int $id) {
        try {
            $transfert = Transfert::find($id);

            if ($transfert !== null) {
                $organisateur = Organisateur::find($transfert->organisateur_id);
                if ($organisateur == null) {
                    return response()->json([
                        "success" => false,
                        "message" => "La transfert n'a pas d'utilisateur associé"
                    ], 500);
                }

                $transfert->valider = true;
                $organisateur->role = "organisateur";
                $organisateur->save();
                $transfert->save();
                
                return response()->json([
                    "success" => true,
                    "message" => "Acceptation de transfert reussie"
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de transfert n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
}
