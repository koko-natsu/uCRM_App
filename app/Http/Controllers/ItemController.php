<?php

namespace App\Http\Controllers;

use App\Http\Resources\Item as ResourcesItem;
use App\Http\Resources\ItemCollection;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{

    public function index()
    {
        $items = Item::all();

        return Inertia::render('Items/Index', [
            'items' => new ItemCollection($items)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:50',
            'memo' => 'max:255',
            'price' => 'numeric|min:1',
            'is_selling' => 'boolean',
        ]);

        Item::create([
            'name' => $data['name'],
            'memo' => $data['memo'],
            'price' => $data['price'],
            'is_selling' => $data['is_selling'],
        ]);

        $items = Item::all();
        return new ItemCollection($items);
    }
 
    public function update(Request $request)
    {
        $item = Item::find($request->item_id);

        $data = $request->validate([
            'name' => 'required|max:50',
            'memo' => 'max:255',
            'price' => 'numeric|min:1',
            'is_selling' => 'boolean',
        ]);

        $item->update($data);

        $items = Item::all();
        return new ItemCollection($items);
    }

    public function destroy(Request $request)
    {
        $item = Item::find($request->item_id);

        $item->delete();

        $items = Item::all();
        return new ItemCollection($items);
    }
}
