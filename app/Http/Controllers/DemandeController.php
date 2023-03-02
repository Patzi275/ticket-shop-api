<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\User;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demandes = Demande::all();
        return response()->json([
            "success" => true,
            "data" => $demandes
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
                'info_org' => 'required',
                'info_exp' => 'required',
                'user_id' => 'required|exists:users,id',
            ]);

            if (!$validate->fails()) {
                $demandes = Demande::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $demandes,
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
            $demande = Demande::find($id);
            if ($demande !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $demande
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de demande n'existe pas",
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
                'info_org' => 'required',
                'info_exp' => 'required',
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }
            
            $demande = Demande::find($id);

            if ($demande !== null) {
                $demande->fill($request->all());
                $demande->save();
                
                return response()->json([
                    "success" => true,
                    "data" => $demande
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de demande n'existe pas",
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
            $demande = Demande::find($id);

            if ($demande !== null) {
                $demande->delete();
                return response()->json([
                    "success" => true,
                    "data" => $demande
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de demande n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get the user of for an demande
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function utilisateur(Request $request, int $id) {
        try {
            $demande = Demande::find($id);

            if ($demande !== null) {
                $user = User::where('id', '=', $demande->user_id)->first();
                
                return response()->json([
                    "success" => true,
                    "data" => $user
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de demande n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
    
    /**
     * Get all pieces for an demande
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function pieces(Request $request, int $id) {
        try {
            $demande = Demande::find($id);

            if ($demande !== null) {
                $pieces = Piece::where('demande_id', '=', $demande->id)->get();
                
                return response()->json([
                    "success" => true,
                    "data" => $pieces
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de demande n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
}
