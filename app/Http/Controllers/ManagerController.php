<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\ItemType;
use App\Models\ItemImage;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    /**
     * หน้า Index หลักสำหรับจัดการข้อมูลทั้งหมด
     */
    public function index(Request $request)
    {
        // รับค่าตารางที่ผู้ใช้เลือกจาก URL, หากไม่มีค่าเริ่มต้นคือ 'items'
        $table = $request->input('table', 'items');

        // --- เตรียมข้อมูลพื้นฐานทั้งหมดที่หน้าเว็บอาจจะต้องใช้ ---
        $data = [
            'table' => $table,
            'items' => collect(), // สร้าง collection ว่างๆ เพื่อป้องกัน error
            'units' => ItemUnit::orderBy('name')->get(),
            'types' => ItemType::orderBy('name')->get(),
            'users' => collect(), // สร้าง collection ว่างๆ เพื่อป้องกัน error
            'user_types' => UserType::orderBy('name')->get(),
        ];

        // --- สร้างเงื่อนไขเพื่อดึงข้อมูลหลัก (แบบแบ่งหน้า) ตามตารางที่เลือก ---
        if ($table == 'items') {
            $query = Item::with(['type', 'unit', 'images']);
            if ($request->filled('unit_id')) $query->where('item_unit_id', $request->unit_id);
            if ($request->filled('type_id')) $query->where('item_type_id', $request->type_id);
            if ($request->filled('search')) $query->where('item_name', 'like', '%' . $request->search . '%');
            $data['items'] = $query->paginate($request->input('per_page', 20))->withQueryString();
        } elseif ($table == 'users') {
            // ถ้าผู้ใช้เลือกตาราง 'users', ให้ดึงข้อมูล User มาใส่
            $data['users'] = User::with('userType', 'member')->paginate(20)->withQueryString();
        }

        return view('manager.index', $data);
    }

    // --- CRUD สำหรับ Items ---
    public function storeItem(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'item_unit_id' => 'required|exists:item_units,item_unit_id',
            'item_type_id' => 'required|exists:item_types,item_type_id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 1. สร้างข้อมูล Item หลักก่อน
        $item = Item::create([
            'item_name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'item_unit_id' => $data['item_unit_id'],
            'item_type_id' => $data['item_type_id'],
            'status' => 'active',
        ]);

        // 2. ✅ นำโค้ดส่วนที่หายไปกลับมา: ตรวจสอบและบันทึกรูปภาพ
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('items', 'public');

                $item->images()->create([
                    'path' => $path,
                    'is_main' => $index === 0, // รูปแรกสุดจะเป็นรูปหลัก
                ]);
            }
        }

        return redirect()->back()->with('status', 'Item created successfully.');
    }

    public function updateItem(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'item_unit_id' => 'required|exists:item_units,item_unit_id',
            'item_type_id' => 'required|exists:item_types,item_type_id',
        ]);

        $item->update([
            'item_name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'item_unit_id' => $data['item_unit_id'],
            'item_type_id' => $data['item_type_id'],
        ]);

        return redirect()->back()->with('status', 'Item updated successfully.');
    }

    // START: ฟังก์ชันสำหรับอัปเดตรูปภาพโดยเฉพาะ
    public function uploadItemImage(Request $request, Item $item)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $path = $request->file('image')->store('items', 'public');

        // ตรวจสอบว่าสินค้านี้ยังไม่มีรูปภาพเลยหรือไม่ ถ้าใช่ ให้ตั้งรูปนี้เป็นรูปหลัก
        $isFirstImage = $item->images()->count() == 0;

        $item->images()->create([
            'path' => $path,
            'is_main' => $isFirstImage,
        ]);

        return back()->with('status', 'Image uploaded successfully.');
    }

    /**
     * ลบรูปภาพทีละรูป
     */
    public function destroyItemImage(ItemImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        $item = $image->item;
        if ($image->is_main && $item->images()->count() > 0) {
            $newMainImage = $item->images()->first();
            $newMainImage->is_main = true;
            $newMainImage->save();
        }

        return back()->with('status', 'Image deleted successfully.');
    }

    /**
     * ตั้งค่ารูปภาพหลัก
     */
    public function setMainImage(ItemImage $image)
    {
        $item = $image->item;

        $item->images()->update(['is_main' => false]);

        $image->is_main = true;
        $image->save();

        return back()->with('status', 'Main image has been set.');
    }
    // END: ฟังก์ชันสำหรับอัปเดตรูปภาพโดยเฉพาะ

    public function destroyItem(Item $item)
    {
        foreach ($item->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $item->images()->delete();
        $item->delete();
        return redirect()->back()->with('status', 'Item deleted successfully.');
    }

    // --- CRUD สำหรับ Item Units ---
    public function storeUnit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:item_units,name',
            'des' => 'nullable|string',
        ]);
        ItemUnit::create(['name' => $request->name, 'description' => $request->des]);
        return redirect()->route('manager.index', ['table' => 'units'])->with('status', 'Unit created successfully.');
    }

    public function updateUnit(Request $request, ItemUnit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:item_units,name,' . $unit->item_unit_id . ',item_unit_id',
            'des' => 'nullable|string',
        ]);
        $unit->update(['name' => $request->name, 'description' => $request->des]);
        return redirect()->route('manager.index', ['table' => 'units'])->with('status', 'Unit updated successfully.');
    }

    public function destroyUnit(ItemUnit $unit)
    {
        $unit->delete();
        return redirect()->back()->with('status', 'Unit deleted successfully.');
    }

    // --- CRUD สำหรับ Item Types ---
    public function storeType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:item_types,name',
            'des' => 'nullable|string',
        ]);
        ItemType::create(['name' => $request->name, 'description' => $request->des]);
        return redirect()->route('manager.index', ['table' => 'types'])->with('status', 'Type created successfully.');
    }

    public function updateType(Request $request, ItemType $type)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:item_types,name,' . $type->item_type_id . ',item_type_id',
            'des' => 'nullable|string',
        ]);
        $type->update(['name' => $request->name, 'description' => $request->des]);
        return redirect()->route('manager.index', ['table' => 'types'])->with('status', 'Type updated successfully.');
    }

    public function destroyType(ItemType $type)
    {
        $type->delete();
        return redirect()->back()->with('status', 'Type deleted successfully.');
    }

    // --- ฟังก์ชันสำหรับจัดการ User Type ---
    public function storeUserType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:user_types,name',
            'description' => 'nullable|string'
        ]);
        UserType::create($request->all());
        return redirect()->route('manager.index', ['table' => 'user_types'])->with('status', 'User Type created successfully.');
    }

    public function updateUserType(Request $request, UserType $user_type)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('user_types')->ignore($user_type->id)],
            'description' => 'nullable|string'
        ]);
        $user_type->update($request->all());
        return redirect()->route('manager.index', ['table' => 'user_types'])->with('status', 'User Type updated successfully.');
    }

    public function destroyUserType(UserType $user_type)
    {
        if ($user_type->users()->count() > 0) {
            return back()->with('error', 'Cannot delete this user type, it is currently in use.');
        }
        if (in_array($user_type->id, [1, 2, 3])) { // ป้องกันการลบ Type หลัก
            return back()->with('error', 'Cannot delete default user types.');
        }
        $user_type->delete();
        return redirect()->route('manager.index', ['table' => 'user_types'])->with('status', 'User Type deleted successfully.');
    }

    // --- ฟังก์ชันสำหรับจัดการ User ---
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'user_type_id' => 'required|exists:user_types,id',
            'status' => 'required|string',
        ]);

        $user->update($request->only(['username', 'email', 'user_type_id', 'status']));
        return redirect()->route('manager.index', ['table' => 'users'])->with('status', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        if ($user->user_type_id == 1 && User::where('user_type_id', 1)->count() <= 1) {
            return back()->with('error', 'Cannot delete the last administrator.');
        }
        $user->delete();
        return redirect()->route('manager.index', ['table' => 'users'])->with('status', 'User deleted successfully.');
    }
}
