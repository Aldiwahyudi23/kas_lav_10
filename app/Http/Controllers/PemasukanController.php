<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Http\Controllers\Controller;
use App\Models\BayarPinjaman;
use App\Models\Keluarga;
use App\Models\Pengajuan;
use App\Models\Pengeluaran;
use App\Models\Program;
use App\Models\User;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pemasukan_semua = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'KAS')->get();
        $data_pemasukan_setor_tunai = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Setor_Tunai')->get();

        $id = User::find(Auth::user()->id); // data user di table user
        $data_keluarga = Keluarga::find($id->keluarga_id); //data user di data keluarga
        $id_user_hubungan = $data_keluarga->keluarga->user_id;
        if ($data_keluarga->hubungan == "Istri" || $data_keluarga->hubungan == "Suami") {
            $data_pemasukan_kas_user = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Kas')->where('anggota_id', $id_user_hubungan)->orderBy('anggota_id')->get();
        } else {
            $data_pemasukan_kas_user = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Kas')->where('anggota_id', Auth::user()->id)->orderBy('anggota_id')->get();
        }
        $data_pemasukan_tabungan_user = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Tabungan')->where('anggota_id', Auth::user()->id)->orderBy('anggota_id')->get();
        $program = Program::Find(1);
        // cek pengajuan
        $id = User::find(Auth::user()->id); // mengambil data user yang login
        $data_keluarga = Keluarga::find($id->keluarga_id); //mengambil data dari data keluarga sesuai dengan id dari yang login
        $id_user_hubungan = Keluarga::find($data_keluarga->keluarga_id); //mengambil id dari hubungan si penglogin

        if (
            $data_keluarga->hubungan == "Istri" || $data_keluarga->hubungan == "Suami"
        ) {
            $cek_pengajuan = Pengajuan::where('kategori', 'Kas')->where('anggota_id', $id_user_hubungan->user_id)->count();
            $cek_pemasukan_terakhir = Pemasukan::orderByRaw('created_at DESC LIMIT 1')->where('kategori', 'KAS')->where('anggota_id', $id_user_hubungan->user_id)->get();
            $cek_pemasukan_terakhir_total = Pemasukan::orderByRaw('created_at DESC LIMIT 1')->where('kategori', 'KAS')->where('anggota_id', $id_user_hubungan->user_id)->count();
        } else {
            $cek_pengajuan = Pengajuan::where('kategori', 'Kas')->where('anggota_id', Auth::id())->count();
            $cek_pemasukan_terakhir = Pemasukan::orderByRaw('created_at DESC LIMIT 1')->where('kategori', 'KAS')->where('anggota_id', Auth::user()->id)->get();
            $cek_pemasukan_terakhir_total = Pemasukan::orderByRaw('created_at DESC LIMIT 1')->where('kategori', 'KAS')->where('anggota_id', Auth::user()->id)->count();
        }




        $data_anggota = User::all();
        $data1 = Carbon::now();

        $id = User::find(Auth::user()->id); // data user di table user
        $data_keluarga = Keluarga::find($id->keluarga_id); //data user di data keluarga

        return view('pemasukan.index', compact('data_pemasukan_semua', 'data_pemasukan_kas_user', 'data_pemasukan_tabungan_user',  'program', 'cek_pengajuan', 'data_anggota', 'data_pemasukan_setor_tunai', 'data1', 'data_keluarga', 'cek_pemasukan_terakhir'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //Buat form setor tunai
    {
        $total_pembayaran_cash = Pemasukan::where('pembayaran', 'Cash')->sum('jumlah');
        // menghitung jumlah setor tunai
        $total_setor_tunai = Pemasukan::where('kategori', 'Setor_tunai')->sum('jumlah');
        // Uang nu teu acan di transfer
        $total_bayar_pinjaman_cash = BayarPinjaman::where('pembayaran', 'Cash')->sum('jumlah');
        $uang_blum_diTF = $total_pembayaran_cash - $total_setor_tunai + $total_bayar_pinjaman_cash;

        $data_pemasukan_semua = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'KAS')->get();
        $data_pemasukan_setor_tunai = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Setor_Tunai')->get();

        $data_pemasukan_kas_user = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Kas')->where('anggota_id', Auth::user()->id)->orderBy('anggota_id')->get();

        $data_pemasukan_tabungan_user = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Tabungan')->where('anggota_id', Auth::user()->id)->orderBy('anggota_id')->get();
        $program = Program::Find(1);
        $cek_pengajuan = Pengajuan::where('kategori', 'Kas')->where('anggota_id', Auth::id())->count();
        $data_anggota = User::all();
        $data1 = Carbon::now();

        return view('pemasukan.form_setor_tunai', compact('uang_blum_diTF', 'data_pemasukan_semua', 'data_pemasukan_kas_user', 'data_pemasukan_tabungan_user',  'program', 'cek_pengajuan', 'data_anggota', 'data_pemasukan_setor_tunai', 'data1'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'kategori' => 'required',
            'pembayaran' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required',
        ], [
            'anggota_id.required' => 'Anggota kedah di pilih',
            'kategori.required' => 'Kategori kedah di pilih',
            'pembayaran.required' => 'Pembayaran kedah di pilih',
            'jumlah.required' => 'Nominal kedah di isi',
            'jumlah.numeric' => 'Nominal teu kengeng kangge titik',
            'keterangan.required' => 'keterangan kedah di isi',
        ]);

        if ($request->foto) {
            $file = $request->file('foto');
            $nama = 'bukti-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/bukti'), $nama);
        }

        $data_pemasukan = new Pemasukan();
        $data_pemasukan->anggota_id = $request->anggota_id;
        $data_pemasukan->pengaju_id = $request->pengaju_id;
        $data_pemasukan->jumlah = $request->jumlah;
        $data_pemasukan->pembayaran = $request->pembayaran;
        $data_pemasukan->kategori = $request->kategori;
        $data_pemasukan->keterangan = $request->keterangan;
        $data_pemasukan->tanggal = $request->tanggal;
        $data_pemasukan->pengurus_id = Auth::user()->id;

        if ($request->foto) {
            $data_pemasukan->foto          = "/img/bukti/$nama";
        }
        if ($request->foto1) {
            $data_pemasukan->foto          = $request->foto1;
        }

        // Kanggo send notifikasi
        $ketua = User::where('role', 'Ketua')->get();
        $seker = User::where('role', 'Admin')->get();
        $penasehat = User::where('role', 'Penasehat')->get();
        $user = User::find(Auth::user()->id);
        $nama_pengaju = User::find($request->anggota_id);

        $project = [
            'greeting' => 'Alhamdullilah',
            'body' => 'Pengajuan Atos di Konfirmasi ku ' . $user->name . ' Sesuai data nu di handap, Mangga cek deui nya bilih aya nu lepat',
            'nama' => $nama_pengaju->name,
            'kategori' => $request->kategori,
            'pembayaran' => $request->pembayaran,
            'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
            'tanggal' => $request->tanggal,
            'thanks' => 'Hatur Nuhun Pisan Atos Berpartisipasi kana PROGRAM ieu',
            'actionText' => 'Tinggal',
            'actionURL' => url('/'),
            'id' => 57
        ];
        $pengurus = [
            'greeting' => 'HI DULLURRR',
            'body' => 'Aya Data Nu Masuk Atos di Konfirmasi ku ' . $user->name . ' Sesuai data nu di handap, Mangga cek deui nya bilih aya nu lepat',
            'nama' => $nama_pengaju->name,
            'kategori' => $request->kategori,
            'pembayaran' => $request->pembayaran,
            'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
            'tanggal' => $request->tanggal,
            'thanks' => 'Bismillah Semoga lancar jaya ahhhh... gas',
            'actionText' => 'Cek di web',
            'actionURL' => url('/'),
            'id' => 57
        ];

        Notification::sendnow($nama_pengaju, new EmailNotification($project));
        Notification::sendnow($seker, new EmailNotification($pengurus));
        Notification::sendnow($ketua, new EmailNotification($pengurus));
        $data_pemasukan->save();

        // jika ada pengajuan ID hapus
        if ($request->pengajuan_id) {
            $pengajuan = Pengajuan::find($request->pengajuan_id);
            $pengajuan->delete();


            return redirect('/pengajuans/kas')->with('sukses', 'Wihhhh mantappp hatur nuhun atos ngaKONFIRMASI pengajuan pemabyaran KAS keluarga. Lancar selalu');
        } else {
            return redirect()->back()->with('sukses', 'Wihhhh mantappp hatur nuhun atos masukeun data pembayaran KAS keluarga. Lancar selalu ATOS LEBET');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $data_pemasukan = Pemasukan::Find($id);
        return view('pemasukan.show', compact('data_pemasukan'));
    }
    /**
     * Display the specified resource.
     */
    public function detail_anggota_kas($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        $data_pemasukan_kas_user = Pemasukan::where('kategori', 'Kas')->where('anggota_id', $id)->orderBy('anggota_id')->get();
        return view('pemasukan.show_anggota', compact('data_pemasukan_kas_user', 'user'));
    }
    public function detail_anggota_tabungan($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        $data_pemasukan_kas_user = Pemasukan::where('kategori', 'Tabungan')->where('anggota_id', $id)->orderBy('anggota_id')->get();
        return view('pemasukan.show_anggota', compact('data_pemasukan_kas_user', 'user'));
    }

    public function tambah_anggota_tabungan($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        $data_pemasukan_kas_user = Pemasukan::where('kategori', 'Tabungan')->where('anggota_id', $id)->orderBy('anggota_id')->get();
        return view('pemasukan.tabungan.index', compact('data_pemasukan_kas_user', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $data_pemasukan = Pemasukan::Find($id);
        $data_anggota = User::all();
        return view('pemasukan.edit', compact('data_pemasukan', 'data_anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate(
            [
                'jumlah' => 'required',
                'anggota_id' => 'required',
                'keterangan' => 'required',
                'pembayaran' => 'required',
            ],
            [
                'jumlah.required' => 'Nominal kedah di isi',
                'anggota_id.required' => 'anggota_id kedah di isi',
                'keterangan.required' => 'keterangan kedah di isi',
                'pembayaran.required' => 'keterangan kedah di isi',
            ]
        );
        if ($request->foto) {
            $file = $request->file('foto');
            $nama = 'bukti-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/bukti'), $nama);
        }

        $data_pemasukan = Pemasukan::Find($id);

        $data_pemasukan->anggota_id = $request->anggota_id;
        $data_pemasukan->jumlah = $request->jumlah;
        $data_pemasukan->pembayaran = $request->pembayaran;
        $data_pemasukan->kategori = $request->kategori;
        $data_pemasukan->keterangan = $request->keterangan;
        if ($request->foto) {
            $data_pemasukan->foto = "/img/bukti/$nama";
        }
        $data_pemasukan->update();

        return redirect()->back()->with('infoes', 'Wihhhh mantappp data atos di gentos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $data_pemasukan = Pemasukan::find($id);

        $data_pemasukan->delete();

        return redirect()->back()->with('kuning', 'Data Parantos di hapus tina disimpen dina sampah )');
    }
    public function trash()
    {
        $data_pemasukan = Pemasukan::onlyTrashed()->get();

        return view('pemasukan.trash', compact('data_pemasukan'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $data_pemasukan = Pemasukan::withTrashed()->findorfail($id);
        $data_pemasukan->restore();
        return redirect()->back()->with('infoes', 'Data pemasukan atos di kembalikeun deui tina sampah');
    }

    public function kill($id)
    {
        $id = Crypt::decrypt($id);
        $data_pemasukan = Pemasukan::withTrashed()->findorfail($id);

        $data_pemasukan->forceDelete();
        return redirect()->back()->with('kuning', 'Data pemasukan parantos di hapus dina sampah');
    }
    public function data_pemasukan_all()
    {
        $data_pemasukan = Pemasukan::orderByRaw('created_at DESC')->where('kategori', 'Kas')->get();
        $total_pemasukan = Pemasukan::where('kategori', 'Kas')->sum('jumlah');
        $total_pinjaman = Pengeluaran::where('anggaran_id', 3)->sum('jumlah');
        $total_pengeluaran_semua = Pengeluaran::all()->sum('jumlah');
        $total_pengeluaran = $total_pengeluaran_semua - $total_pinjaman;

        return view('pemasukan.show_pemasukan_kas_all', compact('data_pemasukan', 'total_pemasukan', 'total_pengeluaran'));
    }

    public function data_pemasukan_admin()
    {
        $data_pemasukan = Pemasukan::orderByRaw('created_at DESC')->get();
        $total_pemasukan = Pemasukan::where('kategori', 'Kas')->sum('jumlah');
        $total_pinjaman = Pengeluaran::where('anggaran_id', 3)->sum('jumlah');
        $total_pengeluaran_semua = Pengeluaran::all()->sum('jumlah');
        $total_pengeluaran = $total_pengeluaran_semua - $total_pinjaman;

        return view('admin.master_data.pemasukan.index', compact('data_pemasukan', 'total_pemasukan', 'total_pengeluaran'));
    }
}
