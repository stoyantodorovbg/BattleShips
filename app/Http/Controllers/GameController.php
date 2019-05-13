<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShotRequest;

class GameController extends Controller
{
    public function battleShips()
    {
        return view('games.index');
    }

    public function shot(ShotRequest $request)
    {

    }
}
