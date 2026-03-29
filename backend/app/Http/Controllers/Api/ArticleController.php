<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    // GET /api/articles
    public function index()
    {
        return response()->json(
            Article::orderBy('created_at', 'desc')->get()
        );
    }

    // POST /api/articles
    public function store(Request $request)
    {
        // basic validation
        $validated = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required'
        ]);

        // sanitize HTML
        $cleanContent = strip_tags(
            $validated['content'],
            '<p><b><i><ul><li>'
        );

        // check if content is actually empty
        if (trim(strip_tags($cleanContent)) === '') {
            return response()->json([
                'message' => 'Content cannot be empty'
            ], 422);
        }

        // save
        return Article::create([
            'title' => $validated['title'],
            'content' => $cleanContent
        ]);
    }

    // PUT /api/articles/{id}
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:5'
        ]);

        $article->update($validated);

        return $article;
    }

    // DELETE /api/articles/{id}
    public function destroy($id)
    {
        Article::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
