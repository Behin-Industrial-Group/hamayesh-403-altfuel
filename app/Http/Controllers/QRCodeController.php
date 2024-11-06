<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generate(Request $request)
    {
        $text = 'hello';
        $qrCode = QrCode::size(300)->generate($text); // تولید QR Code با اندازه ۳۰۰ پیکسل

        return view('qrcode.show', compact('qrCode'));
    }
}
