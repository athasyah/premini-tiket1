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
                                    <div class="h1 fw-light">Edit Fee</div>
                                    <p class="mb-4 text-muted">Update Fee Information</p>
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

                                <form action="{{ route('admin.fee.update', $fee->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Name Input -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="name" type="text" placeholder="Name"
                                            name="name" value="{{ old('name', $fee->name) }}" />
                                        <label for="name">Name</label>
                                    </div>

                                    <!-- Fee Type Dropdown -->
                                    <div class="form-floating mb-3">
                                        <select id="feeType" name="type" class="form-select" onchange="toggleInputs()">
                                            <option value="" disabled>Select type</option>
                                            <option value="fixed"  {{ old('type', $fee->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                            <option value="percent" {{ old('type', $fee->type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                        </select>
                                        <label for="type">Type</label>
                                    </div>

                                    <!-- Amount Input -->
                                    <div class="form-floating mb-3">
                                        <input type="number" id="amount" name="amount" class="form-control"
                                            step="0.01" min="0" value="{{ old('amount', $fee->amount) }}">
                                        <label for="amount">Amount</label>
                                    </div>

                                    <!-- Percentage Input -->
                                    <div class="form-floating mb-3">
                                        <input type="number" id="percentage" name="percentage" class="form-control"
                                            step="0.01" min="0" max="100" value="{{ old('percentage', $fee->percentage) }}">
                                        <label for="percentage">Percentage (%)</label>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" type="submit">Update Fee</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <script>
        function toggleInputs() {
            let feeType = document.getElementById("feeType").value;
            let amountInput = document.getElementById("amount");
            let percentageInput = document.getElementById("percentage");

            if (feeType === "fixed") {
                amountInput.disabled = false;
                percentageInput.disabled = true;
                percentageInput.value = ''; // Reset jika tidak digunakan
            } else if (feeType === "percent") {
                amountInput.disabled = true;
                amountInput.value = ''; // Reset jika tidak digunakan
                percentageInput.disabled = false;
            }
        }

        // Jalankan fungsi saat halaman dimuat untuk menangani nilai awal
        document.addEventListener("DOMContentLoaded", function() {
            toggleInputs();
        });
    </script>

@endsection
