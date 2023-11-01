<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|max:255',
    //         'username' => ['required', 'min:3', 'max:255', 'unique:users'],
    //         'email' => 'required|email:dns|unique:users',
    //         'password' => 'required|min:8|max:255'
    //     ]);

    //     if (Auth::attempt($validatedData)) {
    //         $request->session()->regenerate();
    //         return redirect()->route("kirim-email")->withSuccess("You have successfully logged in!");
    //     }

    //     // $validatedData['password'] = bcrypt($validatedData['password']);
    //     $validatedData['password'] = Hash::make($validatedData['password']);

    //     User::create($validatedData);

    //     // $request->session()->flash('success', 'Registration succesfull! Try to login now');

    //     return redirect('/login')->with('success', 'Registration succesfull! Try to login now');
    // }

    public function store(Request $request)
    {
    // Validasi data yang diinput oleh pengguna
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'username' => ['required', 'min:3', 'max:255', 'unique:users'],
        'email' => 'required|email:dns|unique:users',
        'password' => 'required|min:8|max:255'
    ]);

    // Buat pengguna baru
    $user = User::create([
        'name' => $validatedData['name'],
        'username' => $validatedData['username'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Kirim email verifikasi
    $content = [
        'name' => $user->name,
        'subject' => 'Verifikasi Email',
        'body' => 'Terima kasih atas pendaftaran Anda. Silakan verifikasi alamat email Anda untuk mengaktifkan akun Anda.'
    ];

    Mail::to($user->email)->send(new SendEmail($content));

    // Setelah berhasil mendaftar, arahkan pengguna ke halaman login atau halaman konfirmasi pendaftaran.
    // Misalnya, Anda dapat mengarahkan pengguna ke halaman login dengan pesan sukses.
    return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login atau verifikasi email Anda.');
}

}
