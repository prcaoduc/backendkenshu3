@extends('layouts.app')
@section('content')
<div class="container">
  <h3 class="text-center text-info pt-5">登録フォーム</h3>
  <div id="login-row" class="row justify-content-center align-items-center">
      <div id="login-column" class="col-md-6">
          <div id="login-box" class="col-md-12">
            <form method="post" action="{{ route('register') }}">
                @csrf
              <div class="form-group">
                <label class="text-info">お名前＊</label>
                <input type="text" name="name" class="form-control p_input">
              </div>
              <div class="form-group">
                <label class="text-info">メールアドレス＊</label>
                <input type="email" name="email" class="form-control p_input">
              </div>
              <div class="form-group">
                <label  class="text-info">パスワード＊</label>
                <input type="password" name="password" class="form-control p_input">
              </div>
              <div class="form-group">
                <label  class="text-info">パスワード確認＊</label>
                <input type="password" name="password_confirmation" class="form-control p_input">
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-info btn-block enter-btn">登録する</button>
              </div>

            </form>
          </div>
      </div>
  </div>
</div>
@stop
