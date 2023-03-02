<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $achats = Achat::all();
        return response()->json([
            "success" => true,
            "data" => $achats
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
                'nombre' => 'required|integer|min:1',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'ticket_id' => 'required|exists:tickets,id',
                'user_id' => 'required|exists:users,id',
            ]);

            if (!$validate->fails()) {
                $achats = Achat::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $achats,
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
            $achat = Achat::find($id);
            if ($achat !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $achat
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de achat n'existe pas",
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
                'nombre' => 'required|integer|min:1',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'ticket_id' => 'required|exists:tickets,id',
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }

            $achat = Achat::find($id);

            if ($achat !== null) {
                $achat->fill($request->all());
                $achat->save();

                return response()->json([
                    "success" => true,
                    "data" => $achat
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de achat n'existe pas",
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
            $achat = Achat::find($id);

            if ($achat !== null) {
                $achat->delete();
                return response()->json([
                    "success" => true,
                    "data" => $achat
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de achat n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get the ticket for an achat
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function ticket(Request $request, int $id) {
        try {
            $achat = Achat::find($id);

            if ($achat !== null) {
                $ticket = Ticket::where('id', '=', $achat->ticket_id)->first();
                
                return response()->json([
                    "success" => true,
                    "data" => $ticket
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de achat n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get the user for an achat
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function utilisateur(Request $request, int $id) {
        try {
            $achat = Achat::find($id);

            if ($achat !== null) {
                $user = User::where('id', '=', $achat->user_id)->first();
                
                return response()->json([
                    "success" => true,
                    "data" => $user
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de achat n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
}
