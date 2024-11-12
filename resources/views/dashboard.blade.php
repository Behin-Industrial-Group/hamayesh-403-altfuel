@extends('layouts.app')



@section('content')
    <div class="container mt-5">
        <!-- فرم ثبت نام همایش -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('check-national-code') }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-primary btn-block p-6">تهیه بلیط برای همایش</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
