<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\AsetPinjamController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\BayarPinjamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\RoleProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Data Anggota atau User
Route::resource('anggota', AnggotaController::class)->middleware(['auth', 'verified']);
Route::get('/anggotas/trash/', [AnggotaController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('anggota.trash');
Route::post('/anggots/kill/{id}', [AnggotaController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('anggota.kill');
Route::get('/anggotas/restore/{id}', [AnggotaController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('anggota.restore');
Route::post('/anggotas/update/foto/{id}', [AnggotaController::class, 'update_foto'])->middleware(['auth', 'verified'])->name('anggota.update.foto');
Route::post('/anggotas/aktif/{id}', [AnggotaController::class, 'is_active'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('is_active');

//Data Keluarga
Route::resource('keluarga', KeluargaController::class)->middleware(['auth', 'verified']);
Route::get('/keluargas/detail/{id}', [KeluargaController::class, 'detail'])->middleware(['auth', 'verified'])->name('keluarga.detail');
Route::get('/keluargas/trash/', [KeluargaController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('keluarga.trash');
Route::post('/anggots/kill/{id}', [KeluargaController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('keluarga.kill');
Route::get('/keluargas/restore/{id}', [KeluargaController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('keluarga.restore');
Route::get('/keluargas/tambah/{id}', [KeluargaController::class, 'tambah'])->middleware(['auth', 'verified'])->name('keluarga.tambah');

// Data Role
Route::resource('role', RoleController::class)->middleware(['auth', 'verified']);
Route::get('/roles/trash/', [RoleController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('role.trash');
Route::post('/roles/kill/{id}', [RoleController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('role.kill');
Route::get('/roles/restore/{id}', [RoleController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('role.restore');

// Data Program
Route::resource('program', ProgramController::class)->middleware(['auth', 'verified']);
Route::get('/programs/trash/', [ProgramController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('program.trash');
Route::post('/programs/kill/{id}', [ProgramController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('program.kill');
Route::get('/programs/restore/{id}', [ProgramController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('program.restore');
// Data Anggaran
Route::resource('anggaran', AnggaranController::class)->middleware(['auth', 'verified']);
Route::get('/anggarans/trash/', [AnggaranController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('anggaran.trash');
Route::post('/anggarans/kill/{id}', [AnggaranController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('anggaran.kill');
Route::get('/anggarans/restore/{id}', [AnggaranController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('anggaran.restore');

//DATA bantuan
Route::resource('bantuan', BantuanController::class)->middleware(['auth', 'verified']);
Route::get('/bantuans/trash/', [BantuanController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('bantuan.trash');
Route::post('/bantuans/kill/{id}', [BantuanController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('bantuan.kill');
Route::get('/bantuans/restore/{id}', [BantuanController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('bantuan.restore');
Route::get('/bantuans/detail/{id}', [BantuanController::class, 'bantuan'])->middleware(['auth'])->name('bantuan.detail');
Route::get('/bantuans/login/{id}', [BantuanController::class, 'login'])->name('bantuan.login');


//Data Asset
Route::resource('aset', AsetController::class)->middleware(['auth', 'verified']);
Route::get('/asets/trash/', [AsetController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('aset.trash');
Route::post('/asets/kill/{id}', [AsetController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('aset.kill');
Route::get('/asets/restore/{id}', [AsetController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('aset.restore');
//Data Asset Pinjam
Route::resource('asetpinjam', AsetPinjamController::class)->middleware(['auth', 'verified']);
Route::get('/asets/pinjam/detail/{id}', [AsetPinjamController::class, 'detail'])->middleware(['auth', 'verified'])->name('aset.pinjam.detail');
Route::get('/asets/pinjam/trash/', [AsetPinjamController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('aset.pinjam.trash');
Route::post('/asets/pinjam/kill/{id}', [AsetPinjamController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('aset.pinjam.kill');
Route::get('/asets/pinjam/restore/{id}', [AsetPinjamController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('aset.pinjam.restore');
// Pemasukan
Route::resource('pemasukan', PemasukanController::class)->middleware(['auth', 'verified']);
Route::get('/pemasukans/trash/', [PemasukanController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pemasukan.trash');
Route::post('/pemasukans/kill/{id}', [PemasukanController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pemasukan.kill');
Route::get('/pemasukans/restore/{id}', [PemasukanController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pemasukan.restore');
Route::get('/pemasukans/detail/kas/{id}', [PemasukanController::class, 'detail_anggota_kas'])->middleware(['auth', 'verified'])->name('detail.anggota.kas');
Route::get('/pemasukans/detail/tabungan/{id}', [PemasukanController::class, 'detail_anggota_tabungan'])->middleware(['auth', 'verified'])->name('detail.anggota.tabungan');
Route::get('/pemasukans/tambah/tabungan/{id}', [PemasukanController::class, 'tambah_anggota_tabungan'])->middleware(['auth', 'verified'])->name('tambah.anggota.tabungan');
Route::get('/pemasukans/kas/all/', [PemasukanController::class, 'data_pemasukan_all'])->middleware(['auth', 'verified'])->name('data_pemasukan_all');
//pemasukan Admin
Route::get('/pemasukans/kas/', [PemasukanController::class, 'data_pemasukan_admin'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('data_pemasukan_admin');
// pengajuan
Route::resource('pengajuan', PengajuanController::class)->middleware(['auth', 'verified']);
Route::get('/pengajuans/trash/', [PengajuanController::class, 'trash'])->middleware(['auth', 'verified'])->name('pengajuan.trash');
Route::post('/pengajuans/kill/{id}', [PengajuanController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pengajuan.kill');
Route::get('/pengajuans/restore/{id}', [PengajuanController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pengajuan.restore');
Route::get('/pengajuans/kas', [PengajuanController::class, 'index_pemasukan'])->middleware(['auth', 'verified'])->name('table-pengajuan-kas');
Route::get('/pengajuans/tabungan', [PengajuanController::class, 'index_tabungan'])->middleware(['auth', 'verified'])->name('table-pengajuan-tabungan');
Route::get('/pengajuans/tarik/tabungan', [PengajuanController::class, 'tarik_tabungan'])->middleware(['auth', 'verified'])->name('table-pengajuan-tarik_tabungan');
Route::get('/pengajuans/pinjam', [PengajuanController::class, 'index_pinjam'])->middleware(['auth', 'verified'])->name('table-pengajuan-pinjaman');
Route::get('/pengajuans/bayar', [PengajuanController::class, 'index_bayar_pinjam'])->middleware(['auth', 'verified'])->name('table-pengajuan-bayar_pinjaman');
Route::get('/pengajuans/laporan/{id}', [PengajuanController::class, 'laporan_pinjaman'])->middleware(['auth', 'verified'])->name('pengajuan.laporan');
Route::post('/pengajuans/laporan/{id}', [PengajuanController::class, 'kirim_laporan_pinjaman'])->middleware(['auth', 'verified'])->name('kirim_pengajuan.laporan');

// Pengeluaran
Route::resource('pengeluaran', PengeluaranController::class)->middleware(['auth', 'verified']);
Route::get('/pengeluarans/trash/', [PengeluaranController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pengeluaran.trash');
Route::post('/pengeluarans/kill/{id}', [PengeluaranController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pengeluaran.kill');
Route::get('/pengeluarans/restore/{id}', [PengeluaranController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('pengeluaran.restore');
Route::post('/pengeluarans/store/tarik', [PengeluaranController::class, 'tarik_tabungan'])->middleware(['auth', 'verified'])->name('tarik_tabungan');
Route::post('/pengeluarans/store/pinjaman', [PengeluaranController::class, 'store_pinjaman'])->middleware(['auth', 'verified'])->name('store_pinjaman');
Route::get('/pengeluarans/detail/peranggaran/{id}', [PengeluaranController::class, 'table_pengeluaran_detail'])->middleware(['auth', 'verified'])->name('table_pengeluaran_detail');
Route::get('/pengeluarans/detail/pinjaman/{id}', [PengeluaranController::class, 'table_pengeluaran_detail_pinjaman'])->middleware(['auth', 'verified'])->name('table_pengeluaran_detail_pinjaman');
//pemasukan Admin
Route::get('/pengeluarans/all/', [PengeluaranController::class, 'data_pengeluaran_admin'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('data_pengeluaran_admin');

//Data Asset
Route::resource('pinjaman', BayarPinjamanController::class)->middleware(['auth', 'verified']);
Route::get('/bayar/pinjaman/trash/', [BayarPinjamanController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('bayar.pinjaman.trash'); //tidak di pake
Route::post('/bayar/pinjaman/kill/{id}', [BayarPinjamanController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('bayar.pinjaman.kill'); //tidak di pake
Route::get('/bayar/pinjaman/restore/{id}', [BayarPinjamanController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('bayar.pinjaman.restore'); //tidak di pake

// Profile
Route::get('/profile', [KeluargaController::class, 'profile'])->middleware(['auth'])->name('profile');
Route::get('/profile/user/{id}', [KeluargaController::class, 'profile_user'])->middleware(['auth', 'verified'])->name('profile.user');
Route::get('/profile/edit/{id}', [KeluargaController::class, 'profile_edit'])->middleware(['auth', 'verified'])->name('profile.edit');
Route::get('/pengaturan/email', [KeluargaController::class, 'edit_email'])->middleware(['auth'])->name('pengaturan.email');
Route::post('/pengaturan/ubah-email', [KeluargaController::class, 'ubah_email'])->middleware(['auth'])->name('pengaturan.ubah-email');
Route::get('/pengaturan/password', [KeluargaController::class, 'edit_password'])->middleware(['auth', 'verified'])->name('pengaturan.password');
Route::post('/pengaturan/ubah-password', [KeluargaController::class, 'ubah_password'])->middleware(['auth', 'verified'])->name('pengaturan.ubah-password');
Route::get('/keturunan/cari/', [KeluargaController::class, 'keturunan_detail'])->name('cari');
Route::get('/keturunan/detail/{id}', [KeluargaController::class, 'keturunan'])->name('keturunan_detail');

//Peraturan
Route::get('/peraturan', [HomeController::class, 'peraturan'])->middleware(['auth']);
Route::resource('roleprogram', RoleProgramController::class)->middleware(['auth', 'verified']);

//Data Foto
Route::resource('foto', FotoController::class)->middleware(['auth', 'verified']);
Route::get('/fotos/trash/', [FotoController::class, 'trash'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('foto.trash');
Route::post('/fotos/kill/{id}', [FotoController::class, 'kill'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('foto.kill');
Route::get('/fotos/restore/{id}', [FotoController::class, 'restore'])->middleware(['auth', 'verified', 'checkRole:Admin'])->name('foto.restore');


require __DIR__ . '/auth.php';
