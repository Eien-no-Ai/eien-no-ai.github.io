@extends('master_layout.layout')
@section('content')
@section('title', 'Home')

<body>
    <script>
        setTimeout(function() {
            document.getElementById("dashboard-section").style.display = "none";
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>

    <div class="dashboard" id="dashboard-section">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        {{ __('Welcome') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main>
        <section class="hero">
            <h1>AVANT-GARDE</h1>
            <p>Discover the beauty of art</p>
            <a href="/app/home.blade.php" class="button">Go to Home</a> <!-- Added button with link to home.blade.php -->
        </section>

        <section class="gallery">
            <h2>Featured Artworks</h2>
            <div class="image-cards">
                <div class="card">
                    <img src="https://d3rf6j5nx5r04a.cloudfront.net/yutyW-PnhXrFKJXmreV-9ROVnJw=/1120x0/product/9/6/90dbfd4e72014769a70f45321decbb48_opt.jpg" alt="Artwork 1" />
                    <div class="card-content">
                        <h3>Spring tree</h3>
                        <p>by Lilia Orlova-Holmes</p>
                    </div>
                </div>
                <div class="card">
                    <img src="https://d3rf6j5nx5r04a.cloudfront.net/8yrn3vvnyBpdPS3psREkcIFW6ZU=/1120x0/product/d/e/47e1074b8b6c48978bef20ea78245550_opt.jpg" alt="Artwork 2" />
                    <div class="card-content">
                        <h3>Spring Rain and Blue Umbrella </h3>
                        <p>by Chin H Shin</p>
                    </div>
                </div>
                <div class="card">
                    <img src="https://d3rf6j5nx5r04a.cloudfront.net/dvk1dk5n7DdP_2hP8UxKH2G8FGs=/1120x0/product/d/b/d976390be6804284be2d3444289334ff_opt.jpg" alt="Artwork 3" />
                    <div class="card-content">
                        <h3>The girl's face 20/5</h3>
                        <p>by Livien Rózen</p>
                    </div>
                </div>
                <div class="card">
                    <img src="https://d3rf6j5nx5r04a.cloudfront.net/kxXJITNQ05tEUOw-sK75IqxpBus=/1120x0/product/e/f/7ba621d5892b411084d2d69f0ef3c5c7_opt.jpg" alt="Artwork 4" />
                    <div class="card-content">
                        <h3>Lighthouse and the sea</h3>
                        <p>by Olga David</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .dashboard {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.5;
        color: #fff;
        background-color: #F8F8F9;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        overflow-y: scroll;
        scroll-behavior: smooth;
    }

    main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    body .dashboard {
        color: black;
    }

    table {
        color: white;

    }

    .hero {
        text-align: center;
    }

    .hero h1{
        font-size: 3rem;
        margin-bottom: 1rem;
        color: black;
        font-weight: 600;
    }

    h2{
        color: black;
        font-weight: 600;
    }

    .hero p {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        color: black;
    }

    .gallery {
        margin-top: 2rem;
    }

    .gallery h3 {
        color: black;
    }

    .gallery h3 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }


    .image-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .card {
        display: flex;
        flex-direction: column;
        background-color: #fff;
        border-radius: 0.25rem;
        overflow: hidden;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-0.25rem);
    }

    .card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-content {
        padding: 1rem;
        text-align: center;
    }

    .card-content h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .card-content p {
        font-size: 1rem;
        color: #666;
    }
</style>
@endsection
