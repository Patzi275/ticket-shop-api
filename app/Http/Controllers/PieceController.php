<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pieces = Piece::all();
        return response()->json([
            "success" => true,
            "data" => $pieces
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
        /*
        import 'dart:io';
        import 'package:dio:dio.dart';

        // fichier, demande_id
        Future<Response> createPiece(data) async {
            var dio = Dio();
            var formData = FormData.fromMap({
                'fichier': await MultipartFile.fromFile(data['fichier'].path),
                'demande_id': data['evenement_id'],
            });

            return await dio.post('lien', data: formData)
        }
        */
        try {
            $validate = Validator::make($request->all(), [
                'fichier' => 'required|file',
                'demande_id' => 'required|exists:demandes,id',
            ]);

            
            if (!$validate->fails()) {
                $data = $request->all();
                $data['lien'] = $request->file('fichier')->store('storage/app/public/pieces');
                unset($data['fichier']);

                $pieces = Piece::create($data);
                return response()->json([
                    "success" => true,
                    "data" => $pieces,
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
            $piece = Piece::find($id);
            if ($piece !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $piece
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de piece n'existe pas",
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
        // TODO: Gérer le changement de fichier principal
        // TODO: Gérer les paramètres requiet
        try {
            $validate = Validator::make($request->all(), [
                'fichier' => 'sometimes|file',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }
            
            $piece = Piece::find($id);

            if ($piece !== null) {
                $data = $request->all();
                if ($request->has('fichier')) {
                    $data['lien'] = $request->file('fichier')->store('storage/app/public/pieces');
                    unset($data['fichier']);
                }

                $piece->fill($data);
                $piece->save();
                
                return response()->json([
                    "success" => true,
                    "data" => $piece
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de piece n'existe pas",
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
        // TODO: Suppprimer le piece dans storage
        try {
            $piece = Piece::find($id);

            if ($piece !== null) {
                $piece->delete();
                return response()->json([
                    "success" => true,
                    "data" => $piece
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de piece n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
