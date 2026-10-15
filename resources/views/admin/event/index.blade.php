@extends('layouts.admin')

@section('content')

    <body class="sb-nav-fixed">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Events</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Events</li>
                </ol>
                {{-- <div class="card mb-4">
                    <div class="card-body">
                        DataTables is a third party plugin that is used to generate the demo table below. For more
                        information about DataTables, please visit the
                        <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                        .
                    </div>
                </div> --}}
                {{-- @if (!Auth::user() || !Auth::user()->hasRole('admin'))
                    @php abort(403, 'Unauthorized access'); @endphp
                @endif --}}

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Events
                    </div>

                    <div class="card-body">
                        <a href="{{ route('admin.event.create') }}" class="btn btn-primary btn-sm mb-3">Add Event</a>
                        <table id="datatablesSimple" class="sortable"
                            data-sortable='[
                            {"select": 2, "sortable": false},
                            {"select": 6, "sortable": false}
                        ]'>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Seat Map</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Seat Map</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $event->name }}</td>
                                        <td> <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                                                width="80"></td>
                                        <td> <img src="{{ asset('storage/' . $event->seat_map) }}" alt="Seat Map"
                                                width="80"></td>
                                        <td>{{ $event->description }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>{{ date('d M Y', strtotime($event->start_date)) }}</td>
                                        <td>{{ date('d M Y', strtotime($event->end_date)) }}</td>
                                        <td><a href="{{ route('admin.event.edit', $event->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST"
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
