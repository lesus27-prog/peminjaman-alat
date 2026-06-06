<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AkunUser;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunUserController extends Controller
{
    // ==========================START PART ADMIN================================== //
    public function akunIndex()
    {
        $akuns = AkunUser::where('status_akun', 'aktif')->get();
        return view('admin.akun.akunIndex', compact('akuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:akun_user,username',
            'password' => 'required',
            'role' => 'required|in:admin,kabeng',
        ]);

        try {
            AkunUser::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'fcm_token' => null
            ]);

            return redirect()
                ->route('akun.index')
                ->with('store_success', $request->username);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('store_error', 'Data gagal ditambahkan');
        }
    }

    public function update(Request $request, $idAkunUser)
    {
        $request->validate([
            'username' => [
                'required',
                Rule::unique('akun_user', 'username')->ignore($idAkunUser, 'id_akun_user')
            ],
            'role' => 'required|in:admin,siswa,kabeng',
            'password_baru' => 'nullable|string|same:conf_pwd',
            'conf_pwd' => 'nullable|string|same:password_baru'
        ]);

        try {
            $akun = AkunUser::findOrFail($idAkunUser);
            $data = [
                'username' => $request->username,
                'role' => $request->role,
            ];

            if ($request->password_baru) {
                $data['password'] = Hash::make($request->password_baru);
            }

            $akun->update($data);
            return redirect()
                ->route('akun.index')
                ->with('update_success', $akun->username);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('update_error', 'Data gagal diupdate');
        }
    }

    public function checkUsername(Request $request)
    {
        $query = AkunUser::where('username', $request->username);

        if ($request->id_akun_user) {
            $query->where('id_akun_user', '!=', $request->id_akun_user);
        }

        $exist = $query->exists();

        return response()->json([
            'exist' => $exist
        ]);
    }

    public function delete($idAkunUser)
    {
        try {
            $akun = AkunUser::findOrFail($idAkunUser);
            $username = $akun->username;
            $akun->delete();

            return redirect()
                ->back()
                ->with('delete_success', $username);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('delete_error', 'Data gagal dihapus');
        }
    }

    public function exportPdf(Request $request)
    {
        if ($request->role) {
            $akuns = AkunUser::with('siswa')->where('role', $request->role)->get();
        } else {
            $akuns = AkunUser::all();
        }

        $pdf = Pdf::loadView('admin.akun.exportPdf', compact('akuns'));
        return $pdf->download('Data Akun User.pdf');
    }
    // ==========================END PART ADMIN================================== //


    // ==========================START PART SISWA================================== //
    public function profile()
    {
        $idSiswa = Auth::user()->siswa->id_siswa;
        $siswa = Siswa::with('akunUser')->findOrFail($idSiswa);
        return view('siswa.profile', compact('siswa'));
    }

    public function updateUsernameProfile(Request $request, $idAkunUser)
    {
        $request->validate([
            'username_baru' => 'required',
            'conf_username' => 'required|same:username_baru',
        ]);

        try {
            $akun = AkunUser::findOrFail($idAkunUser);

            $akun->update([
                'username' => $request->username
            ]);

            return redirect()
                ->back()
                ->with('update_success', 'Username berhasil diubah');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('update_error', 'Username gagal diubah!');
        }
    }

    public function updatePasswordProfile(Request $request, $idAkunUser)
    {
        $request->validate([
            'password_baru' => 'required',
            'conf_pwd' => 'required|same:password_baru',
        ]);

        try {
            $akun = AkunUser::findOrFail($idAkunUser);

            $akun->update([
                'password' => Hash::make($request->password_baru)
            ]);

            return redirect()
                ->back()
                ->with('update_success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('update_error', 'Password gagal diubah!');
        }
    }
    // ==========================END PART SISWA================================== //
}
