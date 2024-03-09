<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wallpaper;

class WallController extends Controller
{
    public function wall()
    {
        $wall = wallpaper::inRandomOrder()->first(); // Get a random wallpaper image from the database
        if ($wall) {
            // Encode the binary image data as Base64
            $wall->image_data = base64_encode($wall->image_data);
            $data = [
                'status' => 200,
                'api' => $wall
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'No wallpaper found'
            ];
        }
        return response()->json($data);
    }
}
