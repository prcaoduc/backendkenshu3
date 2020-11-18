<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto text-info font-weight-normal"><b>記事登録ウェブサイト</b></h5>
    <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2 text-dark" href="#">Features</a>
    </nav>
    @if (auth()->check())
    <a class="btn btn-outline-success" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
        Logout
    </a>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @else
    <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
    <a class="btn btn-outline-primary" href="{{ route('register') }}">Signup</a>
    @endif
</div>
