<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {

        if (Auth::guard('admin_pimpinan')->check()) {
            return redirect("/");
        }

        if (Auth::guard('alumni')->check()) {
            return redirect("/dashboard-alumni");
        }

        return view("Auth.login");
    }

    public function register() {

        if (Auth::guard('admin_pimpinan')->check()) {
            return redirect("/");
        }

        if (Auth::guard('alumni')->check()) {
            return redirect("/dashboard-alumni");
        }

        $provinsi = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
            'Jambi', 'Bengkulu', 'Sumatera Selatan', 'Kepulauan Bangka Belitung', 'Lampung',
            'DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur',
            'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara',
            'Maluku', 'Maluku Utara',
            'Papua Barat', 'Papua', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan', 'Papua Barat Daya',
        ];

        return view('Auth.register', [
            'provinsi' => $provinsi
        ]);
    }

    public function updateAdmin(Request $request, User $user) {
        $validated = $request->validate([
            'name' => 'required|max:230',
            'email' => [
                'required', 'max:70', 'email',
                'unique:admin_pimpinan,email,' . $user->id,
                'unique:alumnis,email'
            ],
            'password' => 'nullable|max:15', // Jadikan nullable saat update
              
        ]);

        // 4. Penanganan Password (Jangan diupdate jika kosong)
        if ($request->filled('password')) {
            // Jika Anda menggunakan Hash (sangat disarankan):
            // $validated['password'] = bcrypt($request->password);
            $validated['password'] = $request->password;
        } else {
            unset($validated['password']); // Hapus dari array agar tidak menimpa data lama
        }

        $user->update($validated);

        return back()->with('success', "Berhasil mengudpate data"); 
    }

    public function authentication(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|max:100|email',
            'password' => 'required|max:255'
        ]);

        if (Auth::guard('admin_pimpinan')->attempt($credentials)) {
            return redirect('/')->with('success', 'Selamat datang admin/pimpinan');
        }

        if (Auth::guard('alumni')->attempt($credentials)) {
            return redirect('/dashboard-alumni')->with('success', 'Selamat datang alumni');
        }

        return back()->with('loginFailed', 'Login Gagal!');
    }

    public function logout(Request $request) {
        if (Auth::guard('admin_pimpinan')->check()) {
            Auth::guard('admin_pimpinan')->logout();
        } else {
            Auth::guard('alumni')->logout();
        }

        return redirect('/login')->with('success', 'Berhasil logout');
    }    

}
