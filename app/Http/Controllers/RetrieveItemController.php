<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Item as ResourcesItem;
use App\Models\Item;

class RetrieveItemController extends Controller
{
    public function retrieveItem(Request $request)
    {
        $item = Item::find($request->item_id);

        if(is_null($item)) {
            return to_route('items.index', [
                'error' => 'Sorry, Not Found Item.',
            ]);
        }

        return new ResourcesItem($item);
    }
}
