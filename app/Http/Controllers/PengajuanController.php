<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Pemberitahuan;
use App\Models\Pengeluaran;
use App\Models\User;
use App\Notifications\EmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pembayaran' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required',
        ], [
            'pembayaran.required' => 'Pembayaran kedah di pilih',
            'jumlah.required' => 'Nominal kedah di isi',
            'jumlah.numeric' => 'Nominal teu kengeng kangge titik',
            'keterangan.required' => 'keterangan kedah di isi sareng Pami tombil masih teu tiasa di klik mangga di Refresh heula browserna',
        ]);

        if ($request->foto) {
            $file = $request->file('foto');
            $nama = 'bukti-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/bukti'), $nama);
        }
        $tanggal = Carbon::now();
        $id = User::find(Auth::user()->id); // mengambil data user yang login
        $data_keluarga = Keluarga::find($id->keluarga_id); //mengambil data dari data keluarga sesuai dengan id dari yang login
        $id_user_hubungan = Keluarga::find($data_keluarga->keluarga_id); //mengambil id dari hubungan si penglogin


        $data = new Pengajuan();
        $data->pembayaran = $request->pembayaran;
        $data->jumlah = $request->jumlah;
        $data->keterangan = $request->keterangan;
        $data->kategori = $request->kategori;
        $data->tanggal = $tanggal;
        $data->status = "Proses";
        $data->pengaju_id = $request->pengaju_id;
        if ($data_keluarga->hubungan == "Istri" || $data_keluarga->hubungan == "Suami") {
            $data->anggota_id = $id_user_hubungan->user_id;
        } else {
            $data->anggota_id = $request->anggota_id;
        }
        if ($request->foto) {
            $data->foto          = "/img/bukti/$nama";
        }

        //jika pengajuan bayar pinjaman di tambahkan data sebagai berikut
        if ($request->kategori == "Bayar_Pinjaman") {
            $data->pengeluaran_id = $request->pengeluaran_id;
            $data->sekertaris = $request->sekertaris;
            $data->lama = $request->lama;
        }

        // Kanggo send notifikasi
        $bendahara = User::where('role', 'Bendahara')->get();
        $seker = User::where('role', 'Admin')->get();
        $penasehat = User::where('role', 'Penasehat')->get();
        $user = User::find(Auth::user()->id);
        $nama_pengaju = User::find($request->anggota_id);
        $nominal = 'Rp' . number_format($request->jumlah, 2, ',', '.');

        $project = [
            'greeting' => 'Sampurasun ' . $nama_pengaju->name . '',
            'body' => 'Pengajuan nuju di proses, Antosan sampe pengurus ngaKonfirmasi.',
            'nama' => $nama_pengaju->name,
            'kategori' => $request->kategori,
            'pembayaran' => $request->pembayaran,
            'jumlah' => $nominal,
            'tanggal' => $tanggal,
            'thanks' => 'Hatur Nuhun Pisan Atos Berpartisipasi kana PROGRAM ieu',
            'actionText' => 'Tinggal',
            'actionURL' => url('/'),
            'id' => 57
        ];
        $pengurus = [
            'greeting' => 'HI DULLURRR',
            'body' => 'Aya Pengajuan yeuhhhh, Mangga Konfirmasi heula, leres teu aya nu masuk atau di titipkeun.',
            'nama' => $nama_pengaju->name,
            'kategori' => $request->kategori,
            'pembayaran' => $request->pembayaran,
            'jumlah' => $nominal,
            'tanggal' => $tanggal,
            'thanks' => 'Hatur Nuhun Pisan Atos Berpartisipasi kana PROGRAM ieu',
            'actionText' => 'Cek di web',
            'actionURL' => url('/'),
            'id' => 57
        ];
        if ($request->pembayaran == "Transfer") {
            $transfer = [
                'greeting' => 'HI DULLURRR',
                'body' => 'Aya Pengajuan yeuhhhh nu Transfer, Mangga Konfirmasi heula cek di M-banking, leres teu aya nu masuk cek di mutasi trus laporkeun di GROUP WA.',
                'nama' => $nama_pengaju->name,
                'kategori' => $request->kategori,
                'pembayaran' => $request->pembayaran,
                'jumlah' => $nominal,
                'tanggal' => $tanggal,
                'thanks' => 'Hatur Nuhun Pisan Atos Berpartisipasi kana PROGRAM ieu',
                'actionText' => 'Cek di web',
                'actionURL' => url('/'),
                'id' => 57
            ];
            Notification::sendnow($penasehat, new EmailNotification($transfer));
        }

        Notification::sendnow($nama_pengaju, new EmailNotification($project));
        Notification::sendnow($seker, new EmailNotification($pengurus));
        Notification::sendnow($bendahara, new EmailNotification($pengurus));

        $data->save();

        return redirect()->back()->with('sukses', 'Horeeeeeee pengajuan pembayaran atos masuk, nuju di proses heula. Nuhun atos berpartisipasi');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $data_pengajuan = Pengajuan::Find($id);
        return view('pengajuan.show', compact('data_pengajuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $data_pengajuan = Pengajuan::find($id);
        $data_pengajuan_semua = Pengajuan::all();
        $data_anggota = User::all();
        return view('pengajuan.edit', compact('data_pengajuan', 'data_pengajuan_semua', 'data_anggota'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function laporan_pinjaman($id)
    {
        $id = Crypt::decrypt($id);

        $data_pengajuan = Pengajuan::find($id);
        $data_pengajuan_semua = Pengajuan::all();
        $data_anggota = User::all();
        return view('pengajuan.form_konfirmasi_pinjaman', compact('data_pengajuan', 'data_pengajuan_semua', 'data_anggota'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        if ($request->kategori == "Pinjaman") { //request dari data pinjaman
            $request->validate(
                [
                    'bendahara' => 'required',
                    'jumlah' => 'required|numeric|',
                    'anggota_id' => 'required',
                    'keterangan' => 'required',
                    'pembayaran' => 'required',
                ],
                [
                    'sekertaris.required' => 'Laporan kedah di isi',
                    'jumlah.required' => 'Nominal kedah di isi',
                    'jumlah.numeric' => 'Nominal kedah di isi ku Angka',
                    'anggota_id.required' => 'anggota_id kedah di isi',
                    'keterangan.required' => 'keterangan kedah di isi sareng Pami tombil masih teu tiasa di klik mangga di Refresh heula browserna',
                    'pembayaran.required' => 'keterangan kedah di isi',
                ]
            );
        } else {
            $request->validate(
                [
                    'jumlah' => 'required|numeric',
                    'anggota_id' => 'required',
                    'keterangan' => 'required',
                    'pembayaran' => 'required',
                ],
                [
                    'jumlah.required' => 'Nominal kedah di isi',
                    'jumlah.numeric' => 'Nominal kedah di isi ku Angka',
                    'anggota_id.required' => 'anggota_id kedah di isi',
                    'keterangan.required' => 'keterangan kedah di isi sareng Pami tombil masih teu tiasa di klik mangga di Refresh heula browserna',
                    'pembayaran.required' => 'keterangan kedah di isi',
                ]
            );
        }
        if ($request->foto) {
            $file = $request->file('foto');
            $nama = 'bukti-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/bukti'), $nama);
        }
        $data_pengajuan = Pengajuan::Find($id);

        $data_pengajuan->anggota_id = $request->anggota_id;
        $data_pengajuan->jumlah = $request->jumlah;
        $data_pengajuan->pembayaran = $request->pembayaran;
        $data_pengajuan->kategori = $request->kategori;
        $data_pengajuan->keterangan = $request->keterangan;
        if ($request->foto) {
            $data_pengajuan->foto = "/img/bukti/$nama";
        }
        if ($request->kategori == "Pinjaman") { //request dari data pinjaman
            $data_pengajuan->keterangan = $request->bendahara;
            $data_pengajuan->keterangan = $request->sekertaris;
            $data_pengajuan->keterangan = $request->ketua;
        }
        // Kanggo send notifikasi
        $tanggal = Carbon::now();
        $bendahara = User::where('role', 'Bendahara')->get();
        $seker = User::where('role', 'Admin')->get();
        $penasehat = User::where('role', 'Penasehat')->get();
        $user = User::find(Auth::user()->id);
        $nama_pengaju = User::find($request->anggota_id);
        $nominal = 'Rp ' . number_format($request->jumlah, 2, ',', '.');

        $project = [
            'greeting' => 'Sampurasun ' . $nama_pengaju->name . '',
            'body' => 'Pengajuan Atos di edit kantun ngantosan nuju di proses, Antosan sampe pengurus ngaKonfirmasi.',
            'nama' => $nama_pengaju->name,
            'kategori' => $request->kategori,
            'pembayaran' => $request->pembayaran,
            'jumlah' => $nominal,
            'tanggal' => $tanggal,
            'thanks' => 'Hatur Nuhun Pisan Atos Berpartisipasi kana PROGRAM ieu',
            'actionText' => 'Tinggal',
            'actionURL' => url('/'),
            'id' => 57
        ];
        $pengurus = [
            'greeting' => 'HI DULLURRR KABEH',
            'body' => 'Aya Pengajuan anu di edit, dengan Data baru saperti DATA di handap, Mangga Konfirmasi heula, leres teu aya nu masuk atau di titipkeun.',
            'nama' => $nama_pengaju->name,
            'kategori' => $request->kategori,
            'pembayaran' => $request->pembayaran,
            'jumlah' => $nominal,
            'tanggal' => $tanggal,
            'thanks' => 'Hatur Nuhun Pisan Atos Berpartisipasi kana PROGRAM ieu',
            'actionText' => 'Cek di web',
            'actionURL' => url('/'),
            'id' => 57
        ];
        if ($request->pembayaran == "Transfer") {
            $transfer = [
                'greeting' => 'HI DULLURRR',
                'body' => 'Aya Pengajuan yeuhhhh nu di EDIT trus Transfer, Mangga Konfirmasi heula cek di M-banking, leres teu aya nu masuk cek di mutasi trus laporkeun di GROUP WA.',
                'nama' => $nama_pengaju->name,
                'kategori' => $request->kategori,
                'pembayaran' => $request->pembayaran,
                'jumlah' => $nominal,
                'tanggal' => $tanggal,
                'thanks' => 'Hatur Nuhun Pisan Atos Berpartisipasi kana PROGRAM ieu',
                'actionText' => 'Cek di web',
                'actionURL' => url('/'),
                'id' => 57
            ];
            Notification::sendnow($penasehat, new EmailNotification($transfer));
        }

        Notification::sendnow($nama_pengaju, new EmailNotification($project));
        Notification::sendnow($seker, new EmailNotification($pengurus));
        Notification::sendnow($bendahara, new EmailNotification($pengurus));

        $data_pengajuan->update();

        return redirect()->back()->with('infoes', 'Wihhhh mantappp data atos di gentos');
    }
    /**
     * Update the specified resource in storage.
     */
    public function kirim_laporan_pinjaman(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        if (Auth::user()->role == "Bendahara") {
            $request->validate(
                [
                    'bendahara' => 'required',
                ],
                [
                    'bendahara.required' => 'Laporan kedah di isi',
                ]
            );
            $data_pengajuan = Pengajuan::Find($id);
            $data_pengajuan->bendahara = $request->bendahara;
            //Kanggo EMAIL
            $ketua = User::where('role', 'Ketua')->get();
            $sekertaris = User::where('role', 'Sekertaris')->get();
            $nama_pengaju = User::find($request->anggota_id);

            $project = [
                'greeting' => 'Laporan Ti Bendahara Tentang Pinjaman ',
                'body' => 'Bendahara Atos ngisi Laporan sesuai Isi atau pendapat na Mangga Tinjau Laporanna sareng laporan ti Sekertaris.',
                'nama' => $nama_pengaju->name,
                'kategori' => $request->kategori,
                'pembayaran' => 'Pami Atos Aya keputusan Mangga Konfirmasi kanu pegang artosna',
                'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
                'tanggal' => Carbon::now(),
                'thanks' => 'Hatur Nuhun Perhatosanna Mangga Cek Detail na di web',
                'actionText' => 'Cek Laporan Bendahara',
                'actionURL' => url('/'),
                'id' => 57
            ];
            Notification::sendnow($ketua, new EmailNotification($project));
            Notification::sendnow($sekertaris, new EmailNotification($project));

            $data_pengajuan->update();
        }
        if (Auth::user()->role == "Sekertaris") {
            $request->validate(
                [
                    'sekertaris' => 'required',
                ],
                [
                    'sekertaris.required' => 'Laporan kedah di isi',
                ]
            );
            $data_pengajuan = Pengajuan::Find($id);
            $data_pengajuan->sekertaris = $request->sekertaris;
            //Kanggo EMAIL
            $ketua = User::where('role', 'Ketua')->get();
            $nama_pengaju = User::find($request->anggota_id);

            $project = [
                'greeting' => 'Laporan Ti Sekertaris Tentang Pinjaman ',
                'body' => 'Sekertaris Atos ngisi Laporan sesuai Isi atau pendapat na Mangga Tinjau Laporanna sareng laporan ti Sekertaris.',
                'nama' => $nama_pengaju->name,
                'kategori' => $request->kategori,
                'pembayaran' => 'Pami Atos Aya keputusan Mangga Konfirmasi kanu pegang artosna',
                'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
                'tanggal' => Carbon::now(),
                'thanks' => 'Hatur Nuhun Perhatosanna Mangga Cek Detail na di web',
                'actionText' => 'Cek Laporan Sekertaris',
                'actionURL' => url('/'),
                'id' => 57
            ];
            Notification::sendnow($ketua, new EmailNotification($project));
            $data_pengajuan->update();
        }
        if (Auth::user()->role == "Ketua" || Auth::user()->role == "Admin") {
            $request->validate(
                [
                    'sekertaris' => 'required',
                    'ketua' => 'required',
                    'status' => 'required',
                    'bendahara' => 'required',
                ],
                [
                    'ketua.required' => 'Laporan kedah di isi',
                    'status.required' => 'Konfirmasi kedah di isi kedah di isi',
                    'sekertaris.required' => 'Laporan Sekertaris kedah di isi heula',
                    'bendahara.required' => 'Laporan Bendahara kedah di isi heula',
                ]
            );
            if ($request->status == "Tunda") {
                $data_pengajuan = Pengajuan::Find($id);
                $data_pengajuan->ketua = $request->ketua;
                $data_pengajuan->status = $request->status;
                //email
                //Kanggo EMAIL
                $bendahara = User::where('role', 'Bendahara')->get();
                $ketua = User::where('role', 'Ketua')->get();
                $sekertaris = User::where('role', 'Sekertaris')->get();
                $admin = User::where('role', 'Admin')->get();
                $nama_pengaju = User::find($request->anggota_id);
                $project = [
                    'greeting' => 'Bissmilah',
                    'body' => 'Hapunten Pisan Pengajuan Pinjaman sesuai Data di handap teu acan tiasa di setujui, di tunda heula kin pami atos cukup atawa tos memadai bade konfirmasi deui, alasanna bisa di cek di web.',
                    'nama' => $nama_pengaju->name,
                    'kategori' => $request->kategori,
                    'pembayaran' => 'Jangan Berkecil Hati, minta pengertiannya Dana Pinjam masih awal ',
                    'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
                    'tanggal' => Carbon::now(),
                    'thanks' => 'Bissmilah Lancar',
                    'actionText' => 'Cek Alasan',
                    'actionURL' => url('/'),
                    'id' => 57
                ];
                $pengurus = [
                    'greeting' => 'Pengajuan Pinjaman Di Tunda heula ku ' . Auth::user()->name . ' ',
                    'body' => 'Alasan Penundaan bisa di cek di web. Keputusan atas tinjauan tina Laporan Bendahara sareng sekertaris, Data Pengajuan sebagai berikut :.',
                    'nama' => $nama_pengaju->name,
                    'kategori' => $request->kategori,
                    'pembayaran' => 'Selalu Pantau, Jika data memadai bisa di kordinasikeun deui ',
                    'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
                    'tanggal' => Carbon::now(),
                    'thanks' => 'Bissmilah Lancar',
                    'actionText' => 'Cek Alasan',
                    'actionURL' => url('/'),
                    'id' => 57
                ];
                Notification::sendnow($nama_pengaju, new EmailNotification($project));
                Notification::sendnow($bendahara, new EmailNotification($pengurus));
                Notification::sendnow($sekertaris, new EmailNotification($pengurus));
                Notification::sendnow($admin, new EmailNotification($pengurus));

                $data_pengajuan->update();
            } elseif ($request->status == "Nunggak") {

                $data_pengajuan = new Pengeluaran();
                $data_pengajuan->anggota_id = $request->anggota_id;
                $data_pengajuan->keluarga_id = $request->pengaju_id;
                $data_pengajuan->pengurus_id = Auth::user()->id;
                $data_pengajuan->jumlah = $request->jumlah;
                $data_pengajuan->anggaran_id = 3;
                $data_pengajuan->alasan = $request->keterangan;
                $data_pengajuan->tanggal = $request->tanggal;
                $data_pengajuan->bendahara = $request->bendahara;
                $data_pengajuan->sekertaris = $request->sekertaris;
                $data_pengajuan->ketua = $request->ketua;
                $data_pengajuan->status = $request->status;
                //Kanggo EMAIL
                $bendahara = User::where('role', 'Bendahara')->get();
                $ketua = User::where('role', 'Ketua')->get();
                $penasehat = User::where('role', 'Penasehat')->get();
                $admin = User::where('role', 'Admin')->get();
                $nama_pengaju = User::find($request->anggota_id);

                $project = [
                    'greeting' => 'Alhamdullilahhh Pengajuan Pinjaman Atos di setujui',
                    'body' => 'Bismillah, Alhamdulilah Pengajuan Pinjaman Atos di setujui, Kantun Ngantosan Artos na di pasihkeun sesuai keterangan. Di usahakeun data nu di ajukeun leres nya, bilih lepat',
                    'nama' => 'Hiiiii ' . $nama_pengaju->name . ' Di antos nya nuju di proses',
                    'kategori' => 'Tanggung jawab sareng jujur nya supados acara atau programna berjalan lancar.',
                    'pembayaran' => 'Nominal Anu di Ajukeun sebesar :',
                    'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
                    'tanggal' => Carbon::now(),
                    'thanks' => 'Hatur Nuhun Perhatosanna Mangga Cek Detail na di web',
                    'actionText' => 'Cek Di WEB',
                    'actionURL' => url('/'),
                    'id' => 57
                ];
                $pengurus = [
                    'greeting' => 'Pengajuan Atos di Setujui ku ' . Auth::user()->name . ' ',
                    'body' => 'Pengajuan Pinjaman sesuai Data di handap atos di setujui, Mangga Kanu bersangkutan kantun pasihkeun artosna sesuai ketarangan.',
                    'nama' => $nama_pengaju->name,
                    'kategori' => $request->kategori,
                    'pembayaran' => 'Mangga Pasihkeun sesuai keterangan, cek deui sing detail pami di Tf',
                    'jumlah' => 'Rp ' . number_format($request->jumlah, 2, ',', '.'),
                    'tanggal' => Carbon::now(),
                    'thanks' => 'Bissmilah Lancar',
                    'actionText' => 'Cek Data',
                    'actionURL' => url('/'),
                    'id' => 57
                ];

                Notification::sendnow($nama_pengaju, new EmailNotification($project));
                Notification::sendnow($bendahara, new EmailNotification($pengurus));
                Notification::sendnow($penasehat, new EmailNotification($pengurus));
                Notification::sendnow($admin, new EmailNotification($pengurus));

                $data_pengajuan->save();
                if ($request->pengajuan_id) {
                    $pengajuan = Pengajuan::find($request->pengajuan_id);
                    $pengajuan->delete();
                }

                return redirect('pengajuans/pinjam')->with('sukses', 'Pengajuan Pinjaman atos di setujui nuhun ');
            }
        }

        return redirect()->back()->with('infoes', 'hatur nuhun atos bikin laporan, Laporan atos di simpen');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengajuan = Pengajuan::find($id);

        $data_pengajuan->delete();

        return redirect()->back()->with('kuning', 'Data Parantos di hapus tina disimpen dina sampah )');
    }
    public function trash()
    {
        $data_pengajuan = Pengajuan::orderByRaw('created_at DESC')->onlyTrashed()->get();

        return view('pengajuan.trash', compact('data_pengajuan'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengajuan = Pengajuan::withTrashed()->findorfail($id);
        $data_pengajuan->restore();
        return redirect()->back()->with('infoes', 'Data pengajuan atos di kembalikeun deui tina sampah');
    }

    public function kill($id)
    {
        $id = Crypt::decrypt($id);
        $data_pengajuan = Pengajuan::withTrashed()->findorfail($id);

        $data_pengajuan->forceDelete();
        return redirect()->back()->with('kuning', 'Data pengajuan parantos di hapus dina sampah');
    }

    // Pengajuan ==================================================================================================
    public function index_pemasukan()
    {
        $data_pengajuan = Pengajuan::orderByRaw('created_at DESC')->where('kategori', 'Kas')->get();

        return view('pengajuan.index', compact('data_pengajuan'));
    }
    // ------------------------------------------------------------------------------------------------------------
    // Pengluaran==================================================================================================
    public function index_tabungan()
    {
        $data_pengajuan = Pengajuan::orderByRaw('created_at DESC')->where('kategori', 'Tabungan')->get();

        return view('pengajuan.index', compact('data_pengajuan'));
    }
    // -----------------------------------------------------------------------------------------------------------
    // Pengluaran==================================================================================================
    public function tarik_tabungan()
    {
        $data_pengajuan = Pengajuan::orderByRaw('created_at DESC')->where('kategori', 'Ambil_Tabungan')->get();

        return view('pengajuan.index', compact('data_pengajuan'));
    }
    // -----------------------------------------------------------------------------------------------------------
    // Pinjaman ==================================================================================================
    public function index_pinjam()
    {
        $data_pengajuan = Pengajuan::orderByRaw('created_at DESC')->where('kategori', 'Pinjaman')->get();

        return view('pengajuan.index', compact('data_pengajuan'));
    }
    // ------------------------------------------------------------------------------------------------------------
    // Bayar Pinjaman =============================================================================================
    public function index_bayar_pinjam()
    {
        $data_pengajuan = Pengajuan::orderByRaw('created_at DESC')->where('kategori', 'Bayar_Pinjaman')->get();

        return view('pengajuan.index', compact('data_pengajuan'));
    }
    // ------------------------------------------------------------------------------------------------------------

}
