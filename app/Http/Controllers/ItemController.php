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
            ->leftJoin('equipeds', 'equipeds.inventory_id', '=', 'inventories.id')
            ->leftJoin('characters', 'characters.id', '=', 'equipeds.character_id')
            ->join('item_refs', 'item_refs.id', '=', 'inventories.item_ref_id')
            ->join('item_categories', 'item_categories.id', '=', 'item_refs.item_categorie_id')
            ->join('item_rarities', 'item_rarities.id', '=', 'item_refs.item_rarity_id')
            
            ->paginate(10, [  // pagination.
                'inventories.id as id',
                'inventories.quantity as quantity',
                DB::raw('COUNT(characters.id) as equiped_quantity'),
                'item_refs.name as name',
                'item_refs.price as price',
                'item_refs.level as level',
                'item_categories.name as item_categorie',
                'item_rarities.name as item_rarity',

            ])
        );

        // send characters to the view.
        return view('log.inventory', [
            'items' => $items
        ]);

    }
}
