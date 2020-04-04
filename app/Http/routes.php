<?php

use Illuminate\support\Facades\Redis;
use App\Article;
use Illuminate\Support\Facades\Cache;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('videos/{id}/downloads', function ($id) {
    Redis::incr("videos.{$id}.downloads");
    return back();
});

Route::get('videos/{id}',function ($id){
     $downloads=Redis::get("videos.{$id}.downloads");
    return view('welcome',compact('downloads'));

});

//----------trending_article-------------

Route::get('article/ternding',function(){
    
    $trending=Redis::zrevrange('trending_article',0,2);
//    $trending=Article::hydrate(
//        array_map('json_decode',$trending)
//    );
//
//    dd($trending);
  return $trending;
});



Route::get('article/{article}',function (Article $article){

    Redis::zincrby('trending_article',1,$article);
    return $article;
});

//------------------Hashes---------------------

Route::get('add/user',function(){

    $user1=[
        'favorites'=>20,
        'wathlaters'=>15,
        'completion'=>30
    ];
    Redis::hmset('user.3.states',$user1);
    return Redis::hgetall('user.3.states');

});

Route::get('user/{id}/states',function ($id){

    return Redis::hgetall("user.{$id}.states");

});

Route::get('user/{id}/favorite',function ($id){

//   $id=Auth:id();
     Redis::hincrby("user.{$id}.states",'favorites',1);
});

route::get('put/cache',function (){
    Cache::put('foo','bar',1);
    return Cache::get('foo');
}
);

//--------------caching---------------

Route::get('caching',function (){

    return Cache::remember('article.all',60,function (){

        return Article::all();
    });
});

//-----------recently view article------------


Route::get('/','ArticleController@index');
Route::get('/article/show/{article}','ArticleController@show');