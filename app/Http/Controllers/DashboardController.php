<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $title = 'Dashboard';
        $totalCategory = Category::count();
        $totalProduct = Product::count();

        $products = Product::with('category')->latest()->limit(5)->get();

        return view('dashboard.index', compact('title', 'totalCategory', 'totalProduct', 'products'));
    }
}
