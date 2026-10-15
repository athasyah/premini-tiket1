@extends('layouts.user')

@section('content')
<body class="sb-nav-fixed">
    <center>
       <div class="">
        <!-- Bagian Foto Event -->
        <br>
        <br>
            <img src="{{ asset('storage/' . $ticket->event->image) }}" class="img-fluid rounded shadow" width="800px" alt="Event Image">
<br>
<br>
        <!-- Bagian Detail Tiket -->

                    <h2 class="card-title text-primary">{{ $ticket->event->name }}</h2>
                    <p class="text-muted"><i class="fas fa-calendar-alt"></i> {{ date('d M Y, H:i', strtotime($ticket->event->start_date)) }}</p>
                    
                    <hr>

                    <h5>Ticket Detail</h5>
                    <p><strong>Category:</strong> {{ $ticket->category->name }}</p>
                    <p><strong>Price:</strong> Rp{{ number_format($ticket->category->price, 0, ',', '.') }}</p>
                    <p><strong>Location:</strong> {{ $ticket->event->location }}</p>
                    
                    <hr>

                    <div     class="d-flex justify-content-between">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                        <a href="{{ route('buy.ticket', $ticket->event->id) }}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Buy Ticket</a>

        </div>
    </div> 
    <br><br><br><br>
    </center>
</body>
@endsection
