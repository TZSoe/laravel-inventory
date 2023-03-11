<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function allCategories()
    {
        $categories = Category::latest()->get();
        return view('backend.category.category_all', compact('categories'));
    }

    public function createCategory()
    {
        return view('backend.category.category_create');
    }

    public function storeCategory(Request $request)
    {
        Category::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id
        ]);

        $notification = array(
            'message' => 'Category created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);
    }

    public function editCategory(Category $category)
    {
        return view('backend.category.category_edit', compact('category')); 
    }

    public function updateCategory(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'updated_by' => auth()->user()->id
        ]);

        $notification = array(
            'message' => 'Category updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);
    }


    public function deleteCategory(Category $category)
    {
        $category->delete();

        $notification = array(
            'message' => 'Category deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
