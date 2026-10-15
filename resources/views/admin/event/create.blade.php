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
                                    <div class="h1 fw-light">Add Event</div>
                                    <p class="mb-4 text-muted">Add detail event</p>
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

                                <form action="{{ route('admin.event.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- Name Input -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="name" type="text" placeholder="Name"
                                            name="name" value="{{ old('name') }}" />
                                        <label for="name">Name</label>
                                        <div class="invalid-feedback" data-sb-feedback="name:required">Name is required.
                                        </div>
                                    </div>

                                    <!-- image Input -->
                                    Image
                                    <div class="mb-3">
                                        <input class="form-control" type="file" name="image"
                                            accept=".jpg,.jpeg,.png" />
                                    </div>

                                    Seat map
                                    <div class="mb-3">
                                        <input class="form-control" type="file" name="seat_map"
                                            accept=".jpg,.jpeg,.png" />

                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="message" type="text" placeholder="Description" style="height: 10rem;"
                                            name="description">{{ old('description') }}</textarea>
                                        <label for="message">Description</label>
                                        <div class="invalid-feedback" data-sb-feedback="message:required">Message is
                                            required.</div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="location" type="text" placeholder="Location"
                                            name="location" value="{{ old('location') }}" />
                                        <label for="location">Location</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="start_date" type="datetime-local"
                                            value="{{ old('start_date') }}" name="start_date" placeholder="start date" />
                                        <label for="start_date">Start date</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="name" type="datetime-local"
                                            value="{{ old('end_date') }}" name="end_date" placeholder="Name" />
                                        <label for="end_date">End date</label>
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
