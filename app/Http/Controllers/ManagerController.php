<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\ItemType;
use App\Models\ItemImage;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    // หน้า Index
    public function index(Request $request)
    {
        $table = $request->table ?? 'items';

        $itemsQuery = Item::with(['type', 'unit', 'images', 'mainImage'])->orderBy('item_id', 'desc');
        if ($request->unit_id) $itemsQuery->where('item_unit_id', $request->unit_id);
        if ($request->type_id) $itemsQuery->where('item_type_id', $request->type_id);
        $perPage = $request->per_page ?? 20;
        $items = $itemsQuery->paginate($perPage)->withQueryString();

        $units = ItemUnit::orderBy('name')->get();
        $types = ItemType::orderBy('name')->get();

        return view('manager.index', compact('items', 'units', 'types', 'table'));
    }

    // Store Item
    public function storeItem(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer|min:0',
            'item_unit_id' => 'nullable|exists:item_units,item_unit_id',
            'item_type_id' => 'nullable|exists:item_types,item_type_id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $item = Item::create([
            'item_name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'] ?? null,
            'stock' => $data['stock'] ?? null,
            'item_unit_id' => $data['item_unit_id'] ?? null,
            'item_type_id' => $data['item_type_id'] ?? null,
            'status' => 'active',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time().'_'.$index.'_'.$image->getClientOriginalName();
                $image->storeAs('public/items', $filename);
                $item->images()->create([
                    'path' => $filename,
                    'is_main' => $index === 0,
                ]);
            }
        }

        return redirect()->back()->with('status', 'Item created.');
    }

    // Update Item
    public function updateItem(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer|min:0',
            'item_unit_id' => 'required|exists:item_units,item_unit_id',
            'item_type_id' => 'required|exists:item_types,item_type_id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $item->update([
            'item_name' => $data['name'] ?? $item->item_name,
            'description' => $data['description'] ?? $item->description,
            'price' => $data['price'] ?? $item->price,
            'stock' => $data['stock'] ?? $item->stock,
            'item_unit_id' => $data['item_unit_id'] ?? $item->item_unit_id,
            'item_type_id' => $data['item_type_id'] ?? $item->item_type_id,
        ]);

        if ($request->hasFile('images')) {
            // ลบรูปเก่า
            foreach ($item->images as $oldImage) {
                if (Storage::disk('public')->exists('items/'.$oldImage->path)) {
                    Storage::disk('public')->delete('items/'.$oldImage->path);
                }
            }
            $item->images()->delete();

            foreach ($request->file('images') as $index => $image) {
                $filename = time().'_'.$index.'_'.$image->getClientOriginalName();
                $image->storeAs('public/items', $filename);
                $item->images()->create([
                    'path' => $filename,
                    'is_main' => $index === 0,
                ]);
            }
        }

        return redirect()->back()->with('status', 'Item updated.');
    }

    // Destroy Item
    public function destroyItem(Item $item)
    {
        foreach ($item->images as $img) {
            if (Storage::disk('public')->exists('items/'.$img->path)) {
                Storage::disk('public')->delete('items/'.$img->path);
            }
        }
        $item->images()->delete();
        $item->delete();

        return redirect()->back()->with('status', 'Item deleted.');
    }

    // Units CRUD
    public function storeUnit(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100|unique:item_units,name']);
        ItemUnit::create(['name' => $data['name']]);
        return redirect()->back()->with('status', 'Unit added.');
    }

    public function updateUnit(Request $request, ItemUnit $unit)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:item_units,name,' . $unit->item_unit_id . ',item_unit_id'
        ]);
        $unit->update(['name' => $data['name']]);
        return redirect()->back()->with('status', 'Unit updated.');
    }

    public function destroyUnit(ItemUnit $unit)
    {
        $unit->delete();
        return redirect()->back()->with('status', 'Unit deleted.');
    }

    // Types CRUD
    public function storeType(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100|unique:item_types,name']);
        ItemType::create(['name' => $data['name']]);
        return redirect()->back()->with('status', 'Type added.');
    }

    public function updateType(Request $request, ItemType $type)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:item_types,name,' . $type->item_type_id . ',item_type_id'
        ]);
        $type->update(['name' => $data['name']]);
        return redirect()->back()->with('status', 'Type updated.');
    }

    public function destroyType(ItemType $type)
    {
        $type->delete();
        return redirect()->back()->with('status', 'Type deleted.');
    }
}
