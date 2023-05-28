<div class="container-fluid">
  <h1 style="text-align: center; vertical-align: middle; font-family: Arial, sans-serif; font-size: 24px; font-weight: bold;">REPORTS</h1>
  @if(count($artists) > 0)
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Owner</th>
            <th>Artwork Name</th>
            <th>Artist Name</th>
            <th>Price</th>
            <th>Status</th>
            <th>Art Piece</th>
            
          </tr>
        </thead>
        <tbody>
          @foreach($artists as $data)
            <tr>
              <td style="text-align: center; vertical-align: middle;">
              @if($data->statid==2)
              {{ $data->name }}
              @endif
              </td>
              <td style="text-align: center; vertical-align: middle;">{{ $data->title }}</td>
              <td style="text-align: center; vertical-align: middle;">{{ $data->artist->name }}</td>
              <td style="text-align: center; vertical-align: middle;">Php {{ $data->price*50}}</td>
              <td style="text-align: center; vertical-align: middle;">{{ $data->statusname }}</td>
              <td style="text-align: center; vertical-align: middle;"><img src="{{ $data->image_url }}" alt="Art Piece" style="width: 200px; height: 200px;"></td>

            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <p style="font-family: Arial, sans-serif; font-size: 16px;">No matching records found.</p>
  @endif
</div>
<style>
  .table-responsive {
    overflow-x: auto;
    max-width: 1000px;
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
</style>
<!--


<div class="container-fluid">
  <h1 style="text-align: center; vertical-align: middle; font-family: 'Times New Roman', serif;">REPORTS</h1>
  @if(count($artists) > 0)
    <table class="table table-bordered vintage-table">
            <tr>
                <th>ARTWORK NAME</th>
                <th>ARTIST NAME</th>
                <th>PRICE</th>
                <th>STATUS</th>
                <th>ART PIECE</th>
            </tr>
        @foreach($artists as $data)
            <tr>
              <td style="text-align: center; vertical-align: middle;">{{ $data->title }}</td>
              <td style="text-align: center; vertical-align: middle;">{{ $data->name }}</td>
              <td style="text-align: center; vertical-align: middle;">Php {{ $data->price }}</td>
              <td style="text-align: center; vertical-align: middle;">{{ $data->statusname }}</td>
              <td style="text-align: center; vertical-align: middle;"><img src="{{ $data->image_url }} " alt="Art Piece" style="width: 200px; height: 200px;"></td>
            </tr>
        @endforeach
    </table>
  @else
      <p>No matching records found.</p>
  @endif
</div>
   

<style>
  .table {
    width: 100%;
    font-family: 'Times New Roman', serif;
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

.vintage-table {
    background-color: #eae2c8;
    border-collapse: collapse;
    border: 1px solid #7d5d3b;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.vintage-table th {
    font-weight: normal;
    background-color: #b38151;
    color: #fff;
    border: 1px solid #7d5d3b;
}

.vintage-table td {
    border: 1px solid #7d5d3b;
}

</style>
--->
 