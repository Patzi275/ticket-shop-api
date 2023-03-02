<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Ticket;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evenements = Evenement::all();
        return response()->json([
            "success" => true,
            "data" => $evenements
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
                'titre' => 'required|unique:evenements,titre',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'lieu' => 'required',
                'description' => 'required',
                'contact' => 'required',
                'organisateur_id' => 'required|exists:organisateurs,id|nullable',
                'categorie_id' => 'required|exists:categories,id|nullable',
            ]);

            if (!$validate->fails()) {
                $evenements = Evenement::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $evenements,
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
            $evenement = Evenement::find($id);
            if ($evenement !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $evenement
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de evenement n'existe pas",
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
                'titre' => 'required|unique:evenements,titre',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'lieu' => 'required',
                'description' => 'required',
                'contact' => 'required',
                'organisateur_id' => 'require|exists:organisateurs,id|nullable',
                'categorie_id' => 'require|exists:categories,id|nullable',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }
            
            $evenement = Evenement::find($id);

            if ($evenement !== null) {
                $evenement->fill($request->all());
                $evenement->save();
                
                return response()->json([
                    "success" => true,
                    "data" => $evenement
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de evenement n'existe pas",
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
            $evenement = Evenement::find($id);

            if ($evenement !== null) {
                $evenement->delete();
                return response()->json([
                    "success" => true,
                    "data" => $evenement
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de evenement n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

     /**
     * Get all documents for an evenement
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function documents(Request $request, int $id) {
        try {
            $evenement = Evenement::find($id);

            if ($evenement !== null) {
                $documents = Document::where('evenement_id', '=', $evenement->id)->get();
                
                return response()->json([
                    "success" => true,
                    "data" => $documents
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de evenement n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

     /**
     * Get all tickets for an evenement
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function tickets(Request $request, int $id) {
        try {
            $evenement = Evenement::find($id);

            if ($evenement !== null) {
                $tickets = Ticket::where('evenement_id', '=', $evenement->id)->get();
                
                return response()->json([
                    "success" => true,
                    "data" => $tickets
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de evenement n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
}
