@extends('layouts.admin')

@section('content')

    <body class="sb-nav-fixed">
        <main>
            <div class="container px-5 my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 rounded-3 shadow-lg">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="h1 fw-light">Edit Ticket</div>
                                    <p class="mb-4 text-muted">Edit ticket data </p>
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

                                <form action="{{ route('admin.ticket.update', $ticket->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method ('PUT')


                                    <div class="form-floating mb-3">
                                        <select name="event_id" id="event_id" class="form-select">
                                            <option value="Select Events" disabled selected>Select Event</option>
                                            @foreach ($events as $event)
                                            <option value="{{ $event->id }}" {{ old('event_id', $ticket->event_id) == $event->id ? 'selected' : '' }}>
                                                {{ $event->name }}
                                            </option>
                                            
                                            @endforeach
                                        </select>
                                        <label for="Event">Events</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="Select category" disabled selected>Select Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            
                                            @endforeach
                                        </select>
                                        <label for="Event">Category</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="price" type="number"
                                            value="{{ old('stock', $ticket->stock) }}" name="stock" placeholder="Stock" />
                                        <label for="price">Stock</label>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" id="submitButton"
                                            type="submit">Submit</button>
                                    </div>
                                </form>
                                <!-- End of contact form -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </body>
    <style>

    </style>

    <!-- CDN Link to SB Forms Scripts -->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
@endsection
