@extends('layouts.admin')

@section('content')

    <body class="sb-nav-fixed">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Transaction</h1>
                <ol class="breadcrumb mb-4">
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Transaction Table
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name User</th>
                                    <th>Name Event</th>
                                    <th>Ticket Purchased</th>
                                    <th>Quantity</th>
                                    <th>Buy Date</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->user->name }}</td> <!-- Nama User -->
                                        <td>{{ $order->event->name }}</td> <!-- Nama Event -->
                                        <td>
                                            @foreach ($order->orderItems as $item)
                                                {{ $item->ticket->category->event->name }} - {{ $item->ticket->category->name }}<br> <!-- Nama Tiket -->
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($order->orderItems as $item)
                                                {{ $item->quantity }}<br> <!-- Jumlah Tiket -->
                                            @endforeach
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td> <!-- Tanggal Pembelian -->
                                        <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td> <!-- Total Harga -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>

    </html>
    <style>
        
    </style>
@endsection
