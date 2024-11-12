<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function checkNationalCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'national_code' => ['required', 'numeric', 'digits:10'],
        ], [
            'national_code.required' => 'وارد کردن کد ملی الزامی است',
            'national_code.numeric' => 'کد ملی باید بصورت عددی وارد شود',
            'national_code.digits' => 'کد ملی باید 10 رقم باشد'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nationalCode = $request->input('national_code');

        $user = User::where('national_code', $nationalCode)->first();

        if ($user) {
            $verificationCode = rand(100000, 999999);
            $user->verification_code = Hash::make($verificationCode);
            $user->code_expires_at = Carbon::now()->addMinutes(4);
            $user->save();

            $message = "کاربر گرامی \n کد تایید شما : $verificationCode";
            $smsSender = new SmsController();
            $smsSender->send($user->mobile, $message);

            Auth::login($user);
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
