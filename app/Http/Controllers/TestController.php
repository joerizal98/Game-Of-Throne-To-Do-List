<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function index()
    {
        try {
            $response = Http::withOptions(['verify' => false])->get('https://api.gameofthronesquotes.xyz/v1/random');

            
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
