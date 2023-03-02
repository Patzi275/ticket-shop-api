<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();
        return response()->json([
            "success" => true,
            "data" => $documents
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

        // nom, fichier, est_principal, evenement_id
        Future<Response> createDocument(data) async {
            var dio = Dio();
            var formData = FormData.fromMap({
                'nom': data['nom'],
                'est_principal': data['est_principal'],
                'taille': data['fichier'].lengthSync(),
                'fichier': await MultipartFile.fromFile(data['fichier'].path),
                'evenement_id': data['evenement_id'],
            });

            return await dio.post('lien', data: formData)
        }
        */
        try {
            $validate = Validator::make($request->all(), [
                'nom' => 'required',
                'fichier' => 'required|file',
                'taille' => 'nullable',
                'est_principal' => 'required|boolean',
                'evenement_id' => 'required|exists:evenements,id',
            ]);

            
            if (!$validate->fails()) {
                $data = $request->all();
                $data['lien'] = $request->file('fichier')->store('storage/app/public/evenements');
                unset($data['fichier']);

                $documents = Document::create($data);
                return response()->json([
                    "success" => true,
                    "data" => $documents,
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
            $document = Document::find($id);
            if ($document !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $document
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de document n'existe pas",
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
                'nom' => 'sometimes|string',
                'fichier' => 'sometimes|file',
                'taille' => 'nullable',
                'est_principal' => 'sometimes|boolean',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }
            
            $document = Document::find($id);

            if ($document !== null) {
                $data = $request->all();
                if ($request->has('fichier')) {
                    $data['lien'] = $request->file('fichier')->store('storage/app/public/evenements');
                    unset($data['fichier']);
                }

                $document->fill($data);
                $document->save();
                
                return response()->json([
                    "success" => true,
                    "data" => $document
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de document n'existe pas",
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
        // TODO: Suppprimer le document dans storage
        try {
            $document = Document::find($id);

            if ($document !== null) {
                $document->delete();
                return response()->json([
                    "success" => true,
                    "data" => $document
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de document n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
