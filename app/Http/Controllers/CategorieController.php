<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::all();
        return response()->json([
            "success" => true,
            "data" => $categories
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
                'nom' => 'required|unique:categories,nom',
            ]);

            if (!$validate->fails()) {
                $categories = Categorie::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $categories,
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
            $categorie = Categorie::find($id);
            if ($categorie !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $categorie
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de categorie n'existe pas",
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
                'nom' => 'required|unique:categories,nom',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }
            
            $categorie = Categorie::find($id);

            if ($categorie !== null) {
                $categorie->fill($request->all());
                $categorie->save();
                
                return response()->json([
                    "success" => true,
                    "data" => $categorie
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de categorie n'existe pas",
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
            $categorie = Categorie::find($id);

            if ($categorie !== null) {
                $categorie->delete();
                return response()->json([
                    "success" => true,
                    "data" => $categorie
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de categorie n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
