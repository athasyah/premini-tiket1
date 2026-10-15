@extends('layouts.user')

@section('content')

    <body class="sb-nav-fixed">
        <main>
            <div class="container">
                <h1 class="">History</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">User</li>
                </ol>
                <div class="row">
                    <!-- Total Tiket yang Dibeli -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Ticket Total: {{ $total_tickets }}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <p>Total tickets you purchased</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tiket yang Akan Datang -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Upcoming event: {{ $upcoming_tickets }}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <p>The number of upcoming events you have booked</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tiket yang Sudah Digunakan -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Completed Event: {{ $used_tickets }}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <p>The number of events you have completed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pengeluaran -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Total Expenditure: Rp{{ number_format($total_spent, 0, ',', '.') }}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <p>total pengeluaran kamu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- List Tiket Terbaru -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-ticket-alt me-1"></i>
                        Lastest Ticket
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Posisi</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->event_name }}</td>
                                        <td>{{ $ticket->category_name }}</td>
                                        <td>Rp{{ number_format($ticket->price, 0, ',', '.') }} Total+fee> Rp{{ number_format($ticket->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($ticket->is_expired)
                                                <span class="badge bg-danger">Expired</span>
                                            @else
                                                <span class="badge bg-success">active</span>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('user.detail', ['id' => $ticket->id]) }}" class="btn btn-sm btn-primary">Detail</a>
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
             .container {
            max-width: 1700px;
            /* Ubah sesuai kebutuhan */
            width: 100%;
            margin: 0 auto;
            /* Agar tetap di tengah */
        }
        </style>
    </body>
@endsection
