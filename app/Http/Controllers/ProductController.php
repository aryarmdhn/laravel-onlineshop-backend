<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('pages.product.index', compact('products'));
    }

    // create
    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    // store
    public function store(Request $request)
{
    $filename = time() . '.' . $request->image->extension();
    $request->image->storeAs('public/products', $filename);

    $product = new \App\Models\Product;
    $product->name = $request->name;
    $product->price = (int) $request->price;
    $product->stock = (int) $request->stock;
    $product->category_id = $request->category_id;
    $product->image = $filename;
    $product->save();

    return redirect()->route('product.index')->with('success', 'Product telah di buat!');
}


    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.product.edit', compact('product', 'categories'));
    } 

    public function update(Request $request, $id)
{
    $product = Product::find($id);
    $product->name = $request->name;
    $product->price = (int) $request->price;
    $product->stock = (int) $request->stock;
    $product->category_id = $request->category_id;

    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $product->image = $filename;
    }

    $product->save();

    return redirect()->route('product.index')->with('success', 'Product successfully updated');
}


    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
