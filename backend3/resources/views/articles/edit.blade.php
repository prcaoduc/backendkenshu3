<!-- 記事編集ページ -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="load_more">
        <div class="row">

            <div class="col-lg-12 col-lg-offset-2">

                <h1>記事を編集する</h1>

                <form method="post" action="{{ route('articles.update', $article->id) }}" role="form" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?= $article->id ?>">
                    @csrf

                    <div class="messages"></div>

                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">タイトル * </label>
                                    <input id="title" type="text" name="title" class="form-control" placeholder="記事のタイトルを入力ください *" required="required" data-error="タイトルが必要。" value="<?= $article->title ?>">
                                    <small>　タイトルの最大長さは５０キャラクター</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tag">タグ * </label>

                                    <div id ="tag_wrapper">
                                        @foreach($tags as $tag)
                                            <div class="form-inline"><input type="text" name="tag[]" class="form-control inline" value="{{ $tag->name }}" required="required">
                                            <button class="btn btn-warning remove_tag_button" type="button"><i class="fa fa-times"></i></button></div>
                                        @endforeach
                                    </div>
                                    <a class="btn btn-secondary tag_new">新しいタグ</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <i class="fa fa-address-book" aria-hidden="true"></i>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content">内容 * </label>
                                    <textarea id="content" name="content" class="form-control" placeholder="内容 *" required="required" rows="30" data-error="Kindly write your post's content" ><?= $article->content ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="add_submit" class="btn btn-success btn-send" value="編集">
                            </div>
                        </div>
                    </div>
                    <div id="image_show">

                    </div>
                    @include('includes.form-error')
                </form>
                </body>

            </div>

        </div>
    </div>
</div>
<script>
    $('.tag_new').on('click',function(e){
        $('#tag_wrapper').append('<div class="form-inline"><input type="text" name="tag[]" class="form-control inline" required="required"><button class="btn btn-warning remove_tag_button" type="button"><i class="fa fa-times"></i></button></div>');
        // $(this).css("background", "#f99");
    });
    $(document).on("click", '.remove_tag_button',function(e){
        var num_items = $('.remove_tag_button').length;
        console.log(num_items);
        if(num_items > 1){
            $(this).parent().remove();
        }
        else {
            $(this).parent().find('#once_tag').remove();
            $(this).parent().append('<span class="text-danger" id="once_tag">article have to have at least 1 tag</span>');
        }
    });
</script>
@stop
