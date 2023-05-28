@extends('master_layout.layout')

@section('title', 'Users')

@section('content')

<body>
    @yield('content')
    <br>
    <div class="container">
        <h1 style="text-align:center">EDIT ACCOUNT</h1>
        <br>
        <div class="container my-3">
            <form id="search-form" class="search-form" method="GET" action="{{ route('crud.list') }}">
                <label for="search-input" class="sr-only">Search</label>
                <input id="search-input" class="search-input" type="search" name="search" value="{{ $searchTerm ?? '' }}" placeholder="Search">
                <button class="search-button" type="submit">Search</button>
            </form>
        </div>
        <table id="user-table" class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    @if (auth()->user()->is_admin == 1)
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($users->isEmpty())
                <tr>
                    <td colspan="5">{{ $message }}</td>
                </tr>
                @endif
                @if($users->count())
                @if(!empty($searchTerm))
                <tr>
                    <td colspan="6">
                        <p>Showing {{ $users->total() }} records for the search term: {{ $searchTerm }}</p>
                    </td>
                </tr>
                @endif
                @foreach($users as $data)
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->password }}</td>
                    <td>{{ $data->role_name }}</td>

                    @if (auth()->user()->is_admin == 1)
                    <td>
                        <div>
                            <button type="button" class="editBtn" data-toggle="modal" data-target="#editModal{{ $data->id }}"><i class="fas fa-edit"></i> Edit</button>
                        </div>
                    </td>
                    <td>
                        <div>
                            <button type="button" class="deleteBtn" data-toggle="modal" data-target="#deleteModal{{ $data->id }}"><span class="text">Delete</span><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
                                    </svg></span></button>
                        </div>
                    </td>
                    @endif
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $data->id }}">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.update', $data->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{ $data->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    @if (auth()->user()->is_admin == 1)
                                    <div class="form-group">
                                        <option value="">Select Role</option>
                                        <select class="form-control" id="role_id" name="role_id">
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $data->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                    </div>
                                    @endif
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $data->id }}">Confirm Deletion</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this user?</p>
                                <p><strong>{{ $data->name }}</strong> will be permanently deleted.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form action="{{ route('user.destroy', $data->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @endif
            </tbody>
        </table>
        {{ $users->links('vendor.pagination.bootstrap-5') ->with([
        'class' => 'pagination justify-content-center',
        'previousClass' => 'page-item',
        'previousActiveClass' => 'active',
        'previousLinkClass' => 'page-link',
        'nextClass' => 'page-item',
        'nextActiveClass' => 'active',
        'nextLinkClass' => 'page-link',
        'linkClass' => 'page-link',
        'disabledClass' => 'disabled',
        'activeClass' => 'active'
    ]) }}
        <button class="btn btn-primary" onclick="generatePDF()">Download PDF</button>

    </div>

</body>

<script>
    // Get the search input and table elements
    const searchInput = document.querySelector('#search-input');
    const userTable = document.querySelector('#user-table');

    // Listen for changes to the search input
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        // Loop through each row in the table
        Array.from(userTable.querySelectorAll('tbody tr')).forEach((row) => {
            // Get the text content of each cell in the row
            const cells = Array.from(row.querySelectorAll('td'));
            const cellText = cells.map(cell => cell.textContent.trim().toLowerCase());
            // If the search term matches any of the cell text, show the row, otherwise hide it
            const isMatch = cellText.some(text => text.includes(searchTerm));
            row.style.display = isMatch ? 'table-row' : 'none';
        });
    });
</script>

<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.5;
        color: #fff;
        background-color: #F8F8F9;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    h1 {
        color: black;
        font-weight: 600;
    }

    .modal-body,
    .modal-header {
        color: black;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border: none;
        background-color: #fff;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table th,
    .table td {
        border: none;
        padding: 1rem;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
        color: #333;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.1rem;
        font-size: 0.9rem;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .table td a.btn {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        font-size: 0.9rem;
    }

    .table td button.btn {
        color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        font-size: 0.9rem;
    }

    .table td button.btn:hover {
        background-color: #c82333;
    }

    .table td form {
        display: inline-block;
    }

    .modal-content {
        border-radius: 0.5rem;
    }

    .pagination .page-item .page-link {
        background-color: #343a40;
        border-color: #343a40;
        color: white;
    }

    .pagination .page-item.active .page-link {
        background-color: white;
        border-color: #343a40;
        color: #6c757d;
    }

    .search-form {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .search-input {
        font-size: 1rem;
        padding: 0.5rem;
        border: none;
        border-radius: 0.25rem 0 0 0.25rem;
    }

    .search-button {
        font-size: 1rem;
        color: #fff;
        background-color: #6c757d;
        border: none;
        border-radius: 0 0.25rem 0.25rem 0;
        padding: 0.5rem 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-button:hover {
        background-color: #343a40;
    }

    #search-form {
        margin: 0 auto;
        width: 400px;
    }

    #search-input {
        width: 100%;
    }

    .editBtn {
        background-color: #111827;
        border: 1px solid transparent;
        border-radius: 10px;
        box-sizing: border-box;
        color: #FFFFFF;
        cursor: pointer;
        flex: 0 0 auto;
        font-family: "Inter var", ui-sans-serif, system-ui, -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1.125rem;
        font-weight: 300;
        line-height: 1.2rem;
        padding: .75rem 1.2rem;
        text-align: center;
        text-decoration: none #6B7280 solid;
        text-decoration-thickness: auto;
        transition-duration: .2s;
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(.4, 0, 0.2, 1);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: auto;
    }

    .editBtn:hover {
        background-color: #374151;
    }

    .editBtn:focus {
        box-shadow: none;
        outline: 2px solid white;
        outline-offset: 2px;
    }

    @media (min-width: 768px) {
        .editBtn {
            padding: .75rem 1.5rem;
        }
    }

    .deleteBtn {
        width: 150px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        background: red;
        border: none;
        border-radius: 5px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        background: #e62222;
    }

    .deleteBtn,
    .deleteBtn span {
        transition: 200ms;
    }

    .deleteBtn .text {
        transform: translateX(35px);
        color: white;
    }

    .deleteBtn .icon {
        position: absolute;
        border-left: 1px solid #c41b1b;
        transform: translateX(110px);
        height: 40px;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .deleteBtn svg {
        width: 15px;
        fill: #eee;
    }

    .deleteBtn:hover {
        background: #ff3636;
    }

    .deleteBtn:hover .text {
        color: transparent;
    }

    .deleteBtn:hover .icon {
        width: 150px;
        border-left: none;
        transform: translateX(0);
    }

    .deleteBtn:focus {
        outline: none;
    }

    .deleteBtn:active .icon svg {
        transform: scale(0.8);
    }
</style>
@endsection