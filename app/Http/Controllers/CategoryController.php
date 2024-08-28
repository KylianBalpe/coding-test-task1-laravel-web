<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $title = 'Category';
        $categories = Category::paginate(10);
        return view('dashboard.category.index', compact('title', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], ['name.required' => 'Category name is required',
            'name.string' => 'Category name must be a string',
            'name.max' => 'Category name must not be greater than 100 characters',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        Category::create($data);

        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }

    public function create(): View
    {
        $title = 'Category';
        $title_2 = 'Add Category';

        return view('dashboard.category.create', compact('title', 'title_2'));
    }

    public function edit($id): View
    {
        $title = 'Category';
        $title_2 = 'Edit Category';
        $category = Category::findOrFail($id);

        return view('dashboard.category.edit', compact('title', 'title_2', 'category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], ['name.required' => 'Category name is required',
            'name.string' => 'Category name must be a string',
            'name.max' => 'Category name must not be greater than 100 characters',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $category->update($data);

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }

    public function delete($id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }
}
