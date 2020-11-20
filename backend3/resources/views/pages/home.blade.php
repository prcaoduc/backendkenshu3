@extends('layouts.app')
@section('content')
<div class="row mb-2">
    @foreach ($articles as $article)
    <div class="col-md-6">
        <div class="card flex-md-row mb-4 shadow-sm h-md-250">
            <div class="card-body align-items-start">
                @if($article->tags()->count() > 0)
                    @foreach($article->tags()->get() as $item)
                    <span class="badge badge-secondary">{{$item->name}}</span>
                    @endforeach
                @endif
                <h3 class="mb-0">
                <a class="text-dark" href="{{ route('articles.show', ['id' => $article->id]) }}">{{$article->title}}</a>
                </h3>
                <div class="mb-1 text-muted">{{$article->created_at}}</div>
                <p class="card-text mb-auto">{{$article->content}}</p>
                <a href="{{ route('articles.show', ['id' => $article->id]) }}">Continue reading</a>
            </div>
        <img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="{{$article->thumbnail[0]->url}}" data-holder-rendered="true">
        </div>
      </div>
    @endforeach()
</div>
@stop
