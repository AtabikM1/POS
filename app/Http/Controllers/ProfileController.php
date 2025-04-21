<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activeMenu = 'profile';
        $breadcrumb = (object)[
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        return view('profile.index', compact('user', 'activeMenu', 'breadcrumb'));
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        // Hapus foto lama jika ada
        if ($user->foto && Storage::exists("public/uploads/profile_photos/{$user->foto}")) {
            Storage::delete("public/uploads/profile_photos/{$user->foto}");
        }

        /** @var \App\Models\User $user **/
        // Simpan foto baru
        if ($request->hasFile('foto')) {
            // Menyimpan foto ke dalam folder public/uploads/profile_photos
            $path = $request->file('foto')->storeAs('public/uploads/profile_photos', uniqid() . '.' . $request->file('foto')->getClientOriginalExtension());

            // Mendapatkan nama file yang disimpan
            $namaFile = basename($path);

            // Update nama file foto di database
            $user->foto = $namaFile;
            $user->save();

            return back()->with('success', 'Foto berhasil diubah');
        }

        return back()->with('error', 'Foto gagal diunggah');
    }
}
