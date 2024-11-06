<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function checkNationalCode(Request $request)
    {
        $nationalCode = $request->input('national_code');

        // بررسی اینکه آیا کد ملی در جدول کاربران وجود دارد یا خیر
        $user = User::where('national_code', $nationalCode)->first();

        if ($user) {
            $verificationCode = rand(100000, 999999);
            $user->verification_code = Hash::make($verificationCode);
            $user->code_expires_at = Carbon::now()->addMinutes(4);
            $user->save();

            $message = "کاربر گرامی \n کد تایید شما : $verificationCode";
            $smsSender = new SmsController();
            $smsSender->send($user->mobile, $message);

            // ارسال کد به کاربر (در اینجا نمایش کد برای راحتی، در عمل باید ایمیل/پیامک شود)
            return redirect()->route('verify-code-form')->with([
                'verification_code' => $verificationCode,
                'national_code' => $nationalCode
            ]);
        } else {
            return redirect()->route('register')->with('national_code', $nationalCode);
        }
    }
}
