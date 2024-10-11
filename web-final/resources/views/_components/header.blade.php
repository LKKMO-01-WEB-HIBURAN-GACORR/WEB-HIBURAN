<header class="header">
    <div class="header-logo">
        <img src="{{ asset('images/logo.png') }}" alt="One Music">
    </div>
    <div class="header-search">
        <form class="search-box" action="{{ route('music.search') }}" method="GET">
            <input type="text" class="form-control" name="query" value="{{ old("query", $query ?? null) }}" required>
            <button class="search-action">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
    <div class="header-profile">
        @auth
            <a href="{{ route('profile') }}" class="avatar">
                <i class="fa fa-user-alt"></i>
            </a>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="avatar">
                <i class="fa fa-door-open"></i>
            </a>
        @endguest
    </div>
</header>
