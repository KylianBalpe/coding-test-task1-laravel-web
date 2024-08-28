<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $title = 'Product';
        $categories = Category::all();

        $product = Product::with('category');
        $categoryRequest = $request->query('category');
        $searchRequest = $request->query('search');

        if ($categoryRequest) {
            $product->where('category_id', $request->query('category'));
        }

        if ($searchRequest) {
            $product->where(function ($query) use ($searchRequest) {
                $query->where('name', 'like', '%' . $searchRequest . '%')
                    ->orWhere('description', 'like', '%' . $searchRequest . '%');
            });
        }

        $products = $product->paginate(10)->appends(['category' => $categoryRequest, 'search' => $searchRequest]);

        return view('dashboard.product.index', compact('title', 'products', 'categories', 'categoryRequest', 'searchRequest'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|mimes:jpeg,png,jpg,webp|max:10240',
            'category_id' => 'required|integer',
        ], ['name.required' => 'Product name is required',
            'name.string' => 'Product name must be a string',
            'name.max' => 'Product name must not be greater than 255 characters',
            'description.required' => 'Product description is required',
            'description.string' => 'Product description must be a string',
            'price.required' => 'Product price is required',
            'price.integer' => 'Product price must be a number',
            'image.required' => 'Product image is required',
            'image.mimes' => 'Product image must be a file of type: jpeg, png, jpg',
            'image.max' => 'Product image must not be greater than 10 MB',
            'category_id.required' => 'Product category is required',
            'category_id.integer' => 'Product category must be an integer',
        ]);

        if ($validator->fails()) {
            Log::info('Validation failed:' . json_encode($validator->errors()->all(), JSON_PRETTY_PRINT));
            return back()->withErrors($validator)->withInput();
        }

        $product = $validator->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images/product', $imageName, 'public');
            $product['image'] = $imageName;
        }

        Log::info('Insert product to db :' . json_encode($product, JSON_PRETTY_PRINT));
        Product::create($product);

        Log::info('Product created successfully');
        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    public function create(): View
    {
        $title = 'Product';
        $title_2 = 'Add Product';
        $categories = Category::all();

        return view('dashboard.product.create', compact('title', 'title_2', 'categories'));
    }

    public function edit($id): View
    {
        $title = 'Product';
        $title_2 = 'Edit Product';

        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('dashboard.product.edit', compact('title', 'title_2', 'product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:10240',
            'category_id' => 'required|integer',
        ], ['name.required' => 'Product name is required',
            'name.string' => 'Product name must be a string',
            'name.max' => 'Product name must not be greater than 255 characters',
            'description.required' => 'Product description is required',
            'description.string' => 'Product description must be a string',
            'price.required' => 'Product price is required',
            'price.integer' => 'Product price must be a number',
            'image.mimes' => 'Product image must be a file of type: jpeg, png, jpg',
            'image.max' => 'Product image must not be greater than 10 MB',
            'category_id.required' => 'Product category is required',
            'category_id.integer' => 'Product category must be an integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $productData = $validator->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('images/product/' . $product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images/product', $imageName, 'public');
            $productData['image'] = $imageName;
        } else {
            $productData['image'] = $product->image;
        }

        $product->update($productData);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    public function delete($id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete('images/product/' . $product->image);
        }

        $product->delete();


        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
