<!-- 記事投稿ページ -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="load_more">
        <div class="row">
            <div class="col-lg-12 col-lg-offset-2">
                <h1>新たな記事を作成する</h1>
                    <form id="article_form" method="post" action="{{route('articles.store')}}" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">タイトル * </label>
                                    <input id="title" type="text" name="title" class="form-control" placeholder="記事のタイトルを入力ください *" required="required" data-error="タイトルが必要。">
                                    <small>　タイトルの最大長さは５０キャラクター</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tag">タグ * </label>
                                    <div id ="tag_wrapper">
                                        <div class="form-inline">
                                            <input type="text" name="tag[]" class="form-control inline" placeholder="記事のタグを入力ください *" required="required">
                                            <button class="btn btn-warning remove_tag_button" type="button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <a class="btn btn-secondary tag_new">新しいタグ</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content">内容 * </label>
                                    <textarea id="content" name="content" class="form-control" placeholder="内容 *" required="required" rows="30" data-error="Kindly write your post's content"></textarea>
                                </div>
                            </div>
                        </div>
                        {{-- <img src="{{ Storage::url("/storage/app/public/1606351901.png") }}" width="200px" height="100px"/> --}}

                        <div class="row">
                            <ul id="thumbnail_select">

                            </ul>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">イメージ追加</button>
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">イメージ設置</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <label for="content">自分のイメージ</label>
                                            <ul id="user_image">
                                                @if (empty($user_images))
                                                <span id="empty_images">まだイメージがない</span>
                                                @else
                                                    @for ($i = 0 ; $i < count($user_images); $i++)
                                                    <li> <input type="checkbox" name="images[]" value=" {{$user_images[$i]->id}}={{$user_images[$i]->url}} " id="image_checkbox{{$i}}" />
                                                    <label for="image_checkbox{{$i}}"><img src="{{ $user_images[$i]->url }}" width="200px" height="100px"/></label></li>
                                                    @endfor
                                                @endif
                                            </ul>
                                            <label for="content">新たなイメージを投稿する</label>
                                            <input type="file" id="images" name="images[]" multiple="multiple" accept="image/*" class="form-control" onload="{(e) => {this.loadMe(e, index)}}" />
                                            <div class="modal-footer">
                                                <button id="images_selected" type="button" class="btn btn-primary" data-dismiss="modal">確認する</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('includes.form-error')
                </form>
                <form id="test" method="post" action="{{route('images.store')}}" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="submit" name="add_submit" class="btn btn-success btn-send" value="Add" form="test">
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted"><strong>*</strong> フィールドが必要です。</p>
                    </div>
                </div>
            </div>
            </body>
        </div>
    </div>
</div>
<script>
    $('input[type="file"]').on('change', function() {
        var fd = new FormData($(this).parents('form')[0]);
        $.ajax({
            url: "{{ route('images.store') }}",
            type: 'POST',
            data: fd,
            success: function(data) {
                $("#user_image").load(location.href + " #user_image");
            },
            fail: function(xhr, textStatus, errorThrown){
                alert('request failed');
            },
            cache: false,
            contentType: false,
            processData: false
        }).done(function(data) {
            alert(data);
        }).fail(function() {
            alert('Fail!');
        });
    });
    $('#images_selected').on('click', function(){
        $('#thumbnail_select').html('');
        var selected_images = [];
        $('#user_image input:checked').each(function() {
            selected_images.push($(this).attr('value'));
        });
        var obj = {};
        for(var i=0; i < selected_images.length; i++) {
            var keyValue = selected_images[i].split("=");
            console.log(keyValue[0]);
            console.log(keyValue[1]);
            $('#thumbnail_select').append('<input type="hidden" name="selected_images[]" value="' + keyValue[0] + '" />');
            $('#thumbnail_select').append('<li> <input type="radio" name="thumbnail" value="' + keyValue[0] + '" id="image_checkbox' + i + '" /> ' +
                        '<label for="image_checkbox' + i + '"><img src="' + keyValue[1] + ' " width="200px" height="100px"/></label>');
            var content = $('#content').val();
            $('#content').val(content +  keyValue[1]);
        }
    });
    $('.tag_new').on('click',function(e){
        $('#tag_wrapper').append('<div class="form-inline"><input type="text" name="tag[]" class="form-control inline" placeholder="記事のタグを入力ください *" required="required"><button class="btn btn-warning remove_tag_button" type="button"><i class="fa fa-times"></i></button></div>');
    });
    $(document).on('click', '.remove_tag_button',function(e){
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

