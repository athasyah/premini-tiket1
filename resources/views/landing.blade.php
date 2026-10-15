@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div id="carouselExampleControls" class="carousel slide mb-5 mt-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($events as $key => $event)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ route('buy.ticket', $event->id) }}">
                            <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid w-100"
                                alt="{{ $event->name }}">
                        </a>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next " href="#carouselExampleControls" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </div>

    <div class="main-container">


        <!-- Carousel Section -->
        <div class="text-center my-5">
            <h1 class="fw-bold">Find and Get Your Favorite Event Tickets!</h1>
            <p class="text-muted">Get the Best Experience at Concerts, Sport, Seminars and more.</p>
            <a href="{{ route('tickets') }}" class="btn btn-primary btn-lg d-none d-md-inline-block">Explore Events</a>
            <a href="{{ route('tickets') }}" class="btn btn-primary btn-sm d-md-none">Explore Event </a>

        </div>


        <div class="p-3">
            <h2 class="mb-4">Popular Event</h2>
            <div class="position-relative">
                <div id="eventCarousel" class="d-flex overflow-hidden">
                    @forelse ($popularEvents as $index => $event)
                        <div class="event-card me-3">
                            <div class="card">
                                @if ($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top"
                                        alt="{{ $event->name }}" style="max-height: 120px; object-fit: cover;">
                                @endif
                                <div class="card-body text-start">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <p class="text-muted">
                                        @php
                                            $start = \Carbon\Carbon::parse($event->start_date);
                                            $end = \Carbon\Carbon::parse($event->end_date);

                                            if ($start->isSameDay($end)) {
                                                echo $start->translatedFormat('j F Y');
                                            } else {
                                                echo $start->translatedFormat('j M') .
                                                    ' - ' .
                                                    $end->translatedFormat('j M Y');
                                            }
                                        @endphp
                                    </p>
                                    <p class="fw-bold text-success">Sold: {{ $event->order_items_sum_quantity ?? 0 }} ticket
                                    </p>
                                    <a href="{{ route('buy.ticket', $event->id) }}" class="btn btn-primary text-white">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Skeleton Loader (Tampilkan saat data kosong) -->
                    @endforelse
                </div>


                <!-- Tombol Navigasi -->
                <button id="prevEvent" class="btn btn-info position-absolute start-0 top-50 translate-middle-y">‹</button>
                <button id="nextEvent" class="btn btn-info position-absolute end-0 top-50 translate-middle-y">›</button>
            </div>
        </div>
        <br><br>

        <!-- Section: Event Terbaru -->


        <div class="p-3">
            <h2 class="mb-4">Newest Event</h2>
            <div class="position-relative">

                <!-- Carousel Event Terbaru -->
                <div id="latestEventCarousel" class="d-flex overflow-hidden">
                    @forelse ($latestEvents as $event)
                        <div class="event-card me-3">
                            <div class="card">
                                @if ($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top"
                                        alt="{{ $event->name }}" style="max-height: 120px; object-fit: cover;">
                                @endif
                                <div class="card-body text-start">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <p class="text-muted">
                                        @php
                                            $start = \Carbon\Carbon::parse($event->start_date);
                                            $end = \Carbon\Carbon::parse($event->end_date);

                                            if ($start->isSameDay($end)) {
                                                echo $start->translatedFormat('j F Y');
                                            } else {
                                                echo $start->translatedFormat('j M') .
                                                    ' - ' .
                                                    $end->translatedFormat('j M Y');
                                            }
                                        @endphp
                                    </p>
                                    @if ($event->minPrice !== INF)
                                        <p class="fw-bold text-dark">Rp.
                                            {{ number_format($event->minPrice, 0, ',', '.') }}</p>
                                    @endif

                                    <a href="{{ route('buy.ticket', $event->id) }}" class="btn btn-primary text-white">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Skeleton Loader -->
                        @for ($i = 0; $i < 4; $i++)
                            <div class="event-card me-3">
                                <div class="card skeleton" style="height: 180px; width: 100%;"></div>
                            </div>
                        @endfor
                    @endforelse
                </div>

                <!-- Tombol Navigasi -->
                <button id="prevLatestEvent" class="btn btn-info position-absolute start-0 top-50 translate-middle-y"
                    style="display: none;">‹</button>
                <button id="nextLatestEvent" class="btn btn-info position-absolute end-0 top-50 translate-middle-y"
                    style="display: none;">›</button>
            </div>
        </div>

        <br><br><br>
    </div>




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function setupCarousel(carouselId, prevBtnId, nextBtnId) {
                const carousel = document.getElementById(carouselId);
                const prevBtn = document.getElementById(prevBtnId);
                const nextBtn = document.getElementById(nextBtnId);
                const eventCards = carousel.querySelectorAll(".event-card");

                if (eventCards.length === 0) return;

                let cardWidth = eventCards[0].offsetWidth + 16; // Lebar kartu + margin

                function updateButtons() {
                    prevBtn.style.display = carousel.scrollLeft > 0 ? "block" : "none";
                    nextBtn.style.display = carousel.scrollLeft < (carousel.scrollWidth - carousel.clientWidth) ?
                        "block" : "none";
                }

                nextBtn.addEventListener("click", function() {
                    carousel.scrollBy({
                        left: cardWidth,
                        behavior: "smooth"
                    });
                });

                prevBtn.addEventListener("click", function() {
                    carousel.scrollBy({
                        left: -cardWidth,
                        behavior: "smooth"
                    });
                });

                // Update ukuran kartu jika window diresize
                window.addEventListener("resize", function() {
                    cardWidth = eventCards[0].offsetWidth + 16;
                    updateButtons();
                });

                updateButtons();
                carousel.addEventListener("scroll", updateButtons);
            }

            setupCarousel("eventCarousel", "prevEvent", "nextEvent");
            setupCarousel("latestEventCarousel", "prevLatestEvent", "nextLatestEvent");
        });
    </script>


    <style>
        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            /* Sesuaikan ukuran */
            height: 50px;
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna latar */
            border-radius: 50%;
            /* Bulat */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 400% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: -100% 0;
            }
        }

        #carouselExampleControls {
            height: 50vh;
            /* Default untuk layar besar */
        }

        #carouselExampleControls .carousel-inner .carousel-item img {
            height: 50vh;
            object-fit: cover;
        }

        /* Responsif: Sesuaikan tinggi gambar di layar HP */
        @media (max-width: 768px) {
            #carouselExampleControls {
                height: auto;
                /* Biarkan tingginya menyesuaikan gambar */
            }

            #carouselExampleControls .carousel-inner .carousel-item img {
                height: auto;
                width: 100%;
                /* Agar gambar tetap penuh di layar */
                object-fit: contain;
                /* Pastikan gambar tidak terpotong */
            }
        }


        .main-container {
            max-width: 1700px;
            width: 100%;
            margin: 0 auto;
        }

        /* Pastikan hanya 4 tiket yang muncul dalam satu baris */
        .event-card {
            flex: 0 0 calc(25% - 16px);
            /* 4 tiket per baris */
            min-width: calc(25% - 16px);
            scroll-snap-align: start;
        }

        /* Responsif: Ubah jumlah tiket per baris sesuai lebar layar */
        @media (max-width: 1200px) {
            .event-card {
                flex: 0 0 calc(33.33% - 16px);
                /* 3 tiket per baris */
                min-width: calc(33.33% - 16px);
            }
        }

        @media (max-width: 768px) {
            .event-card {
                flex: 0 0 calc(50% - 16px);
                /* 2 tiket per baris */
                min-width: calc(50% - 16px);
            }
        }

        @media (max-width: 576px) {
            .event-card {
                flex: 0 0 100%;
                /* 1 tiket per baris */
                min-width: 100%;
            }
        }
    </style>
@endsection
