<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organisateur;
use App\Models\Achat;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Get all achat for an user
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function achats(Request $request, int $id) {
        try {
            $user = User::find($id);

            if ($user !== null) {
                $achats = Achat::where('user_id', '=', $user->id)->get();
                
                return response()->json([
                    "success" => true,
                    "data" => $achats
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de user n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 

    /**
     * Get the organisateur behing an user
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    function organisateur(Request $request, int $id) {
        try {
            $user = User::find($id);

            if ($user !== null) {
                $organisateur = Organisateur::where('user_id', '=', $user->id)->first();
                
                return response()->json([
                    "success" => true,
                    "data" => $organisateur
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Cet 'id' de user n'existe pas",
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    } 
}
