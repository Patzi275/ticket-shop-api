<?php

namespace App\Http\Controllers;

use App\Models\Organisateur;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisateurs = Organisateur::all();
        return response()->json([
            "success" => true,
            "data" => $organisateurs
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
                $organisateur = Organisateur::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $organisateur,
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $organisateur = Organisateur::find($id);
            if ($organisateur !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $organisateur
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de organisateur n'existe pas",
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
     * @param  int $id
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
            
            $organisateur = Organisateur::find($id);

            if ($organisateur !== null) {
                $organisateur->fill($request->all());
                $organisateur->save();
                
                return response()->json([
                    "success" => true,
                    "data" => $organisateur
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de organisateur n'existe pas",
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $organisateur = Organisateur::find($id);

            if ($organisateur !== null) {
                $organisateur->delete();
                return response()->json([
                    "success" => true,
                    "data" => $organisateur
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de organisateur n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get all event for an organisateur
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function evenements(Request $request, int $id) {
        return response()->json([
            "success" => true,
            "data" => $id
        ]);
        try {
            $organisateur = Organisateur::find($id);

            if ($organisateur !== null) {
                $evenements = Evenement::where('organisateur_id', '=', $organisateur->id)->get();

                return response()->json([
                    "success" => true,
                    "data" => $evenements
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de organisateur n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
}
