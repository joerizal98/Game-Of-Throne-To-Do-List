<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    // public function showLoginForm()
    // {
    //     // Make API request to fetch random quote
    //     $response = Http::get('https://api.gameofthronesquotes.xyz/v1/random');
    //     $data = $response->json();
    //     $quote = $data['sentence'];

    //     // Pass the quote to the login view
    //     return view('home', ['quote' => $quote]);
    // }

    public function index()
{
    try {
        $response = Http::get('https://api.gameofthronesquotes.xyz/v1/random');
        
        if ($response->successful()) {
            $quote = $response->json()['sentence'];
            return view('test', compact('quote'));
        } else {
            // Handle unsuccessful response
            return response()->json(['error' => 'Failed to fetch quote'], $response->status());
        }
    } catch (\Exception $e) {
        // Handle exception
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
