<!-- ユーザーの記事の閲覧 -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <div class="row content">
                    <div class="card col-sm-3 sidenav" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title">{{$user->name}}</h5>
                          <h6 class="card-subtitle mb-2 text-muted">{{$user->email}}</h6>
                          <a href="{{ route('account.show') }}">記事</a>
                          <a href="#">イメージ</a>
                          <a href="#">プロフィール</a>
                        </div>
                    </div>

                    <div class="col-sm-9">
                        @if($articles->count())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">タイトル</th>
                                    <th scope="col">作成時間</th>
                                    <th scope="col">ステータス</th>
                                    <th scope="col">編集</th>
                                </tr>
                            </thead>
                            <tbody>
                        @for ($i = 0; $i < count($articles); $i++)
                            <tr>
                                <th scope="row">{{ $i+1 }}</th>
                                <td><a href="{{ route('articles.show', $articles[$i]->id) }}">{{ $articles[$i]->title }}</a></td>
                                <td>{{ $articles[$i]->created_at }}'</td>
                                @if ($articles[$i]->activeStatus == App\Enums\ArticleStatus::Draft)
                                    <td>ドラフト</td>
                                @elseif ($articles[$i]->activeStatus == App\Enums\ArticleStatus::Revoked)
                                    <td>消し取る</td>
                                @endif
                                <td>
                                <form action="{{ route('articles.edit', $articles[$i]->id) }}" method="get">
                                    <input type="submit" value="編集" class="btn btn-outline-primary"/>
                                </form>

                                @can('article.publish')
                                <form action="{{ route('articles.publish', $articles[$i]->id) }}" method="post">
                                    @csrf
                                    <input type="submit" value="公開" class="btn btn-outline-success"/>
                                </form>
                                @endcan

                                @can('article.destroy')
                                <form action="{{ route('articles.destroy', $articles[$i]->id) }}" method="post">
                                    @csrf
                                    <input type="submit" value="削除" class="btn btn-outline-danger"/>
                                </form>
                                @endcan
                            </tr>
                        @endfor
                            </tbody>
                        </table>
                        @else
                        <h4 class="mx-auto">まだ記事を投稿しません</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
