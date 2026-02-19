<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function getInventoryUserLog(Request $request) {

        // get items from inventory user log (in a paginator).
        $items = (
            Auth::user()->inventories()  // get inventory of user log.
            ->withDetailsInventory()
        );

        // send characters to the view.
        return view('log.inventory', [
            'items' => $items
        ]);

    }
}
