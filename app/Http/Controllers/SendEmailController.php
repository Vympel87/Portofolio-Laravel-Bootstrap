<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        return view('kirim-email', [
            'title' => 'Email',
            'active' => 'email'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        dispatch(new SendMailJob($data));
            return redirect()->route('kirim-email')->with('success', 'Email berhasil dikirim');
    }

    public function sendVerif()
    {
        $user = Auth::user();
        $email = $user->email;

        $content = [
            'name' => $user->name,
            'subject' => 'Ini Subject Verif',
            'body' => 'Anda telah berhasil terdaftar di database. Coba untuk login untuk ke halaman dashboard'
        ];
        Mail::to($email)->send(new SendEmail($content));
        return "email berhasil dikirim";
    }

}