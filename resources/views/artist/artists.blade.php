@extends('master_layout.layout')

@section('title', 'Featured Artists')

@section('content')

<div class="modal fade" id="addArtistModal" tabindex="-1" role="dialog" aria-labelledby="addArtistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArtistModalLabel">Add Artist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('artist.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label" style="color: black;">Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bio" class="col-sm-3 col-form-label" style="color: black;">Bio:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="featured_artwork_image_url" class="col-sm-3 col-form-label" style="color: black;">Featured Artwork Image URL:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="featured_artwork_image_url" name="featured_artwork_image_url">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modalBtn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="modalBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <h1 class="text-center mt-5 mb-4">FEATURED ARTISTS</h1>
    <div class="text-center">
        @if (auth()->user()->is_admin == 1)
        <button class="btn btn-1" data-toggle="modal" data-target="#addArtistModal">Add Artist</button>
        @endif
    </div>
    <hr>
    <div class="row card-deck flex-wrap">
        @foreach ($artists as $artist)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ $artist->featured_artwork_image_url }}" class="card-img-top" style="max-height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $artist->name }}</h5>
                    <p class="card-text" style="font-size: 14px;">{{ $artist->bio }}</p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            @if (auth()->user()->is_admin == 1)
                            <button class="actionBtn" data-toggle="modal" data-target="#editArtistModal{{$artist->id}}" onclick="scrollToTop()">Edit</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <div class="modal fade" id="editArtistModal{{$artist->id}}" onclick="scrollToTop()" tabindex="-1" role="dialog" aria-labelledby="editArtistModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editArtistModalLabel" style="color: black;">Edit Artist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('artist.update', ['artist' => $artist->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label" style="color: black;">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $artist->name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bio" class="col-sm-3 col-form-label" style="color: black;">Bio:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="bio" name="bio" rows="3">{{ $artist->bio }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="featured_artwork_image_url" class="col-sm-3 col-form-label" style="color: black;">Featured Artwork Image URL:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="featured_artwork_image_url" name="featured_artwork_image_url" value="{{ $artist->featured_artwork_image_url }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modalBtn" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="modalBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0
        });
    }
</script>

<style>
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        line-height: 1.5;
        color: #fff;
        background-color: #F8F8F9;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .btn {
        text-decoration: none;
        padding: 20px 50px;
        font-size: 1.25rem;
        position: relative;
    }

    .btn-1 {
        color: black;
    }

    .btn-1:hover {
        color: black;
    }

    .btn-1::after,
    .btn-1::before {
        border: 3px solid black;
        content: "";
        position: absolute;
        width: calc(100% - 6px);
        height: calc(100% - 6px);
        left: 0;
        bottom: 0;
        z-index: -1;
        transition: transform 0.3s ease;
    }

    .btn-1:hover::after {
        transform: translate(-5px, -5px);
    }

    .btn-1:hover::before {
        transform: translate(5px, 5px);
    }

    .actionBtn {
        display: inline-block;
        transition: all 0.2s ease-in;
        position: relative;
        overflow: hidden;
        z-index: 1;
        color: #090909;
        padding: 0.7em 1.7em;
        font-size: 18px;
        border-radius: 0.5em;
        background: #e8e8e8;
        border: 1px solid #e8e8e8;
        box-shadow: 6px 6px 12px #c5c5c5,
            -6px -6px 12px #ffffff;
    }

    .actionBtn:active {
        color: #666;
        box-shadow: inset 4px 4px 12px #c5c5c5,
            inset -4px -4px 12px #ffffff;
    }

    .actionBtn:before {
        content: "";
        position: absolute;
        left: 50%;
        transform: translateX(-50%) scaleY(1) scaleX(1.25);
        top: 100%;
        width: 140%;
        height: 180%;
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 50%;
        display: block;
        transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
        z-index: -1;
    }

    .actionBtn:after {
        content: "";
        position: absolute;
        left: 55%;
        transform: translateX(-50%) scaleY(1) scaleX(1.45);
        top: 180%;
        width: 160%;
        height: 190%;
        background-color: #009087;
        border-radius: 50%;
        display: block;
        transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
        z-index: -1;
    }

    .actionBtn:hover {
        color: #ffffff;
        border: 1px solid #009087;
    }

    .actionBtn:hover:before {
        top: -35%;
        background-color: #009087;
        transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
    }

    .actionBtn:hover:after {
        top: -45%;
        background-color: #009087;
        transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
    }

    .modalBtn {
        color: #090909;
        padding: 0.7em 1.7em;
        font-size: 18px;
        border-radius: 0.5em;
        background: #e8e8e8;
        border: 1px solid #e8e8e8;
        transition: all .3s;
        box-shadow: 6px 6px 12px #c5c5c5,
            -6px -6px 12px #ffffff;
    }

    .modalBtn:hover {
        border: 1px solid white;
    }

    .modalBtn:active {
        box-shadow: 4px 4px 12px #c5c5c5,
            -4px -4px 12px #ffffff;
    }

    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background-color: transparent;
        transition: all 0.3s ease-in-out;
        height: 100%;
        color: black;
    }

    .card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        transform: translateY(-10px);
    }

    .card-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 16px;
        margin-bottom: 10px;
    }

    h1 {
        color: black;
        font-weight: 600;
    }

    .modal-content {
        background-color: #fff;
        border: none;
    }

    .modal-header {
        background-color: #fff;
    }

    .modal-title {
        color: black;
    }

    .form-control {
        background-color: #f2f2f2;
        border: none;
        border-radius: 0;
        color: #000;
    }
</style>
@endsection