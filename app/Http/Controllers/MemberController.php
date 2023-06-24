<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pengguna;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DataFisik;
use Illuminate\Support\Facades\Hash;


class MemberController extends Controller
{
    public function beranda(){
        $user = Auth::user();
        $pengguna = Pengguna::where('id', $user->id)->first();

        $show_data_fisik = DB::table('pengguna')
        ->leftjoin('data_fisik', 'data_fisik.id_pengguna', '=', 'pengguna.id')
        ->where('level', '=', 'Member')
        ->where('id_pengguna', $user->id)
        ->get();

        // SUMBU Y - BMI
        $y_bmi = DataFisik::select(DB::raw("body_mass"))
            ->where('id_pengguna', $user->id)
            ->orderBy('tgl')
            ->pluck('body_mass');

        // SUMBU X - BMI
        $x_bmi = DataFisik::select(DB::raw("tgl"))
            ->where('id_pengguna', $user->id)
            ->orderBy('tgl')
            ->pluck('tgl');

        // SUMBU Y - BFP
        $y_bfp = DataFisik::select(DB::raw("body_fat"))
            ->where('id_pengguna', $user->id)
            ->orderBy('tgl')
            ->pluck('body_fat');

        // SUMBU X - BFP
        $x_bfp = DataFisik::select(DB::raw("tgl"))
            ->where('id_pengguna', $user->id)
            ->orderBy('tgl')
            ->pluck('tgl');

        return view('beranda_member', ['imageName' => $pengguna->foto, 'show_data_fisik' => $show_data_fisik,
                    'y_bmi' => $y_bmi, 'x_bmi' => $x_bmi, 'y_bfp' => $y_bfp, 'x_bfp' => $x_bfp]);
    }

    public function jadwal(){
        $user = Auth::user();
        $pengguna = Pengguna::where('id', $user->id)->first();

        $show_jadwal = DB::table('jadwal')
            ->where('id_pengguna', $user->id)
            ->get();
        
        return view('jadwal_member', ['imageName' => $pengguna->foto, 'show_jadwal' => $show_jadwal,  'pengguna' => $pengguna]);
    }

    public function save_goal(Request $request){
        Jadwal::create([
            'id_pengguna' => $request->input('kode_pengguna'),
            'goal' => $request->input('goal'),
            'status' => 'Proses'
        ]);

        return back()->with('berhasil', 'Data goal telah ditambahkan');
    }

    public function edit_biodata(){
        $user = Auth::user();
        $pengguna = Pengguna::where('id', $user->id)->first();

        return view('biodata_member', ['pengguna' => $pengguna, 'imageName' => $pengguna->foto]);
    }

    public function update_biodata(Request $request){
        $request->validate([
            'tanggal_lahir' => 'nullable|date_format:Y/m/d',
            // Tambahkan aturan validasi lainnya di sini
        ], [
            'tanggal_lahir.nullable' => 'Kolom tanggal lahir harus diisi.',
            'tanggal_lahir.date_format' => 'Format tanggal lahir harus dalam format Y/m/d atau Tahun/Bulan/Tanggal.',
        ]);

        // Mengambil data pengguna yang sedang login
        $user = Auth::user();

        // Mengambil data formulir yang akan diperbarui
        $pengguna = Pengguna::where('id', $user->id)->first();

        // Validasi resolusi gambar
        // $this->validate($request, [
        //     'gambar' => 'dimensions:max_width=128, max_height=128',
        // ]);

        // Perbarui data formulir
        $pengguna->name = $request->input('nama_lengkap');
        $pengguna->tgl_lahir = $request->input('tanggal_lahir');
        $pengguna->gender = $request->input('option_gender');
        $pengguna->tlpn = $request->input('no_telepon');
        $pengguna->alamat = $request->input('alamat');
        $pengguna->kidal = $request->input('option_kidal');
        $pengguna->lama_pnglmn = $request->input('lama_pengalaman');
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = uniqid().'_'.$image->getClientOriginalName();

            // Simpan gambar yang diperbarui ke direktori penyimpanan yang sesuai
            $image->move(public_path('images/'), $imageName);

            // Update atribut 'image' pada model
            $pengguna->foto = $imageName;
        }
        // Simpan perubahan
        $pengguna->save();
        
        // Redirect ke halaman yang diinginkan setelah berhasil diperbarui
        return redirect()->route('editBiodata')->with('success', 'Data biodata telah diperbarui');
    }

    public function show_analisis_data_fisik($kode_pengguna){
        $show_analisis = DB::table('pengguna')
        ->leftjoin('data_fisik', 'data_fisik.id_pengguna', '=', 'pengguna.id')
        ->where('level', '=', 'Member')
        ->where('id_data_fisik', $kode_pengguna)
        ->first();

        return response()->json($show_analisis);
    }

    public function edit_akun(){
        $user = Auth::user();
        $pengguna = Pengguna::where('id', $user->id)->first();

        return view('akun_member', ['pengguna' => $pengguna, 'imageName' => $pengguna->foto]);
    }

    public function update_akun(Request $request){
        $request->validate([ 
            'new_password' => 'required|min:8',
            'password_confirmation' => 'required|same:new_password',
        ], [
            'new_password.required' => 'Password baru wajib diisi',
            'password_confirmation.required' => 'Password konfirmasi wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'password_confirmation.min' => 'Password konfirmasi minimal 8 karakter',
            'password_confirmation.same' => 'Password konfirmasi tidak sama dengan password baru',
        ]);

        $user = Auth::user();
        $newPassword = Hash::make($request->new_password);
        
        DB::table('pengguna')
        ->where('id', $user->id)
        ->update(['password' => $newPassword]);

        return redirect()->route('editAkun')->with('success', 'Password telah berhasil diperbarui');
    }
    
}
