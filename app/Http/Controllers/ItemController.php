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
            'name' => '',
            'memo' => '',
            'price' => '',
            'is_selling' => '',
        ]);

        $item = Item::create([
            'name' => $data['name'],
            'memo' => $data['memo'],
            'price' => $data['price'],
            'is_selling' => $data['is_selling'],
        ]);

        return new ResourcesItem($item);
    }
}
