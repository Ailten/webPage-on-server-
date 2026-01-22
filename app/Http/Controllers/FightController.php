<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FightController extends Controller
{
    
    public function getFightHub(Request $request) {
        return view('log.fight.fightHub');
    }
}
