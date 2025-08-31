<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     * Ye function database se saare products fetch karta hai aur unko index view me bhejta hai.
     */
    public function index()
    {
        $products = DB::select("SELECT * FROM products");
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     * Ye sirf create form wala view return karta hai jahan user product add kar sakta hai.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in database.
     * - Agar image upload hui ho to uploads folder me save karta hai.
     * - Product details ko database me insert karta hai.
     * - Baad me user ko product list page par redirect kar deta hai.
     */
    public function store(Request $request)
    {
        // File upload handling (image save karne ka logic)
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
        }

        // Database insert query
        DB::insert("INSERT INTO products (name, price, quantity, category, image) VALUES (?, ?, ?, ?, ?)", [
            $request->name, $request->price, $request->quantity, $request->category, $imageName
        ]);

        return redirect()->route('products.index')->with('success', 'Product added!');
    }

    /**
     * Show the form for editing the specified product.
     * - Database se product ko id ke basis pe fetch karta hai.
     * - Edit view ko us product ke data ke sath return karta hai.
     */
    public function edit($id)
    {
        $product = DB::select("SELECT * FROM products WHERE id = ?", [$id]);
        return view('products.edit', ['product' => $product[0]]);
    }

    /**
     * Update the specified product in database.
     * - Agar nayi image upload hui ho to purani replace karta hai warna old wali hi rakhta hai.
     * - Database me product ki updated details save karta hai.
     * - User ko wapas products list page par redirect kar deta hai.
     */
    public function update(Request $request, $id)
    {
        $imageName = $request->old_image; // Purani image rakho agar nayi nahi di gayi
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
        }

        DB::update("UPDATE products SET name=?, price=?, quantity=?, category=?, image=? WHERE id=?", [
            $request->name, $request->price, $request->quantity, $request->category, $imageName, $id
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    /**
     * Remove the specified product from database.
     * - Given id ka product delete karta hai.
     * - Wapas product list page par success message ke sath redirect karta hai.
     */
    public function delete($id)
    {
        DB::delete("DELETE FROM products WHERE id = ?", [$id]);
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
