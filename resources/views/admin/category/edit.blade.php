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
                                    <div class="h1 fw-light">Edit Category</div>
                                    <p class="mb-4 text-muted">Edit category data</p>
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
                               
                                <form action="{{ route('admin.category.update', $category->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Name Input -->
                                    <div class="form-floating mb-3">
                                        <select name="event_id" id="event_id" class="form-select" >
                                            <option value="Select Events" disabled>Select Events</option>
                                            @foreach ($events as $event)
                                                <option value="{{ $event->id }} ">{{ $event->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="Event">Events</label>
                                    </div>

                                    <!-- image Input -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="name" type="text" placeholder="Name"
                                            name="name" value="{{ old('name', $category->name) }}" />
                                        <label for="name">Name</label>
                                        <div class="invalid-feedback" data-sb-feedback="name:required">Name is required.
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="price" type="number"
                                            value="{{ old('price', $category->price) }}" name="price" placeholder="price" />
                                        <label for="price">Price</label>
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
