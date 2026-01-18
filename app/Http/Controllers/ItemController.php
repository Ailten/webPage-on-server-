<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function getInventoryUserLog(Request $request) {

        // get items user has in inventory.
        // get has pagination (include filter option in page).
        $items = []; //Auth::user()-> ...

        // send characters to the view.
        return view('log.inventory', [
            'items' => $items
        ]);

    }
}
