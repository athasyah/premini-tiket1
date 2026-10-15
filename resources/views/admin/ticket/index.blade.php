@extends('layouts.admin')

@section('content')
    <body class="sb-nav-fixed">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tickets</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tickets</li>
                </ol>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                         Tickets Data
                    </div>
                
                    <div class="card-body">
                            <a href="{{ route('admin.ticket.create') }}"
                        class="btn btn-primary btn-sm mb-3">Add Ticket</a>
                        <table id="datatablesSimple"  class="sortable" data-sortable='[
                            {"select": 5, "sortable": false}
                        ]'>
                            <thead>
                                <tr><th>No</th>
                                    <th>Event</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Event</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ticket->event->name }}</td>
                                        <td>{{ $ticket->category->name }}</td>
                                        <td>{{ $ticket->stock }}</td>
                                        <td><a href="{{ route('admin.ticket.edit', $ticket->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a> 
                                                <form action="{{ route('admin.ticket.destroy', $ticket->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                </form>
                                            </td>
                                    
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </main>
        <style>
            /* Paksa ukuran kolom pertama */
            table#datatablesSimple th:first-child,
            table#datatablesSimple td:first-child {
                width: 50px !important;
                max-width: 50px !important;
                min-width: 50px !important;
                text-align: center;
                white-space: nowrap;
            }
            table#datatablesSimple th:last-child,
            table#datatablesSimple td:last-child {
                width: 50px !important;
                max-width: 200px !important;
                min-width: 200px !important;
                text-align: center;
                white-space: nowrap;
            }
        </style>
    </body>
    
@endsection

