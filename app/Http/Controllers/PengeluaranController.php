<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\Keluarga;
use App\Models\Pemasukan;
use App\Models\Pengajuan;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Expr\New_;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pengeluaran_semua = Pengeluaran::all();
        // cek data pasangan suami istri
        $id = User::find(Auth::user()->id); // data user di table user
        $data_keluarga = Keluarga::find($id->keluarga_id); //data user di data keluarga
        $id_user_hubungan = $data_keluarga->keluarga->user_id;
        if ($data_keluarga->hubungan == "Istri" || $data_keluarga->hubungan == "Suami") {
            $data_pengeluaran_pinjaman = Pengeluaran::where('anggaran_id', 3)->where('anggota_id', $id_user_hubungan)->get();
            $cek_pengeluaran_pinjaman_user = Pengeluaran::where('anggaran_id', 3)->where('anggota_id', $id_user_hubungan)->where('status', 'Nunggak')->count();
        } else {
            $data_pengeluaran_pinjaman = Pengeluaran::where('anggaran_id', 3)->where('anggota_id', Auth::user()->id)->get();
            $cek_pengeluaran_pinjaman_user = Pengeluaran::where('anggaran_id', 3)->where('anggota_id', Auth::id())->where('status', 'Nunggak')->count();
        }
        // sampe die
        $program = Anggaran::Find(3);
        $cek_pengajuan = Pengajuan::orderByRaw('created_at DESC')->where('kategori', 'Pinjaman')->where('anggota_id', Auth::id())->count();
        $cek_pengajuan_proses = Pengajuan::where('anggota_id', Auth::id())->get();
        $cek_pengeluaran_pinjaman = Pengeluaran::where('anggaran_id', 3)->where('status', 'Nunggak')->count();

        // Data Anggaran
        $data_anggaran = Anggaran::all();
        $data_anggaran_max_pinjaman = Anggaran::find(3);
        // cek data jumlah pemasukan
        $cek_semua_pemasukan = Pemasukan::where('kategori', 'Kas')->sum('jumlah');
        $cek_pemasukan_2 = $cek_semua_pemasukan / 2; // Membagi jumlah semua pemasukan
        $tahap_1 = $cek_pemasukan_2 * 90 / 100; // Menghitung Jumlah anggaran pinjaman dari hasil pembagian 2,
        $cek_total_pinjaman = $tahap_1 / 2; // Menghitung total Anggaran
        $jatah = $cek_total_pinjaman * $data_anggaran_max_pinjaman->persen / 100; //Jath Persenan di ambil dari data anggaran
        // Data Dana Darurat
        $dana_darurat = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 1)->get();
        $dana_amal = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 2)->get();
        $dana_pinjam = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 3)->get();
        $dana_usaha = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 4)->get();
        $dana_acara = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 5)->get();
        $dana_lain = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 6)->get();

        $keluarga = Keluarga::all();

        return view('pengeluaran.index', compact('keluarga', 'data_pengeluaran_semua', 'data_pengeluaran_pinjaman', 'program', 'cek_pengajuan', 'cek_pengajuan_proses', 'cek_pengeluaran_pinjaman_user', 'cek_pengeluaran_pinjaman', 'cek_total_pinjaman', 'jatah', 'data_anggaran', 'data_anggaran_max_pinjaman', 'dana_darurat', 'dana_amal', 'dana_pinjam', 'dana_usaha', 'dana_acara', 'dana_lain'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_pengeluaran_semua = Pengeluaran::all();
        $data_pengeluaran_pinjaman = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 3)->where('anggota_id', Auth::user()->id)->get();
        $program = Anggaran::Find(3);
        $cek_pengajuan = Pengajuan::where('kategori', 'Pinjaman')->where('anggota_id', Auth::id())->count();
        $cek_pengajuan_proses = Pengajuan::where('anggota_id', Auth::id())->get();
        $cek_pengeluaran_pinjaman_user = Pengeluaran::where('anggaran_id', 3)->where('anggota_id', Auth::id())->where('status', 'Nunggak')->count();
        $cek_pengeluaran_pinjaman = Pengeluaran::where('anggaran_id', 3)->where('status', 'Nunggak')->count();

        // Data Anggaran
        $data_anggaran = Anggaran::all();
        $data_anggaran_max_pinjaman = Anggaran::find(3);
        // cek data jumlah pemasukan
        $cek_semua_pemasukan = Pemasukan::where('kategori', 'Kas')->sum('jumlah');
        $cek_pemasukan_2 = $cek_semua_pemasukan / 2; // Membagi jumlah semua pemasukan
        $tahap_1 = $cek_pemasukan_2 * 90 / 100; // Menghitung Jumlah anggaran pinjaman dari hasil pembagian 2,
        $cek_total_pinjaman = $tahap_1 / 2; // Menghitung total Anggaran
        $jatah = $cek_total_pinjaman * $data_anggaran_max_pinjaman->persen / 100; //Jath Persenan di ambil dari data anggaran
        // Data Dana Darurat
        $dana_darurat = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 1)->get();
        $dana_amal = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 2)->get();
        $dana_pinjam = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 3)->get();
        $dana_usaha = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 4)->get();
        $dana_acara = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 5)->get();
        $dana_lain = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 6)->get();

        return view('pengeluaran.form_input_pengeluaran', compact('data_pengeluaran_semua', 'data_pengeluaran_pinjaman', 'program', 'cek_pengajuan', 'cek_pengajuan_proses', 'cek_pengeluaran_pinjaman_user', 'cek_pengeluaran_pinjaman', 'cek_total_pinjaman', 'jatah', 'data_anggaran', 'data_anggaran_max_pinjaman', 'dana_darurat', 'dana_amal', 'dana_pinjam', 'dana_usaha', 'dana_acara', 'dana_lain'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'anggaran_id' => 'required',
                'jumlah' => 'required|numeric',
                'keterangan' => 'required',
            ],
            [
                'anggaran_id.required' => 'anggaran kedah di pilih',
                'jumlah.required' => 'Nominal kedah di isi',
                'jumlah.numeric' => 'Nominal teu kengeng kangge titik',
                'keterangan.required' => 'keterangan kedah di isi',
            ]
        );

        $data_pengeluaran = new Pengeluaran();
        $data_pengeluaran->jumlah = $request->jumlah;
        $data_pengeluaran->anggaran_id = $request->anggaran_id;
        $data_pengeluaran->anggota_id = Auth::user()->id;
        $data_pengeluaran->keluarga_id = Auth::user()->id;
        $data_pengeluaran->pengurus_id = Auth::user()->id;
        $data_pengeluaran->alasan = $request->keterangan;
        $data_pengeluaran->tanggal = Carbon::now();

        // Kanggo send notifikasi
        $all = User::all();
        $anggaran = Anggaran::find($request->anggaran_id);

        $project = [
            'greeting' => 'Bissmillah',
            'body' => 'Nglaporkeun Pengeluaran KAS seseuai DATA di Handap anu di Input ku ' . Auth::user()->name . ' Mangga cek deui, kedah selalu ngecek kana data',
            'nama' => 'Di Input ku ' . Auth::user()->name,
            'kategori' => $anggaran->nama_anggaran,
            'pembayaran' => 'Jumlah Nu di Kaluarkeun',
            'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
            'tanggal' => Carbon::now(),
            'thanks' => 'Laporan sesuai data nu tercantum, Hatur nuhun kana perhatosanna',
            'actionText' => 'cek kanggo ningal secara detail',
            'actionURL' => url('/'),
            'id' => 57
        ];

        Notification::sendnow($all, new EmailNotification($project));
        $data_pengeluaran->save();

        return redirect()->back()->with('sukses', 'Dana Anggaran anu di input atos masuk data, mangga manpaatkeun anggaranna ');
    }
    public function tarik_tabungan(Request $request)
    {
        $request->validate(
            [
                'anggaran_id' => 'required',
                'jumlah' => 'required|numeric',
                'keterangan' => 'required',
            ],
            [
                'anggaran_id.required' => 'anggaran kedah di pilih',
                'jumlah.required' => 'Nominal kedah di isi',
                'jumlah.numeric' => 'Nominal teu kengeng kangge titik',
                'keterangan.required' => 'keterangan kedah di isi',
            ]
        );

        $data_pengeluaran = new Pengeluaran();
        $data_pengeluaran->jumlah = $request->jumlah;
        $data_pengeluaran->anggaran_id = $request->anggaran_id;
        $data_pengeluaran->anggota_id = $request->anggota_id;
        $data_pengeluaran->alasan = $request->keterangan;
        $data_pengeluaran->status = $request->status;
        $data_pengeluaran->tanggal = Carbon::now();

        // Kanggo send notifikasi
        $user = User::find($request->anggota_id);
        $anggaran = Anggaran::find($request->anggaran_id);

        $project = [
            'greeting' => 'Bissmillah',
            'body' => 'Penarikan Tabungan Atos di setujui sareng atos di pasihkeun ku ' . Auth::user()->name . ' Mangga cek deui, kedah selalu ngecek kana data',
            'nama' => 'Di Input ku ' . Auth::user()->name,
            'kategori' => $anggaran->nama_anggaran,
            'pembayaran' => $request->pembayaran,
            'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
            'tanggal' => Carbon::now(),
            'thanks' => 'Laporan sesuai data nu tercantum, Hatur nuhun kana perhatosanna',
            'actionText' => 'cek kanggo ningal secara detail',
            'actionURL' => url('/'),
            'id' => 57
        ];

        Notification::sendnow($user, new EmailNotification($project));
        $data_pengeluaran->save();

        $pengajuan = Pengajuan::find($request->pengajuan_id);
        $pengajuan->delete();

        return redirect('/pengajuans/kas')->with('sukses', 'Tarik Pinjaman Atos di setujui, mangga manpaatkeun uang na ');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store_pinjaman(Request $request)
    {
        $request->validate(
            [
                'anggaran_id' => 'required',
                'jumlah' => 'required|numeric',
                'keterangan' => 'required',
            ],
            [
                'anggaran_id.required' => 'anggaran kedah di pilih',
                'jumlah.required' => 'Nominal kedah di isi',
                'jumlah.numeric' => 'Nominal teu kengeng kangge titik',
                'keterangan.required' => 'keterangan kedah di isi',
            ]
        );

        $data_pengeluaran = new Pengeluaran();
        $data_pengeluaran->jumlah = $request->jumlah;
        $data_pengeluaran->anggaran_id = $request->anggaran_id;
        $data_pengeluaran->alasan = $request->keterangan;
        $data_pengeluaran->tanggal = Carbon::now();
        $data_pengeluaran->save();

        return redirect()->back()->with('sukses', 'Dana Anggaran anu di input atos masuk data, mangga manpaatkeun anggaranna ');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengeluaran = Pengeluaran::find($id);

        return view('pengeluaran.show', compact('data_pengeluaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengeluaran = Pengeluaran::find($id);
        $data_anggaran = Anggaran::all();


        return view('pengeluaran.edit', compact('data_pengeluaran', 'data_anggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate(
            [
                'anggaran_id' => 'required',
                'jumlah' => 'required|numeric',
                'keterangan' => 'required',
            ],
            [
                'anggaran_id.required' => 'anggaran kedah di pilih',
                'jumlah.required' => 'Nominal kedah di isi',
                'jumlah.numeric' => 'Nominal teu kengeng kangge titik',
                'keterangan.required' => 'keterangan kedah di isi',

            ]
        );
        $data_pengeluaran = Pengeluaran::find($id);
        $data_pengeluaran->jumlah = $request->jumlah;
        $data_pengeluaran->anggaran_id = $request->anggaran_id;
        $data_pengeluaran->alasan = $request->keterangan;

        $data_pengeluaran->update();

        return redirect()->back()->with('infoes', 'Data pengeluaran atos di rubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengeluaran = Pengeluaran::find($id);

        $data_pengeluaran->delete();

        return redirect()->back()->with('kuning', 'Data Parantos di hapus tina disimpen dina sampah )');
    }
    public function trash()
    {
        $data_pengeluaran = Pengeluaran::orderByRaw('created_at DESC')->onlyTrashed()->get();

        return view('pengeluaran.trash', compact('data_pengeluaran'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengeluaran = Pengeluaran::withTrashed()->findorfail($id);
        $data_pengeluaran->restore();
        return redirect()->back()->with('infoes', 'Data pengeluaran atos di kembalikeun deui tina sampah');
    }

    public function kill($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengeluaran = Pengeluaran::withTrashed()->findorfail($id);

        $data_pengeluaran->forceDelete();
        return redirect()->back()->with('kuning', 'Data pengeluaran parantos di hapus dina sampah');
    }
    public function table_pengeluaran_detail($id)
    {
        $id = Crypt::decrypt($id);
        if ($id == 6) {
            $data_pengeluaran = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', 6)->get();
        } else {
            $data_pengeluaran = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', $id)->get();
        }

        return view('pengeluaran.show_pengeluaran_peranggaran', compact('data_pengeluaran'));
    }
    public function table_pengeluaran_detail_pinjaman($id)
    {
        $id = Crypt::decrypt($id);

        $data_pengeluaran = Pengeluaran::orderByRaw('created_at DESC')->where('anggaran_id', $id)->get();


        return view('pengeluaran.show_pengeluaran_peranggaran_pinjaman', compact('data_pengeluaran'));
    }

    public function data_pengeluaran_admin()
    {

        // data Pemasukan
        $data_pemasukan = Pemasukan::all();
        $total_pemasukan_kas = Pemasukan::where('kategori', 'Kas')->sum('jumlah'); //Menghitung semua pemasukan kas
        $kas_dibagi2 = $total_pemasukan_kas / 2;
        $kas_pembagian = $kas_dibagi2 * 90 / 100;
        $total_dana_amal = $kas_dibagi2 * 10 / 100; //mengambil jumlah dana kas AMAL sebesar 10/100
        $total_dana_darurat = $kas_pembagian / 2; //mengambil jumlah dana darurat
        $total_dana_pinjam = $kas_pembagian / 2; //mengambil jumlah dana darurat
        $total_dana_kas = $kas_dibagi2; //mengambil jumlah dana darurat

        // data pengeluaran
        $data_pengeluaran = Pengeluaran::orderByRaw('created_at DESC')->get();
        $total_pengeluaran_kas = Pengeluaran::all()->sum('jumlah');
        $total_pengeluaran_darurat = Pengeluaran::where('anggaran_id', 1)->sum('jumlah');
        $total_pengeluaran_amal = Pengeluaran::where('anggaran_id', 2)->sum('jumlah');
        $total_pengeluaran_pinjaman = Pengeluaran::where('anggaran_id', 3)->sum('jumlah');
        $total_pengeluaran_usaha = Pengeluaran::where('anggaran_id', 4)->sum('jumlah');
        $total_pengeluaran_acara = Pengeluaran::where('anggaran_id', 6)->sum('jumlah');
        $total_pengeluaran_lain = Pengeluaran::where('anggaran_id', 6)->sum('jumlah');

        // Perhitungan uang yang masuk lewat Transfer
        $total_pembayaran_tf = Pemasukan::where('pembayaran', 'Transfer')->sum('jumlah');
        // Perhitungan uang yang masuk lewat cash
        $total_pembayaran_cash = Pemasukan::where('pembayaran', 'Cash')->sum('jumlah');
        // menghitung jumlah setor tunai
        $total_setor_tunai = Pemasukan::where('kategori', 'Setor_tunai')->sum('jumlah');

        // Perhitungan saldo kas
        $saldo_kas = $total_pemasukan_kas - $total_pengeluaran_kas;

        // Perhitungan Tabungan
        $total_tabungan = Pemasukan::where('kategori', 'Tabungan')->sum('jumlah');
        // Perhitungan nimonal di bank termasuk jumlah tabungan
        $saldo_bank = $total_pembayaran_tf - $total_pengeluaran_kas;
        // Uang nu teu acan di transfer
        $uang_blum_diTF = $total_pembayaran_cash - $total_setor_tunai;

        return view('admin.master_data.pengeluaran.index', compact(
            'data_pengeluaran',
            'total_pemasukan_kas',
            'total_pengeluaran_kas',
            'total_dana_amal',
            'total_dana_darurat',
            'total_dana_pinjam',
            'total_dana_kas',
            'total_pengeluaran_darurat',
            'total_pengeluaran_amal',
            'total_pengeluaran_pinjaman',
            'total_pengeluaran_usaha',
            'total_pengeluaran_acara',
            'total_pengeluaran_lain',
            'total_tabungan',
            'saldo_kas',
            'saldo_bank',
            'uang_blum_diTF',
        ));
    }
}
