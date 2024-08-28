<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $title = 'Home';
        $products = Product::latest()->limit(4)->get();

        return view('home.index', compact('title', 'products'));
    }

    public function product(Request $request): View
    {
        $title = 'Product';
        $categories = Category::all();

        $product = Product::with('category')->latest();
        $requestCategory = $request->query('category');
        $searchRequest = $request->query('search');

        if ($requestCategory) {
            $product->where('category_id', $request->query('category'));
        }

        if ($searchRequest) {
            $product->where(function ($query) use ($searchRequest) {
                $query->where('name', 'like', '%' . $searchRequest . '%')
                    ->orWhere('description', 'like', '%' . $searchRequest . '%');
            });
        }

        $products = $product->paginate(8)->appends(['category' => $requestCategory, 'search' => $searchRequest]);

        return view('home.product', compact('title', 'products', 'categories', 'requestCategory', 'searchRequest'));
    }
}
