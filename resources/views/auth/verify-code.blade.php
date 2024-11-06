@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>تأیید کد</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('verify-code') }}" method="POST">
                        @csrf
                        <input type="hidden" name="national_code" value="{{ session('national_code') }}">

                        <div class="form-group">
                            <label for="verification_code">کد تأیید:</label>
                            <input type="text" name="verification_code" id="verification_code" class="form-control" required placeholder="کد تأیید را وارد کنید">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">تأیید</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
