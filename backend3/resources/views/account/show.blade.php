<!-- ユーザーの記事の閲覧 -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <div class="row content">
                    <div class="card col-sm-3 sidenav" style="height:22rem; width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title">{{$user->name}}</h5>
                          <h6 class="card-subtitle mb-2 text-muted">{{$user->email}}</h6>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a href="{{ route('account.show') }}">配信した記事</a></li>
                            <li class="list-group-item"><a href="#">イメージ</a></li>
                            <li class="list-group-item"><a href="#">プロフィール</a></li>
                            @can('article.create')
                            <li class="list-group-item"><a href="{{ route('account.drafts') }}">ドラフト</a></li>
                            @endcan
                          </ul>
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
                                    <th scope="col">編集</th>
                                </tr>
                            </thead>
                            <tbody>
                        @for ($i = 0; $i < count($articles); $i++)
                            <tr>
                                <th scope="row">{{ $i+1 }}</th>
                                <td><a href="{{ route('articles.show', $articles[$i]->id) }}">{{ $articles[$i]->title }}</a></td>
                                <td>{{ $articles[$i]->created_at }}'</td>
                                <td>

                                <form action="{{ route('articles.delete', $articles[$i]->id) }}" method="post">
                                    @csrf
                                    <input type="submit" value="取り消す" class="btn btn-outline-danger"/>
                                </form>
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
