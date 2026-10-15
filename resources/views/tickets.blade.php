@extends('layouts.app')

@section('content')

    <body class="sb-nav-fixed">
        <div class="container" style="margin-top: 100px">
            <!-- Judul Besar -->
            <h1 class="fw-bold text-center mb-3">Ticket List</h1>

            <!-- Search Bar -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <form action="{{ route('tickets') }}" method="GET">
                        <div class="row g-2">
                            <!-- Input Pencarian -->
                            <div class="col">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Cari tiket..."
                                        value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>

                            <!-- Dropdown Urutkan (Lebih Kecil) -->
                            <div class="col-auto">
                                <select class="form-select w-auto" name="sort" onchange="this.form.submit()">
                                    <option value="" disabled selected>Urutkan</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama
                                    </option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Populer
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <!-- Daftar Tiket -->
            <div class="row" id="tickets">
                @if ($events->isNotEmpty())
                    @foreach ($events as $event)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card shadow-lg border-0 rounded-3">
                                @if ($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top"
                                        alt="{{ $event->name }}"
                                        style="max-height: 120px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                @endif
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <p class="text-muted">Event Date: {{ $event->start_date }}</p>
                                    @if ($minPrice !== INF)
                                        <p class="fw-bold text-dark">Price: Rp. {{ number_format($minPrice, 0, ',', '.') }}
                                        </p>
                                    @endif
                                    <a href="{{ route('buy.ticket', $event->id) }}"
                                        class="btn btn-primary buy-ticket-btn text-white">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        @if (request('search'))
                            <p class="text-muted">The ticket you are looking for is not found.</p>
                        @else
                            <p class="text-muted">There are currently no tickets available.</p>
                        @endif
                    </div>
                @endif

            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $events->appends(request()->query())->links() }}
            </div>

        </div>

    </body>
@endsection
