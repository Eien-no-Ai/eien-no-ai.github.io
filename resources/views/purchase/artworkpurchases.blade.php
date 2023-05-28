@extends('master_layout.layout')

@section('title', 'Purchases')

@section('content')

<div class="container py-5">
  <h1 class="text-center mb-4">Purchases</h1>
  
 
  <div class="container-fluid">
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="text-align: center; vertical-align: middle;">Purchase ID</th>
          <th style="text-align: center; vertical-align: middle;">Artwork</th>
          <th style="text-align: center; vertical-align: middle;">Artist</th>
          <th style="text-align: center; vertical-align: middle;">Price</th>
          <th style="text-align: center; vertical-align: middle;">User</th>
          <th style="text-align: center; vertical-align: middle;">Date Purchased</th>
          <th style="text-align: center; vertical-align: middle;">Status</th>
          <th colspan="2" style="text-align: center; vertical-align: middle;">Actions</th>
   
        </tr>
      </thead>
      <tbody>
        @foreach($artworkPurchases as $purchase)
        <tr>
          <td style="text-align: center; vertical-align: middle;">{{ $purchase->id }}</td>
          <td style="text-align: center; vertical-align: middle;">{{ $purchase->artwork->title }}</td>
          <td style="text-align: center; vertical-align: middle;">{{ $purchase->artist->name }}</td>
          <td style="text-align: center; vertical-align: middle;">USD {{ $purchase->price}}</td>
          <td style="text-align: center; vertical-align: middle;">{{ $purchase->user->name }}</td>
          <td style="text-align: center; vertical-align: middle;">{{ $purchase->created_at }}</td>
          <td style="text-align: center; vertical-align: middle;">
            @if ($purchase->cancellation_reason == false)
            {{ $purchase->status->name}}
            <br>
            @elseif ($purchase->cancellation_reason==true)
                <!-- Button trigger modal -->
                <a type="button" class="btn btn-default" data-toggle="modal" data-target="#cancelreason">
                  {{ $purchase->status->name}}
                </a>

                <!-- Modal -->
                <div class="modal fade" id="cancelreason" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Cancellation Reason:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <h4>{{ $purchase->cancellation_reason }}</h4>
                      </div>
                      <div class="modal-footer">
                        <form method="post" action="{{ route('purchases.cancel', $purchase) }}" style="display: inline;">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-sm btn-secondary">Approve Cancel</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            
           @endif
          </td>
          @if($purchase->status_id == 1)
          <td style="text-align: center; vertical-align: middle;">
            <form method="post" action="{{ route('purchases.approve', $purchase) }}" style="display: inline;">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn btn-sm btn-primary">Approve</button>
            </form>
          </td>
          <td style="text-align: center; vertical-align: middle;">
            <form method="post" action="{{ route('purchases.reject', $purchase) }}" style="display: inline;">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn btn-sm btn-danger">Reject</button>
            </form>
            @endif
          </td>
          @if($purchase->status_id == 3)
          <td style="text-align: center; vertical-align: middle;" colspan="2">
            <form method="post" action="{{ route('purchases.cancel', $purchase) }}" style="display: inline;">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn btn-sm btn-secondary">Approve Cancel</button>
            </form>
          </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center">
    <div>
      Showing {{ $artworkPurchases->firstItem() }} to {{ $artworkPurchases->lastItem() }} of {{ $artworkPurchases->total() }} purchases
    </div>
    <div>
      {{ $artworkPurchases->links('pagination::bootstrap-4') }}
    </div>
  </div>

    <!-- search Button trigger modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Download PDF
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Download Searched Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('generatePDF') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Download by title or artist name" name="search">
                <button class="btn btn-primary" type="submit">Download</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>

</div>

<style>
  body {
    font-family: 'Open Sans', sans-serif;
    font-size: 16px;
    line-height: 1.5;
    color: #333;
    background-color: #F8F8F9;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }

  .table-responsive {
    overflow-x: auto;
    max-width: 800px;
    margin: 0 auto;
  }

  .table {
    width: 100%;
    font-family: Arial, sans-serif;
    font-size: 14px;
    text-align: left;
  }

  .table th,
  .table td {
    padding: 12px 15px;
  }

  .table thead th {
    font-weight: 600;
    text-transform: uppercase;
    color: #777;
    border-bottom: 2px solid #ddd;
  }

  .table tbody tr:hover {
    background-color: #f5f5f5;
  }

  .table tbody td {
    color: #333;
    border-bottom: 1px solid #ddd;
  }

  .table tbody tr:last-child td {
    border-bottom: none;
  }

  .table tbody td:nth-child(odd) {
    background-color: #f9f9f9;
  }

  .table tbody tr:hover td {
    color: #000;
    background-color: #f5f5f5;
  }

  .pagination {
    margin: 0;
  }

  .page-link {
    color: #666;
    border-color: #ddd;
  }

  .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
  }
</style>
@endsection