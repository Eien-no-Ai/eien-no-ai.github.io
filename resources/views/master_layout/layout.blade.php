<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--bootsrap csscrpt--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title> @yield("title")</title>
</head>

<body>

    <div class="container-fluid">
        <nav class="navbar">
            <div class="logo">Avant-Garde</div>
            <ul class="menu">
                <li><a href="{{ Auth::check() && Auth::user()->is_admin ? route('admin') : route('home') }}">Home</a></li>
                @if(Auth::check() && Auth::user()->is_admin)
                <li><a href="{{route('crud.list')}}">Users</a></li>
                <li><a href="{{route('purchase.artworkpurchases')}}">Purchases</a></li>
                @endif
                <li><a href="{{ route('artwork.artworks')}}">Artworks</a></li>
                <li><a href="{{ route('artist.artists')}}">Artist</a></li>
                @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))

                <li><a href="{{ route('customer.customerpurchases')}}">My Purchases</a></li>
                @endif
                @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                @else
                <li class="logout">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a>
                    </form>
                </li>
                @endguest
            </ul>
        </nav>
    </div>
    <br>
    <br>

    @yield("content")
    {{--bootsrap jscrpt--}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
<style>
    .container-fluid {
        margin-left: 0;
        padding-left: 0;
    }

    .navbar {
        background-color: transparent;
        position: fixed;
        width: 100%;
        z-index: 999;
    }

    .navbar:hover {
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(5px);
    }

    .navbar:hover .logo,
    .navbar:hover .menu li a {
        color: black;
    }

    .logo {
        float: left;
        padding: 10px;
        font-size: 25px;
        font-weight: bold;
        font-family: Helvetica, Arial, sans-serif;
        color: black;
    }

    .menu {
        float: right;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .menu li {
        list-style: none;
        margin: 0 10px;
        line-height: 50px;
    }

    .menu li a {
        text-decoration: none;
        color: #fff;
        font-size: 15px;
        position: relative;
        font-family: Helvetica, Arial, sans-serif;
        color: black;

    }

    .menu li a:hover {
        color: whitesmoke;
    }

    .menu li a::before {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: black;
        transition: width 0.5s ease-in-out;
    }

    .menu li a:hover::before {
        width: 100%;
    }
</style>