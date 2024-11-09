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
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <input type="hidden" name="national_code" value="{{ session('national_code') }}">

                            <div class="form-group">
                                <label for="name">نام و نام خانوادگی:</label>
                                <input type="text" name="name" id="name" class="form-control" required placeholder="نام و نام خانوادگی خود را وارد کنید">
                            </div>

                            <div class="form-group">
                                <label for="mobile">شماره موبایل:</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" required placeholder="شماره موبایل خود را وارد کنید">
                            </div>

                            <div class="form-group">
                                <label for="type">رسته مرکز:</label>
                                <input type="text" name="type" id="type" class="form-control" required placeholder="رسته مرکز خود را وارد کنید">
                            </div>

                            <!-- بخش کارگاه‌های آموزشی -->
                            <div class="form-group">
                                <label>کارگاه‌های آموزشی:</label>
                                <p class="toggle-info">نمایش جزئیات کارگاه‌ها</p>
                                <div class="workshop-info">
                                    <ul>
                                        <li>کارگاه ۱: آموزش فنی و ایمنی</li>
                                        <li>کارگاه ۲: تکنولوژی‌های جدید سوخت‌های جایگزین</li>
                                    </ul>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">ثبت‌نام</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- اسکریپت jQuery برای نمایش و پنهان‌سازی جزئیات کارگاه‌ها -->
    <script>
        $(document).ready(function() {
            $(".toggle-info").click(function() {
                $(".workshop-info").slideToggle(); // نمایش/پنهان کردن بخش کارگاه
                $(this).text($(this).text() === 'نمایش جزئیات کارگاه‌ها' ? 'پنهان کردن جزئیات کارگاه‌ها' : 'نمایش جزئیات کارگاه‌ها');
            });
        });
    </script>

@endsection

