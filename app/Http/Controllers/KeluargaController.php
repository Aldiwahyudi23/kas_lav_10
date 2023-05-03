<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Foto;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Faker\Core\DateTime as CoreDateTime;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_keluarga_tugu = Keluarga::where('tugu', 'ya')->get();
        $data_keluarga = Keluarga::all();

        return view('admin.master_data.data_keluarga.index', compact('data_keluarga_tugu', 'data_keluarga'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tambah(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $data_anggota = Keluarga::find($id);
        $data_keluarga = Keluarga::all();

        return view('admin.master_data.data_keluarga.tambah', compact('data_keluarga', 'data_anggota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'nama'     => 'required|unique:keluargas',
                'jk'  => 'required',
                'tmp_lahir'  => 'required',
                'tgl_lahir'  => 'required',
                'alamat'  => 'required',
                'no_hp'  => 'max:13',
                'nama_hubungan'  => 'required',
                'hubungan'  => 'required',
                'pekerjaan'  => 'required',
            ],
            [
                'nama.required'        => "Nama teu kengeng kosong.",
                'nama.unique'        => "Nama ieu atos aya di data (kasih ini sial di pengker nami.",
                'jk.required'        => "teu kengeng kosong.",
                'tmp_lahir.required'        => "Tempat lahir teu kengeng kosong.",
                'tgl_lahir.required'        => "Tanggal lahir teu kengeng kosong.",
                'alamat.required'        => "alamat teu kengeng kosong.",
                'no_hp.required'        => "no hp teu kengeng kosong.",
                'no_hp.unique'        => "no hp atos terdaftar.",
                'no_hp.max'        => "Max jumlah angka 13.",
                'nama_hubungan.required'        => "nama teu kengeng kosong.",
                'hubungan.required'        => "hubungan teu kengeng kosong.",
                'pekerjaan.required'        => "pekerjaan teu kengeng kosong.",
                'nik.required'        => "nik teu kengeng kosong.",
                'nik.unique'        => "nik atos terdaftar.",
                'nik.min'        => "jumlah angka NIK kedah 15.",
                'nik.max'        => "jumlah angka NIK kedah di bawah 17.",

            ]
        );
        if ($request->foto) {
            $file = $request->file('foto');
            $nama = 'anggota-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/profile'), $nama);
            $fotoo = "/img/profile/$nama";
        } else {
            if ($request->jk == 'Laki-Laki') {
                $fotoo = 'img/keluarga/52471919042020_male.jpg';
            } else {
                $fotoo = 'img/keluarga/52471919042020_female.jpg';
            }
        }

        if ($request->anak_ke) {
            $no_induk = 50000 . $request->nama_hubungan . $request->anak_ke;
        } else {
            if ($request->hubungan == "Suami") {
                $no_induk = 50000 .  $request->nama_hubungan . 0;
            }
            if ($request->hubungan == "Istri") {
                $no_induk = 50000 . $request->nama_hubungan . 00;
            }
        }

        $data = new Keluarga;
        $data->nama      = $request->nama;
        $data->jenis_kelamin      = $request->jk;
        $data->tempat_lahir      = $request->tmp_lahir;
        $data->tanggal_lahir      = $request->tgl_lahir;
        $data->alamat      = $request->alamat;
        $data->no_hp      = $request->no_hp;
        $data->nik      = $no_induk;
        $data->keluarga_id      = $request->nama_hubungan;
        $data->hubungan      = $request->hubungan;
        $data->pekerjaan      = $request->pekerjaan;
        $data->anak_ke      = $request->anak_ke;
        $data->foto      = $fotoo;

        $data->save();

        return redirect()->back()->with('sukses', 'Data Anggota Keluarga Parantos ka simpen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $data_keluarga = Keluarga::findorFail($id);

        return view('admin.master_data.data_keluarga.show', compact('data_keluarga'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data_anggota = Keluarga::find($id);

        $data_keluarga_hubungan = Keluarga::where('keluarga_id', $id)->get();

        $foto = Foto::where('keluarga_id', $data_anggota->id)->get();
        $data_keluarga = Keluarga::all();

        return view('admin.master_data.data_keluarga.detail', compact('data_keluarga', 'data_anggota', 'data_keluarga_hubungan', 'foto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data_keluargas = Keluarga::all();
        $data_keluarga = Keluarga::findorfail($id);

        return view('admin.master_data.data_keluarga.edit', compact('data_keluarga', 'data_keluargas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $request->validate(
            [
                'nama'     => 'required',
                'jk'  => 'required',
                'tmp_lahir'  => 'required',
                'tgl_lahir'  => 'required',
                'alamat'  => 'required',
                'no_hp'  => 'max:13',
                'nama_hubungan'  => 'required',
                'hubungan'  => 'required',
                'pekerjaan'  => 'required',
            ],
            [
                'nama.required'        => "Nama teu kengeng kosong.",
                'nama.unique'        => "Nama ieu atos aya di data (kasih ini sial di pengker nami.",
                'jk.required'        => "teu kengeng kosong.",
                'tmp_lahir.required'        => "Tempat lahir teu kengeng kosong.",
                'tgl_lahir.required'        => "Tanggal lahir teu kengeng kosong.",
                'alamat.required'        => "alamat teu kengeng kosong.",
                'no_hp.required'        => "no hp teu kengeng kosong.",
                'no_hp.unique'        => "no hp atos terdaftar.",
                'no_hp.max'        => "Max jumlah angka 13.",
                'nama_hubungan.required'        => "nama teu kengeng kosong.",
                'hubungan.required'        => "hubungan teu kengeng kosong.",
                'pekerjaan.required'        => "pekerjaan teu kengeng kosong.",
                'nik.required'        => "nik teu kengeng kosong.",
                'nik.unique'        => "nik atos terdaftar.",
                'nik.min'        => "jumlah angka NIK kedah 15.",
                'nik.max'        => "jumlah angka NIK kedah di bawah 17.",

            ]
        );
        if ($request->foto) {
            $file = $request->file('foto');
            $nama = 'anggota-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/profile'), $nama);
        } else {
        }

        $namhub = Keluarga::find($request->nama_hubungan);

        if ($request->anak_ke) {
            $no_induk = 50000 . $namhub->anak_ke . $request->anak_ke;
        } else {
            if ($request->hubungan == "Suami") {
                $no_induk = 50000 .  $namhub->anak_ke . 0;
            }
            if ($request->hubungan == "Istri") {
                $no_induk = 50000 . $namhub->anak_ke . 00;
            }
        }
        $data = Keluarga::find($id);
        $data->nama      = $request->nama;
        $data->jenis_kelamin      = $request->jk;
        $data->tempat_lahir      = $request->tmp_lahir;
        $data->tanggal_lahir      = $request->tgl_lahir;
        $data->alamat      = $request->alamat;
        $data->no_hp      = $request->no_hp;
        $data->nik      = $no_induk;
        $data->pekerjaan      = $request->pekerjaan;
        $data->keluarga_id      = $request->nama_hubungan;
        $data->hubungan      = $request->hubungan;
        $data->anak_ke      = $request->anak_ke;
        if ($request->foto) {
            $data->foto      = "/img/profile/$nama";
        } else {
        }
        $data->update();

        if ($data->user_id == true) {
            $data_user = User::find($data->user_id);
            $data_user->foto = "/img/profile/$nama";
            $data_user->update();
        } else {
            $data_user = User::find(1);
        }

        $foto = new Foto;
        $foto->keluarga_id = $data->id;
        $foto->user_id = $data_user->id;
        $foto->foto  = $data->foto;
        $foto->save();

        if (Auth::user()->role == 'Admin') {
            return redirect()->back()->with('infoes', 'Data Anggota Keluarga Parantos di edit');
        } else {
            return redirect()->back()->with('infoes', 'Selamat Ayeuna profilena atos di robah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $data_keluarga = Keluarga::find($id);
        $anggota = Anggota::find($id);
        $hitung_anggota = Anggota::where('keluarga_id', $data_keluarga->id)->count();
        if ($hitung_anggota >= 1) {
            $data_keluarga->delete();
            $anggota->delete();

            return redirect()->back()->with('kuning', 'Data Berhasil di hapus (silahkan cek trash data keluarga)');
        } else {
            $data_keluarga->delete();

            return redirect()->back()->with('kuning', 'Data Berhasil di hapus (silahkan cek trash data keluarga)');
        }
    }
    public function trash()
    {
        $data_keluarga = Keluarga::onlyTrashed()->get();

        return view('admin.master_data.data_keluarga.trash', compact('data_keluarga'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $data_keluarga = Keluarga::withTrashed()->findorfail($id);
        $countAnggota = Anggota::withTrashed()->where('keluarga_id', $data_keluarga->id)->count();
        if ($countAnggota >= 1) {
            $anggota = Anggota::withTrashed()->where('id', $data_keluarga->id)->first();
            $data_keluarga->restore();
            $anggota->restore();
            return redirect()->back()->with('infoes', 'Data Anggota Kleuarga berhasil direstore! (Silahkan cek data keluarga)');
        } else {
            $data_keluarga->restore();
            return redirect()->back()->with('infoes', 'Data Anggota Kleuarga berhasil direstore! (Silahkan cek data keluarga)');
        }
    }

    public function kill($id)
    {
        $id = Crypt::decrypt($id);
        $data_keluarga = Keluarga::withTrashed()->findorfail($id);
        $countAnggota = Anggota::withTrashed()->where('keluarga_id', $data_keluarga->id)->count();
        if ($countAnggota >= 1) {
            $anggota = Anggota::withTrashed()->where('id', $data_keluarga->id)->first();
            $data_keluarga->forceDelete();
            $anggota->forceDelete();
            return redirect()->back()->with('kuning', 'Data Anggota Kleuarga berhasil dihapus! (Silahkan cek data siswa)');
        } else {
            $data_keluarga->forceDelete();
            return redirect()->back()->with('kuning', 'Data Anggota Kleuarga berhasil dihapus! (Silahkan cek data siswa)');
        }
    }

    // Profile
    public function profile()
    {
        $id = User::find(Auth::user()->id);
        $data_keluarga = Keluarga::find($id->keluarga_id);
        $foto = Foto::where('user_id', Auth::user()->id)->get();

        return view('admin.master_data.data_keluarga.profile.index', compact('data_keluarga', 'foto'));
    }

    public function profile_user($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        $data_keluarga = Keluarga::find($user->keluarga_id);
        $foto = Foto::where('user_id', $id)->get();
        $data_keluargas = Keluarga::all();

        return view('admin.master_data.data_keluarga.profile.profile', compact('data_keluarga', 'data_keluargas', 'foto', 'user'));
    }

    public function profile_edit($id)
    {
        $id = Crypt::decrypt($id);
        $data_keluarga = Keluarga::find($id);
        $data_keluargas = Keluarga::all();

        return view('admin.master_data.data_keluarga.profile.edit', compact('data_keluarga', 'data_keluargas'));
    }
    public function edit_email()
    {
        return view('admin.master_data.data_keluarga.profile.email');
    }

    public function ubah_email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email'
        ]);
        $user = User::findorfail(Auth::user()->id);
        $cekUser = User::where('email', $request->email)->count();
        if ($cekUser >= 1) {
            return redirect()->back()->with('error', 'Maaf email ini sudah terdaftar!');
        } else {
            $user_email = [
                'email' => $request->email,
            ];
            $user->update($user_email);

            return redirect()->back()->with('success', 'Email anda berhasil diperbarui!');
        }
    }

    public function edit_password()
    {
        return view('admin.master_data.data_keluarga.profile.password');
    }

    public function ubah_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::findorfail(Auth::user()->id);
        if ($request->password_lama) {
            if (Hash::check($request->password_lama, $user->password)) {
                if ($request->password_lama == $request->password) {
                    return redirect()->back()->with('error', 'Maaf password yang anda masukkan sama!');
                } else {
                    $user_password = [
                        'password' => Hash::make($request->password),
                    ];
                    $user->update($user_password);
                    return redirect()->back()->with('success', 'Password anda berhasil diperbarui!');
                }
            } else {
                return redirect()->back()->with('error', 'Tolong masukkan password lama anda dengan benar!');
            }
        } else {
            return redirect()->back()->with('error', 'Tolong masukkan password lama anda terlebih dahulu!');
        }
    }

    public function keturunan($id)
    {
        $id = Crypt::decrypt($id);
        $data_anggota = Keluarga::find($id);
        $foto = Foto::where('keluarga_id', $data_anggota->id)->get();

        $data_keluarga_hubungan = Keluarga::where('keluarga_id', $id)->get();
        $data_keluarga = Keluarga::all();
        $data_keluarga_tugu = Keluarga::where('tugu', 'ya')->get();

        return view('admin.master_data.data_keluarga.keturunan.index', compact('foto', 'data_keluarga', 'data_anggota', 'data_keluarga_hubungan', 'data_keluarga_tugu'));
    }
    public function keturunan_detail(Request $request)
    {

        $cari = $request->cari;

        $data_keluarga = Keluarga::where('nama', 'like', "%" . $cari . "%")->paginate();


        return view('admin.master_data.data_keluarga.keturunan.detail', compact('data_keluarga'));
    }
}
