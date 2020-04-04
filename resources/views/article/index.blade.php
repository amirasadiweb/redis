
<h2>three items of recntly view</h2>
<ol type="1">
    @foreach($progress as $article)
        <li>
            <a href="article/show/{{$article->id}}">
              {{$article->title}}
            </a>
        </li>
    @endforeach
</ol>



<h1> All Articles</h1>
<ul>
    @foreach($articles as $article)
       <li>
           <a href="article/show/{{$article->id}}">
               {{$article->title}}
           </a>
       </li>
    @endforeach
</ul>