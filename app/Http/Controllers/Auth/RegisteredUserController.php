<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMSController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

   public function verifyCodeForm(){
        return view('auth.verify-code');
    }

    public function verifyCode(Request $request){
        $nationalCode = $request->input('national_code');
        $inputCode = $request->input('verification_code');

        $user = User::where('national_code', $nationalCode)->first();

        if ($user && $user->code_expires_at && Hash::check($inputCode, $user->verification_code)) {
            $user->verification_code = null;
            $user->code_expires_at = null;
            $user->save();


            return view('dashboard');
        } else {
            return back()->withErrors(['verification_code' => 'کد وارد شده صحیح نیست یا منقضی شده است.']);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric', 'digits:11'],
            'type' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'وارد کردن نام الزامی است',
            'mobile.required' => 'وارد کردن شماره موبایل الزامی است',
            'mobile.digits' => 'شماره موبایل باید 11 رقم باشد',
            'mobile.numeric' => 'شماره موبایل باید بصورت عددی وارد شود',
            'type.required' => 'انتخاب کردن مرکز الزامی است',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $verificationCode = rand(100000, 999999);

        $user = User::create([
            'national_code' => $request->national_code,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'type' => $request->type,
            'verification_code' => Hash::make($verificationCode),
            'code_expires_at' => Carbon::now()->addMinutes(4)
        ]);

        event(new Registered($user));

        Auth::login($user);

        $message = "کاربر گرامی \n کد تایید شما : $verificationCode";
        $smsSender = new SMSController();
        $smsSender->send($user->mobile, $message);

        return redirect()->route('verify-code-form')->with([
            'verification_code' => $verificationCode,
            'national_code' => $user->national_code
        ]);
    }
}
