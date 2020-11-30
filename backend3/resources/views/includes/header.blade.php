<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <a href="{{route('home')}}" class="my-0 mr-md-auto text-info font-weight-normal h5"><b>記事登録ウェブサイト</b></a>
    @if (auth()->check())
    <nav class="my-2 my-md-0 mr-md-3">
    <div class="d-flex">
        <div class="btn-group">
        <button type="button" href="#" class="btn btn-secondary">{{Auth::user()->name}}</button>
          <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
            <a class="dropdown-item" href="{{ route('account.show') }}">記事管理</a>
            <a class="dropdown-item" href="{{ route('articles.create') }}">記事作成</a>
          </div>
        </div>
      </div>
    </nav>
    <a class="btn btn-outline-success" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
        ログアウト
    </a>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @else
    <a class="btn btn-outline-primary" href="{{ route('login') }}">ログイン</a>
    <a class="btn btn-outline-primary" href="{{ route('register') }}">登録</a>
    @endif
</div>
