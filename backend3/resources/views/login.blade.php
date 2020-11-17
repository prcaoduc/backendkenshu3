<form method="post" action="{{ route('login') }}">
    @csrf
  <div class="form-group">
    <label>メールアドレス</label>
    <input type="text" name="email" class="form-control p_input">
  </div>
  <div class="form-group">
    <label>パスワード</label>
    <input type="password" name="password" class="form-control p_input">
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-primary btn-block enter-btn">ログイン</button>
  </div>

  <p class="sign-up">メンバーではなく?<a href="{{ route('register') }}"> 登録する</a></p>
</form>