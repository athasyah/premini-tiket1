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
                                <div class="h1 fw-light">Add Ticket</div>
                                <p class="mb-4 text-muted">Add stock for ticket</p>
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

                            <form action="{{ route('admin.ticket.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Dropdown Event -->
                                <div class="form-floating mb-3">
                                    <select name="event_id" id="event_id" class="form-select">
                                        <option value="" disabled selected>Select Event</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="event_id">Events</label>
                                </div>

                                <!-- Dropdown Category -->
                                <div class="form-floating mb-3">
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="" disabled selected>Select Category</option>
                                    </select>
                                    <label for="category_id">Category</label>
                                </div>

                                <!-- stock Input -->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="price" type="number" name="stock" placeholder="stock" value="{{ old('stock') }}" />
                                    <label for="stock">stock</label>
                                </div>

                                <!-- Submit button -->
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<!-- AJAX Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#event_id').change(function () {
            var eventId = $(this).val();
            if (eventId) {
                $.ajax({
                    url: '/admin/categories-by-event/' + eventId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#category_id').empty();
                        $('#category_id').append('<option value="" disabled selected>Select Category</option>');
                        $.each(data, function (key, category) {
                            $('#category_id').append('<option value="' + category.id + '">' + category.name + '</option>');
                        });
                    }
                });
            } else {
                $('#category_id').empty();
                $('#category_id').append('<option value="" disabled selected>Select Category</option>');
            }
        });
    });
</script>

@endsection
