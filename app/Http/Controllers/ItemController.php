<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\Item as ResourcesItem;
use App\Http\Resources\ItemCollection;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{

    public function index()
    {
        $items = Item::orderByDesc('created_at')->get();

        return Inertia::render('Items/Index', [
            'items' => new ItemCollection($items)
        ]);
    }


    public function store(StoreItemRequest $validated_data, Item $item)
    {
        $item->create($validated_data->all());

        $items = Item::orderByDesc('created_at')->get();
        return new ItemCollection($items);
    }


    public function update(UpdateItemRequest $validated_data)
    {
        $item = Item::findOrFail(request()->item_id);

        $item->update($validated_data->all());

        $items = Item::orderByDesc('created_at')->get();
        return new ItemCollection($items);
    }


    public function destroy(Request $request)
    {
        $item = Item::find($request->item_id);

        $item->delete();

        $items = Item::orderByDesc('created_at')->get();
        return new ItemCollection($items);
    }
}
