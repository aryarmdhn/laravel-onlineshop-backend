<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(5);
        return view('pages.category.index', compact('categories'));
    }

    
    // create
    public function create()
    {
        $categories = Category::all();
        return view('pages.category.create', compact('categories'));
    }

        // store
        public function store(Request $request)
        {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/category', $filename);
        
            $category = new \App\Models\Category;
            $category->name = $request->name;
            $category->description = $request->description;
            $category->image = $filename;
            $category->save();
        
            return redirect()->route('category.index')->with('success', 'Category telah di buat!');
        }

        public function edit($id)
    {
        $categories = \App\Models\Category::findOrFail($id);
        return view('pages.category.edit', compact('categories'));
    } 

    public function update(Request $request, $id)
{
    $category = Category::find($id);
    $category->name = $request->name;
    $category->description = $request->description;

    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/category', $filename);
        $category->image = $filename;
    }

    $category->save();

    return redirect()->route('category.index')->with('success', 'Category successfully updated');
}


    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category successfully deleted');
    }
     
}
