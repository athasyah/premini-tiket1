@extends('layouts.admin')

@section('content')
<body class="sb-nav-fixed">
    <div class="container px-5 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 rounded-3 shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h2 class="fw-light">Edit Ticket Fee</h2>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.ticket_fee.update', $ticketFee->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Pilih Tiket -->
                            <div class="form-floating mb-3">
                                <select name="ticket_id" class="form-select">
                                    <option value="" disabled>Select Ticket</option>
                                    @foreach ($tickets as $ticket)
                                        <option value="{{ $ticket->id }}" {{ (old('ticket_id', $ticketFee->ticket_id) == $ticket->id) ? 'selected' : '' }}>
                                            {{ $ticket->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="ticket_id">Ticket</label>
                            </div>

                            <!-- Pilih Fee -->
                            <div class="form-floating mb-3">
                                <select name="fee_id" class="form-select">
                                    <option value="" disabled>Select Fee</option>
                                    @foreach ($fees as $fee)
                                        <option value="{{ $fee->id }}" {{ (old('fee_id', $ticketFee->fee_id) == $fee->id) ? 'selected' : '' }}>
                                            {{ $fee->name }} ({{ ucfirst($fee->type) }})
                                        </option>
                                    @endforeach
                                </select>
                                <label for="fee_id">Fee</label>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" type="submit">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection