@extends('master_layout.layout')

@section('title', 'Artworks')

@section('content')

<h1 class="text-center mt-5 mb-4">ARTWORKS</h1>
<div class="text-center">
    @if (auth()->user()->is_admin == 1)
    <button type="button" class="btn btn-1" data-toggle="modal" data-target="#addModal">
        Add Artwork
    </button>
    @endif
</div>

<!-- Add Artwork Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Artwork</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('artworks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Price(USD):</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="image_url">Image URL:</label>
                        <input type="text" name="image_url" id="image_url" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="artist_id">Artist:</label>
                        <select name="artist" id="artist" class="form-control" required>
                            <option value="">Select an artist</option>
                            @foreach($artists as $artist)
                            <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modalBtn" data-dismiss="modal">Close</button>
                    <button type="submit" class="modalBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card-deck">
    @foreach ($artworks as $index => $artwork)
    @if ($index % 5 == 0)
    <div class="row">
        @endif
        <div class="card">
            <img class="card-img-top" src="{{ $artwork->image_url }}" alt="{{ $artwork->title }}">
            <div class="card-body">
                <h5 class="card-title">{{ $artwork->title }}</h5>
                <p class="card-text">{{ $artwork->description }}</p>
                <p class="card-text"><small class="text-muted">Artist: {{ $artwork->artist_name }}</small></p>
                <p class="card-text"><strong>USD ${{ $artwork->price }}</strong></p>
                @if (auth()->user()->is_admin == 0)
                <a href="{{ route('purchase_artwork', ['artwork_id' => $artwork->id]) }}" id="buyBtn{{ $artwork->id }}" class="actionBtn" onclick="displayPurchaseModal()">Buy</a>
                @endif
                @if (auth()->user()->is_admin == 1)
                <button type="button" class="actionBtn" data-toggle="modal" data-target="#editModal{{ $artwork->id }}">
                    Edit Artwork
                </button>
                @endif
            </div>
            <div class="modal fade" id="editModal{{ $artwork->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('artworks.update', $artwork->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="artist_id" value="{{ $artwork->artist_id }}">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Artwork</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ $artwork->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea name="description" id="description" class="form-control">{{ $artwork->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price(USD):</label>
                                    <input type="number" name="price" id="price" class="form-control" value="{{ $artwork->price }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="image_url">Image URL:</label>
                                    <input type="text" name="image_url" id="image_url" class="form-control" value="{{ $artwork->image_url }}">
                                </div>
                                <div class="form-group">
                                    <label for="artist_id">Artist:</label>
                                    <select name="artist_id" id="artist_id" class="form-control">
                                        <option value="">Select an artist</option>
                                        @foreach($artists as $artist)
                                        <option value="{{ $artist->id }}" @if($artwork->artist_id == $artist->id) selected @endif>{{ $artist->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="modalBtn" data-dismiss="modal">Close</button>
                                <button type="submit" class="modalBtn">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        @if (($index + 1) % 5 == 0 || ($index + 1) == count($artworks))
    </div>
    @endif
    @endforeach
</div>


<script>
    function displayPurchaseModal() {
        // Create a new modal element
        var modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.id = 'purchaseModal';
        modal.tabIndex = '-1';
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-labelledby', 'purchaseModalLabel');
        modal.setAttribute('aria-hidden', 'true');
        modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseModalLabel">Thank you for purchasing!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Please wait for the approval of your order.
                </div>
            </div>
        </div>
    `;

        // Add the modal to the page
        document.body.appendChild(modal);

        // Show the modal
        $('#purchaseModal').modal('show');
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

    .modal-body,
    .modal-header,
    .modal-footer,
    .modal-title {
        color: black;
    }

    .card-deck {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        max-width: 1000px;
        margin: 0 auto;
    }

    .card {
        margin: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: none;
        border-radius: 5px;
        overflow: hidden;
        flex: 1 1 calc(33.33% - 40px);
        max-width: calc(33.33% - 40px);

    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        height: 350px;
        width: 400px;
        overflow: hidden;
    }

    .card-img-top {
        height: 100%;
        object-fit: cover;
    }

    .card-title {
        margin-bottom: 10px;
        font-size: 28px;
        font-weight: bold;
        color: #222;
    }

    .card-text {
        margin-bottom: 10px;
        font-size: 18px;
        line-height: 1.4;
        color: #555;
    }

    .text-muted {
        color: #999;
        font-size: 16px;
    }

    h1 {
        color: black;
        font-weight: 600;
    }
</style>


@endsection