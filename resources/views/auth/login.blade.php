@extends('layouts.app')



@section('content')
    <div class="container mt-5">
        <!-- فرم ثبت نام همایش -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partial-views.logo')
                <div class="card">
                    <div class="card-header">
                        ثبت‌نام در همایش اتحادیه کشوری سوخت‌های جایگزین
                    </div>
                    <div class="card-body">
                        <form action="{{ route('check-national-code') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name">کدملی: </label>
                                <input type="text" name="national_code" id="national_code" class="form-control" required placeholder="کدملی خود را وارد کنید">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">ورود</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- اسکریپت jQuery برای نمایش و پنهان‌سازی جزئیات کارگاه‌ها -->


@endsection

