@extends('layouts.admin')

@section('content')

    <body class="sb-nav-fixed">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Admin</li>
                </ol>
                <div class="row">
                    <!-- Pendapatan Bulanan -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body">Income This Month: Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                {{-- <a class="small text-white stretched-link" href="{{ route('admin.revenue') }}">View Details</a> --}}
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Tiket Terjual Bulan Ini -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body">Tiket Sold: {{ $totalTicketsThisMonth }} ticket</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                {{-- <a class="small text-white stretched-link" href="{{ route('admin.tickets') }}">View Details</a> --}}
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Event Aktif -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Active event: {{ $activeEvents }} event</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                {{-- <a class="small text-white stretched-link" href="{{ route('admin.events') }}">View Details</a> --}}
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Pembayaran Gagal -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Payment Failed: {{ $failedPayments }} Transaction</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                {{-- <a class="small text-white stretched-link" href="{{ route('admin.failed-payments') }}">View Details</a> --}}
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Income per Month
                            </div>
                            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Number of Ticket sold
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Data dari Laravel
                let monthlyRevenue = @json($monthlyRevenue);
                let ticketSales = @json($ticketSales);
        
                console.log("Pendapatan Per Bulan: ", monthlyRevenue); 
                console.log("Jumlah Tiket Terjual: ", ticketSales); 
        
                // **Grafik Pendapatan Per Bulan (Line Chart)**
                let areaCtx = document.getElementById("myAreaChart").getContext("2d");
                new Chart(areaCtx, {
                    type: 'line',
                    data: {
                        labels: monthlyRevenue.map(data => data.month_name),
                        datasets: [{
                            label: "Pendapatan",
                            data: monthlyRevenue.map(data => data.total_revenue),
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            borderWidth: 2
                        }]
                    }
                });
        
                // **Grafik Jumlah Tiket Terjual (Bar Chart)**
                let barCtx = document.getElementById("myBarChart").getContext("2d");
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: ticketSales.map(data => data.month_name),
                        datasets: [{
                            label: "Jumlah Tiket",
                            data: ticketSales.map(data => data.total_tickets),
                            backgroundColor: "rgba(54, 162, 235, 0.5)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1
                        }]
                    }
                });
            });
        </script>
    </body>

    </html>
@endsection
