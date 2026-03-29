<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = DB::table('articles')->orderByDesc('created_at')->get();
        return view('dashboard', ['articles' => $articles]);
    }

    public function create()
    {
        return view('admin.editor');
    }

    public function store(Request $request)
    {
        DB::table('articles')->insert([
            'title' => $request->title,
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('dashboard');
    }

    public function edit($id)
    {
        $article = DB::table('articles')->where('id', $id)->first();
        return view('admin.editor', ['article' => $article]);
    }

    public function update(Request $request, $id)
    {
        DB::table('articles')->where('id', $id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'updated_at' => now(),
        ]);
        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        DB::table('articles')->where('id', $id)->delete();
        return redirect()->route('dashboard');
    }
}