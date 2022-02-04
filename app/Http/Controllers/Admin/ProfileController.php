<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function index() {
        return view('admin.profile.index');
    }

    public function update(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        Alert::success('Sukses', 'Nama dan Email berhasil diupdate');
        return redirect()->route('profile');
    }

    public function update_password(Request $request) {

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        Alert::success('Sukses', 'Password berhasil diganti');
        return redirect()->route('profile');
    }
}
