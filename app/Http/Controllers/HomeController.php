<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Se hai bisogno di dati dal database per la homepage
        // $carouselItems = DB::table('carousel_items')->get();
        // $featuredProducts = DB::table('products')->where('featured', true)->get();
        
        return view('home', [
            // 'carouselItems' => $carouselItems,
            // 'featuredProducts' => $featuredProducts,
        ]);
    }
}