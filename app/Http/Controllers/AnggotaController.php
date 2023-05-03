<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Role;
use App\Models\Foto;
use App\Models\Keluarga;
use App\Models\Program;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_keluarga = Keluarga::all();
        $data_role = Role::all();
        $data_program = Program::all();
        $data_anggota = User::all();
        return view('admin.master_data.anggota.index', compact('data_keluarga', 'data_program', 'data_role', 'data_anggota'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnggotaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'no_hp'  => 'required|unique:users|max:13',
                'email'  => 'required|email|unique:users',
                'username'  => 'required',
                'password'  => 'required',
                'role_id'  => 'required',
                'anggota_kel_id'  => 'required',
            ],
            [
                'no_hp.required'        => "no hp teu kengeng kosong.",
                'no_hp.unique'        => "no hp atos terdaftar.",
                'no_hp.max'        => "Max jumlah angka 13.",
                'email.required'        => "email teu kengeng kosong.",
                'email.unique'        => "email atos terdaftar.",
                'username.required'        => "username teu kengeng kosong.",
                'username.unique'        => "username atos terdaftar.",
                'password.required'        => "password teu kengeng kosong.",
                'role_id.required'        => "role_id teu kengeng kosong.",
                'anggota_kel_id.required'        => "anggota_kel_id teu kengeng kosong.",
                'anggota_kel_id.unique'        => "anggota atos terdaftar.",

            ]
        );
        $foto = Keluarga::find($request->anggota_kel_id);

        $data = new User;
        $data->email      = $request->email;
        $data->name      = $request->username;
        $data->no_hp      = $request->no_hp;
        $data->role      = $request->role_id;
        $data->keluarga_id      = $request->anggota_kel_id;
        $data->password      = Hash::make($request->password);
        $data->is_active      = $request->is_active;
        $data->foto         = $foto->foto;

        $data->save();


        Session::flash('sukses', 'Data Anggota Keluarga Parantos ka simpen');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data_anggota = User::findorFail($id);

        return view('admin.master_data.anggota.show', compact('data_anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data_role = Role::all();
        $data_program = Program::all();
        $data_keluarga = Keluarga::all();
        $data_anggotas = User::all();
        $data_anggota = User::findorfail($id);

        return view('admin.master_data.anggota.edit', compact('data_anggota', 'data_anggotas', 'data_program', 'data_role', 'data_anggota', 'data_keluarga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnggotaRequest  $request
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Anggota $anggota)
    {
        $id = Crypt::decrypt($id);
        if ($request->foto) {
            $file = $request->file('foto');
            $nama = 'anggota-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/profile'), $nama);
        } else {
        }


        $data =  User::find($id);
        $data->email      = $request->email;
        $data->name      = $request->username;
        $data->no_hp      = $request->no_hp;
        $data->role      = $request->role_id;
        $data->keluarga_id      = $request->anggota_kel_id;
        $data->is_active      = $request->is_active;
        if ($request->password) {
            $data->password      = Hash::make($request->password);
        } else {
        }
        if ($request->foto) {
            $data->foto = "/img/profile/$nama";
        } else {
        }
        $data->update();



        $data_user = Keluarga::find($request->anggota_kel_id);
        $data_user->foto = $data->foto;
        $data_user->update();

        $foto = new Foto;
        $foto->keluarga_id = $data_user->id;
        $foto->user_id = $data->id;
        $foto->foto  = $data->foto;
        $foto->save();

        return redirect('anggota')->with('infoes', 'Data Anggota Keluarga Parantos di edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $anggota = User::find($id);

        $anggota->delete();

        return redirect()->back()->with('kuning', 'Data Berhasil di hapus (silahkan cek trash data keluarga)');
    }
    public function trash()
    {
        $data_anggota = User::onlyTrashed()->get();

        return view('admin.master_data.anggota.trash', compact('data_anggota'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $data_anggota = User::withTrashed()->findorfail($id);
        $data_anggota->restore();
        return redirect()->back()->with('infoes', 'Data Anggota berhasil direstore! (Silahkan cek data keluarga)');
    }

    public function kill($id)
    {
        $id = Crypt::decrypt($id);
        $data_anggota = User::withTrashed()->findorfail($id);

        $data_anggota->forceDelete();
        return redirect()->back()->with('kuning', 'Data Anggota berhasil dihapus! (Silahkan cek data Anggota)');
    }
    public function login_anggota(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => "Email Kedah di isi",
                'password.required' => "Kata Sandi Kedah di isi",
            ]
        );
        if (Auth::Anggota()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }
        return back()->with('danger', 'Login GAGAL !');
    }

    public function update_foto(Request $request, $id)
    {

        $id = Crypt::decrypt($id);


        $file = $request->file('foto');
        $nama = 'anggota-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/img/profile'), $nama);


        $data_anggota = Keluarga::find($id);
        $data_anggota->foto = "/img/profile/$nama";
        $data_anggota->update();

        if ($data_anggota->user_id == true) {
            $data_user = User::find($data_anggota->user_id);
            $data_user->foto = "/img/profile/$nama";
            $data_user->update();
        } else {
            $data_user = User::find(1);
        }


        $foto = new Foto;
        $foto->keluarga_id = $data_anggota->id;
        $foto->user_id = $data_user->id;
        $foto->foto  = $data_anggota->foto;
        $foto->save();


        return redirect()->back()->with('sukses', 'Foto Profile berhasil di gentos, Asikkk cakep nya ganti foto anyar.');
    }

    public function is_active(Request $Request, $id)
    {


        $data = User::find($id);
        $data->is_active = $Request->is_active;
        $data->update();

        return redirect()->back();
    }
}
