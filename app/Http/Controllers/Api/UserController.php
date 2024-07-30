<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::api([
            'message' => 'All users!',
            'data' => User::all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Response::api([
            'message' => 'All users!',
            'data' => $user
        ]);
    }
}
