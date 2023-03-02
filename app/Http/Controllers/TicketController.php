<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Achat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json([
            "success" => true,
            "data" => $tickets
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
                'nom' => 'required|string|max:255',
                'prix' => 'required|numeric|between:0,999999.99',
                'description' => 'required|string',
                'date_limite' => 'required|date_format:Y-m-d H:i:s',
                'change_prix' => 'nullable|numeric|between:0,999999.99',
                'change_date' => 'nullable|date_format:Y-m-d H:i:s',
                'evenement_id' => 'required|exists:evenements,id'
            ]);

            if (!$validate->fails()) {
                $tickets = Ticket::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $tickets,
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
            $ticket = Ticket::find($id);
            if ($ticket !== null) {
                return response()->json([
                    "success" => true,
                    "data" => $ticket
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de ticket n'existe pas",
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
                'nom' => 'required|string|max:255',
                'prix' => 'required|numeric|between:0,999999.99',
                'description' => 'required|string',
                'date_limite' => 'required|date_format:Y-m-d H:i:s',
                'change_prix' => 'nullable|numeric|between:0,999999.99',
                'change_date' => 'nullable|date_format:Y-m-d H:i:s',
                'evenement_id' => 'required|exists:evenements,id'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Echec de la mise à jour",
                    "errors" => $validate->errors()
                ], 400);
            }

            $ticket = Ticket::find($id);

            if ($ticket !== null) {
                $ticket->fill($request->all());
                $ticket->save();

                return response()->json([
                    "success" => true,
                    "data" => $ticket
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de ticket n'existe pas",
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
            $ticket = Ticket::find($id);

            if ($ticket !== null) {
                $ticket->delete();
                return response()->json([
                    "success" => true,
                    "data" => $ticket
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de ticket n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get all achat for an ticket
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function achats(Request $request, int $id) {
        try {
            $ticket = Ticket::find($id);

            if ($ticket !== null) {
                $achats = Achat::where('ticket_id', '=', $ticket->id)->get();
                
                return response()->json([
                    "success" => true,
                    "data" => $achats
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de ticket n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
}
