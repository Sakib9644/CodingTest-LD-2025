<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ShortenedUrl;
use Illuminate\Support\Str;

class ShortenUrlController extends Controller
{
   public function store(Request $request)
{
    try {
        $request->validate([
            'url' => 'required|url|unique:shortened_urls,original_url',
        ]);

        $shortCode = Str::random(6);

        $shortUrl = ShortenedUrl::create([
            'user_id'      => $request->user()->id,
            'original_url' => $request->url,
            'short_code'   => $shortCode,
        ]);

        return response()->json([
            'success'   => true,
            'short_code'   => $shortCode,
            'short_url' => url('/api/' . $shortCode),
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors'  => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

}
