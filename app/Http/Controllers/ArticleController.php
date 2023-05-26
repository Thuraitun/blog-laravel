<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index()
    {
        $data = Article::latest()->paginate(5);

        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);

        return view('articles.detail', [
            'article' => $data
        ]);
    }

    public function add() 
    {
        $data = Category::all();

        return view('articles.add', [
            'categories' => $data
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save(); //insert query for database

        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if(Gate::allows('article-delete', $article)){
            $article->delete();
            return redirect("/articles")->with("info", "An article deleted");
        }
        
        return redirect('/articles')->with('info', 'Unauthorize to delete');
    }

    public function edit($id)
    {
        $article = Article::find($id);
        $category = Category::all();

        return view('articles/edit', [
            'article' => $article,
            'categories' => $category,
        ]);
    }
    
    public function update($id)
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save(); //insert query for database

        return redirect("/articles/detail/$id");
    }
    
}
