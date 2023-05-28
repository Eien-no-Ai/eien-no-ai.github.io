@extends('master_layout.layout')

@section('title', 'My Purchases')

@section('content')
<div class="container py-5">
  <h1 class="text-center mb-4">Purchases</h1>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          
          <th>Purchase ID</th>
          <th>Artwork</th>
          <th>Artist</th>
          <th>Price</th>
          <th>Date Purchased</th>
          <th>Status</th>
  
          <th>Action</th>

        </tr>
      </thead>
      <tbody>
        @foreach($purchaseDetails as $purchaseDetail)
        <tr>
          <td>{{ $purchaseDetail->id }}</td>
          <td>{{ $purchaseDetail->artwork_title }}</td>
          <td>{{ $purchaseDetail->artist_name }}</td>
          <td>USD {{ $purchaseDetail->price }}</td>
          <td>{{ $purchaseDetail->created_at }}</td>
          <td>{{ $purchaseDetail->status_name }}</td>
          @if ($purchaseDetail->status_id == 1 && $purchaseDetail->cancellation_reason == null)
          <td>
            
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelPurchaseModal{{ $purchaseDetail->id }}">Cancel Purchase</button>
            <div class="modal fade" id="cancelPurchaseModal{{ $purchaseDetail->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelPurchaseModalLabel{{ $purchaseDetail->id }}" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('cancelPurchase', ['purchaseDetail' => $purchaseDetail->id]) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                      <h5 class="modal-title" id="cancelPurchaseModalLabel{{ $purchaseDetail->id }}">Cancel Purchase</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('cancelPurchase', $purchaseDetail->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="cancellation_reason">Cancellation Reason</label>
                            <input type="text" class="form-control" id="cancellation_reason" name="cancellation_reason" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Cancel Purchase</button>
                    </form>
                    </div>
                  </form>
                </div>
              </div>
            </div>
           
          </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  <div class="d-flex justify-content-between align-items-center">
    <div>
      Showing {{ $purchaseDetails->firstItem() }} to {{ $purchaseDetails->lastItem() }} of {{ $purchaseDetails->total() }} purchases
    </div>
    <div>
      {{ $purchaseDetails->links('pagination::bootstrap-4') }}
    </div>
  </div>
    <!-- Button trigger modal -->
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