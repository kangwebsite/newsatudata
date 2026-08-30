<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'required|url|max:2048',
            'tags' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $validatedData = $validator->validated();
            $imageResponse = Http::timeout(15)->get($validatedData['image_url']);

            if ($imageResponse->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gambar tidak dapat diunduh'
                ], 422);
            }

            $contentType = strtolower(explode(';', $imageResponse->header('Content-Type', ''))[0]);
            $extension = match ($contentType) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
                'image/svg+xml' => 'svg',
                default => null,
            };

            if ($extension === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'URL harus mengarah ke file gambar yang didukung'
                ], 422);
            }

            $imagePath = 'posts/' . Str::uuid() . '.' . $extension;
            Storage::disk('public')->put($imagePath, $imageResponse->body());

            $tags = collect(is_array($validatedData['tags'] ?? null)
                ? $validatedData['tags']
                : explode(',', $validatedData['tags'] ?? ''))
                ->map(fn ($tag) => trim($tag))
                ->filter()
                ->unique()
                ->values()
                ->all();

            $post = Post::create([
                'title' => $validatedData['title'],
                'body' => $validatedData['content'],
                'image' => $imagePath,
                'tags' => $tags,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan',
                'data' => $post
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan berita',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
