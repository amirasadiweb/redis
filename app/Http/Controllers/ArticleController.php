<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use Illuminate\Support\Facades\Redis;
class ArticleController extends Controller
{
    public function index()
    {
        $articles=Article::all();
        $progressIds=Redis::zrevrange('user.1.inprogress',0,2);
//        $progress=Article::find($progressIds);
        $progress=collect($progressIds)->map(function($id){
           return Article::find($id); 
        });
        return view('article.index',compact('progress','articles'));
    }

    public function show(Article $article)
    {
        Redis::zadd('user.1.inprogress',time(),$article->id);
        return view('article.show',compact('article'));
    }
}
