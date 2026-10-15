@extends('layouts.app')

@section('content')

    <body>
        <div class="container py-5">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
            <div class="row g-4 mt-4">
                <div class="container">
                    <div class="row align-items-start mt-3">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-md-7">
                            @if ($event)
                                <img src="{{ asset('storage/' . $event->seat_map) }}" class="img-fluid rounded-3"
                                    alt="{{ $event->name }}">
                            @else
                                <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid rounded-3"
                                    alt="{{ $event->name }}">
                            @endif
                        </div>
                        <div class="col-md-5 d-flex flex-column gap-3">
                            <div class="card p-3">
                                @if ($event)
                                    <h2 class="fw-bold">{{ $event->name }}</h2>
                                    <p class="text-muted mb-2"><i class="bi bi-calendar-event"></i>
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                    </p>
                                    <p class="text-muted mb-2">
                                        <i class="bi bi-clock"></i> Start
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} WIB
                                    </p>
                                    <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $event->location }}</p>
                                @endif
                            </div>
                            <div class="card p-3">
                                <h5 class="fw-bold">Payment Method</h5>
                                <label for="payment_method">Select Payment Method:</label>

                                <select name="payment_method" id="payment_method" class="form-select"
                                    onchange="showPaymentDetails()">
                                    <option value="">-- Select --</option>
                                    <option value="bank_transfer">Transfer Bank</option>
                                    <option value="ewallet">E-Wallet</option>
                                </select>

                                <div id="payment-details" class="mt-2"></div>
                            </div>

                            <div class="card p-3">
                                <div id="selected-tickets">
                                    <p class="text-muted"><i class="bi bi-ticket"></i> You haven't chosen a ticket yet.
                                        Select first in the TICKET menu tab.</p>
                                </div>

                                <hr>

                                <p class="fw-bold mb-1">Total <span id="total-tickets">0</span> ticket</p>
                                <h3 class="fw-bold text-dark">Rp. <span id="total-price">0</span></h3>

                                <form method="POST" action="{{ route('order.store') }}">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" id="selected_tickets" name="selected_tickets">
                                    <input type="hidden" id="payment_method_input" name="payment_method">
                                    <input type="hidden" id="payment_details_input" name="payment_details">
                                    @if (!auth()->check())
                                        <button id="buy-ticket-btn" type="submit" class="btn btn-primary"
                                            onclick="showLoginAlert(event)">Buy Ticket</button>
                                    @else
                                        <button id="buy-ticket-btn" type="submit" class="btn btn-primary" disabled>Buy
                                            Ticket</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs mt-3">
                    <li class="nav-item">
                        <a class="nav-link fw-bold active" id="ticket-tab" data-bs-toggle="tab"
                            href="#ticket-content">TICKET</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" id="description-tab" data-bs-toggle="tab"
                            href="#description-content">DESCRIPTION</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="ticket-content">
                        <div class="mt-4">
                            <div class="mb-3">
                                <input type="text" id="search-ticket" class="form-control" placeholder="Cari tiket..."
                                    onkeyup="filterTickets()">
                            </div>

                            <div class="row" id="ticket-container">
                                @foreach ($tickets as $ticket)
                                    <div class="col-lg-4 col-md-6 col-12 ticket-item">
                                        <div class="card p-3 mb-3">
                                            <h5 class="fw-bold ticket-name">{{ $ticket->category->name }}</h5>
                                            <p class="text-muted">
                                                <i class="bi bi-clock"></i> Berakhir
                                                {{ \Carbon\Carbon::parse($ticket->event->start_date)->format('d M Y') }}
                                            </p>

                                            @if (\Carbon\Carbon::now()->greaterThan($ticket->sale_end))
                                                <p class="text-danger fw-bold">SALE ENDED</p>
                                            @endif

                                            @if ($ticket->category)
                                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                                    <h4 class="fw-bold mb-0">
                                                        Rp{{ number_format($ticket->category->price, 0, ',', '.') }}</h4>

                                                    @if ($ticket->stock == 0)
                                                        <p class="mb-0 text-danger fw-bold ms-auto">SOLD</p>
                                                    @else
                                                        <p class="mb-0 ms-auto me-2">Stock: {{ $ticket->stock }}</p>
                                                        <select class="form-select ticket-select"
                                                            name="ticket[{{ $ticket->id }}]"
                                                            data-ticket-id="{{ $ticket->id }}"
                                                            data-ticket-name="{{ $ticket->name }}"
                                                            data-ticket-price="{{ $ticket->category->price }}"
                                                            style="width: 80px;">
                                                            <option value="0" selected>0</option>
                                                            @for ($i = 1; $i <= min(3, $ticket->stock); $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div> 
                        </div>
                    </div>

                    <div class="tab-pane fade" id="description-content">
                        @if ($event)
                            <h6>{{ $event->description }}</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var selectedTickets = @json($tickets);
            console.log("Data Tiket dari Laravel:", selectedTickets);
        </script>
        <script>
            document.querySelector("form").addEventListener("submit", function(event) {
                console.log("Data dikirim:", document.getElementById("selected_tickets").value);
                console.log("Metode Pembayaran:", document.getElementById("payment_method_input").value);
                console.log("Detail Pembayaran:", document.getElementById("payment_details_input").value);
            });

            function filterTickets() {
                let input = document.getElementById("search-ticket").value.toLowerCase();
                let tickets = document.querySelectorAll(".ticket-item");

                tickets.forEach(ticket => {
                    let name = ticket.querySelector(".ticket-name").textContent.toLowerCase();
                    ticket.style.display = name.includes(input) ? "block" : "none";
                });
            }

            function showPaymentDetails() {
                let method = document.getElementById("payment_method").value;
                let detailsDiv = document.getElementById("payment-details");
                detailsDiv.innerHTML = ""; // Reset
                if (method === "bank_transfer") {
                    detailsDiv.innerHTML = `
            <label for="bank_name">Select Bank:</label>
            <select name="bank_name" id="bank_name" class="form-select" required>
                <option value="">-- Select Bank --</option>
                <option value="BCA">BCA</option>
                <option value="BRI">BRI</option>
                <option value="Mandiri">Mandiri</option>
                <option value="BNI">BNI</option>
            </select>
            <label for="bank_account">Account Number:</label>
            <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="Enter the account number" required>
        `;
                } else if (method === "ewallet") {
                    detailsDiv.innerHTML = `
            <label for="ewallet_number">Phone Number:</label>
            <input type="text" name="ewallet_number" id="ewallet_number" class="form-control" placeholder="Enter phone number" required>
        `;
                }

                document.getElementById("payment_method_input").value = method;
                let inputs = detailsDiv.querySelectorAll("input");
                let detailsObj = {};
                inputs.forEach(input => {
                    detailsObj[input.name] = input.value || "";
                });
                document.getElementById("payment_details_input").value = JSON.stringify(detailsObj);
            }
            document.addEventListener("DOMContentLoaded", function() {
                let selectedTickets = JSON.parse(sessionStorage.getItem("selectedTickets")) || {};

                function updateTicketSummary() {
                    let container = document.getElementById("selected-tickets");
                    let totalTickets = 0;
                    let totalPrice = 0;
                    container.innerHTML = ""; // Reset isi container

                    Object.keys(selectedTickets).forEach(ticketId => {
                        let ticket = selectedTickets[ticketId];
                        if (ticket.quantity > 0) {
                            totalTickets += ticket.quantity;
                            totalPrice += ticket.subtotal;

                            let ticketElement = `
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0"><i class="bi bi-ticket-fill"></i> ${ticket.quantity}x {{ ($ticket->name )}}</p>
                    <p class="fw-bold mb-0">Rp${ticket.subtotal.toLocaleString("id-ID")}</p>
                </div>
            `;
                            container.innerHTML += ticketElement;
                        }
                    });

                    // Jika tidak ada tiket yang dipilih, tampilkan pesan default
                    if (totalTickets === 0) {
                        container.innerHTML =
                            `<p class="text-muted"><i class="bi bi-ticket"></i> You haven't chosen a ticket yet. Select first in the TICKET menu tab.</p>`;
                    }

                    // Update total tiket dan harga
                    document.getElementById("total-tickets").textContent = totalTickets;
                    document.getElementById("total-price").textContent = totalPrice.toLocaleString("id-ID");
                    document.getElementById("selected_tickets").value = JSON.stringify(selectedTickets);
                    sessionStorage.setItem("selectedTickets", JSON.stringify(selectedTickets));

                    let buyButton = document.getElementById("buy-ticket-btn");
                    buyButton.disabled = totalTickets === 0;
                }


                document.querySelectorAll(".ticket-select").forEach(select => {
                    select.addEventListener("change", function() {
                        let ticketId = this.dataset.ticketId;
                        let ticketName = this.dataset.ticketName;
                        let ticketPrice = parseInt(this.dataset.ticketPrice);
                        let quantity = parseInt(this.value);

                        if (quantity > 0) {
                            selectedTickets[ticketId] = {
                                id: ticketId,
                                name: ticketName,
                                price: ticketPrice,
                                quantity: quantity,
                                subtotal: ticketPrice * quantity
                            };
                        } else {
                            delete selectedTickets[ticketId];
                        }
                        updateTicketSummary();
                    });
                    let ticketId = select.dataset.ticketId;
                    if (selectedTickets[ticketId]) {
                        select.value = selectedTickets[ticketId].quantity;
                    }
                });

                updateTicketSummary();
            });
        </script>
        <script>
            document.querySelector("form").addEventListener("submit", function(event) {
                console.log("Data dikirim:", document.getElementById("selected_tickets").value);
                console.log("Metode Pembayaran:", document.getElementById("payment_method_input").value);
                console.log("Detail Pembayaran:", document.getElementById("payment_details_input").value);
            });
        </script>
        <script>
            document.getElementById("payment_method_input").value = document.getElementById("payment_method").value;
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                document.querySelectorAll(".beli-tiket").forEach(button => {
                    button.addEventListener("click", function(event) {
                        if (!isAuthenticated) {
                            event.preventDefault();
                            Swal.fire({
                                title: "You are not logged in yet!",
                                text: "Please login first to buy tickets.",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Login",
                                cancelButtonText: "Cancel"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('login') }}";
                                }
                            });
                        }
                    });
                });
            });
            document.querySelectorAll(".ticket-select").forEach(select => {
                select.addEventListener("change", function() {
                    let selectedTickets = [];
                    document.querySelectorAll(".ticket-select").forEach(select => {
                        let quantity = parseInt(select.value);
                        if (quantity > 0) {
                            selectedTickets.push({
                                id: select.dataset.ticketId,
                                name: select.dataset.ticketName,
                                price: parseInt(select.dataset.ticketPrice),
                                quantity: quantity,
                                subtotal: parseInt(select.dataset.ticketPrice) * quantity
                            });
                        }
                    });
                    document.getElementById("selected_tickets").value = JSON.stringify(selectedTickets);
                });
            });
        </script>
        <script>
            document.querySelector("form").addEventListener("submit", function(event) {
                let paymentDetails = {};
                let paymentMethod = document.getElementById("payment_method").value;
                if (paymentMethod === "bank_transfer") {
                    paymentDetails.bank_name = document.getElementById("bank_name").value;
                    paymentDetails.bank_account = document.getElementById("bank_account").value;
                } else if (paymentMethod === "ewallet") {
                    paymentDetails.ewallet_number = document.getElementById("ewallet_number").value;
                }
                document.getElementById("payment_method_input").value = paymentMethod;
                document.getElementById("payment_details_input").value = JSON.stringify(paymentDetails);
                console.log("Payment Method:", paymentMethod);
                console.log("Payment Details:", paymentDetails);
            });
            sessionStorage.removeItem("selectedTickets");
            selectedTickets = {};
            updateTicketSummary();
        </script>
        <script>
            document.querySelector("form").addEventListener("submit", function(event) {
                let paymentMethod = document.getElementById("payment_method").value;
                if (!paymentMethod) {
                    event.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Empty payment method!",
                        text: "Please select a payment method before proceeding.",
                    });
                    return;
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                document.getElementById("buy-ticket-btn").addEventListener("click", function(event) {
                    if (!isAuthenticated) {
                        event.preventDefault();
                        Swal.fire({
                            title: "You are not logged in yet!",
                            text: "Please login first to buy tickets.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Login",
                            cancelButtonText: "Cancel"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('login') }}";
                            }
                        });
                    }
                });
            });
        </script>
        <style>
            .nav-tabs .nav-link {
        color: rgb(0, 0, 0) !important;
    }

    .nav-tabs .nav-link.active {
        color: white !important;
        background-color: #007bff !important; /* Bootstrap Primary */
    }
        </style>
    </body>
@endsection
