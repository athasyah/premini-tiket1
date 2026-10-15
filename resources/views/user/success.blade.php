@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card text-center shadow-lg p-4" style="max-width: 500px;">
        <div class="card-body">
            <div class="checkmark">
                ✅
            </div>
            <h2 class="text-success fw-bold">Succeed!</h2>
            <p class="text-muted">The purchased or proccess you have done has been successful.</p>
            <a href="{{ url('user/dashboard') }}" class="btn btn-primary mt-3">
                <i class="bi bi-arrow-left"></i> Return to the Dashboard
            </a>
        </div>
    </div>
</div>

<style>
    .checkmark {
        font-size: 50px;
    }

    .card {
        border-radius: 15px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 16px;
    }
</style>
@endsection
