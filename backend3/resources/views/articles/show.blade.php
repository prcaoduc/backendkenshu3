@extends('layouts.app')
@section('content')
<!-- 記事内容ページ -->
<div class="row">
    <div class="col-lg-12">
    <div class="card mt-4">
        @if ($images)
            <div id="carouselExampleIndicators" style="height: 550px;" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @for($i = 0; $i < $images->count(); $i++)
                    @if ($images[$i]->isthumbnail)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" class="active"></li>
                    @else
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"></li>
                    @endif
                @endfor
            </ol>
            <div class="carousel-inner">
                @for ($i = 0; $i < $images->count(); $i++)
                    @if ($images[$i]->pivot->isThumbnail == App\Enums\ThumbnailStatus::isThumbnail)
                        <div class="carousel-item active">
                            <img class="d-block w-100 h-100" src="{{$images[$i]->url}}" alt="First slide">
                        </div>
                    @else
                        <div class="carousel-item">
                            <img class="d-block w-100 h-100" src="{{$images[$i]->url}}" alt="First slide">
                        </div>
                    @endif
                @endfor
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
        @endif
        <div class="card-body">
            <h3 class="card-title"><?= $article->title ?></h3>
            <?php
            foreach ($tags as $tag) {
                echo '<span class="badge badge-secondary">' . $tag->name . '</span>';
            } ?>
            <h4>Created at : <?= $article->created_at ?></h4>
            <p class="card-text"><?= $article->content ?></p>
            </div>
    </div>
    </div>
</div>
@stop
