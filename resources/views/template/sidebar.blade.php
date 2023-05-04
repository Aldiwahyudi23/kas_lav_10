<?php

use App\Models\Anggaran;
use App\Models\Anggota;
use App\Models\AsetPinjam;
use App\Models\Pengajuan;
use App\Models\Program;
use App\Models\Role;

$jumlah_trush = Anggota::withTrashed()->count();
$jumlah_anggota_keluarga = Anggota::withTrashed()->count();

$pengajuan = Pengajuan::all()->count();
$bayar = Pengajuan::where('kategori', 'Kas')->count();
$pinjaman = Pengajuan::where('kategori', 'Pinjaman')->count();
$bayar_pinjaman = Pengajuan::where('kategori', 'Bayar_Pinjaman')->count();
$bayar_tabungan = Pengajuan::where('kategori', 'Tabungan')->count();
$tarik_tabungan = Pengajuan::where('kategori', 'Ambil_Tabungan')->count();

// Data Anggaran
$data_anggaran = Anggaran::all();
// Data Anggaran
$data_tugas = Role::all();

//
$data_pinjaman = AsetPinjam::find(1);
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                  
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/profile" class="nav-link" id="pengajuanpinjam">
                        <img src="{{ asset( Auth::user()->foto) }}" width="50%" alt="AdminLTE Logo" class="img-circle elevation-3"> <br>
                        <p> {{ Auth::User()->name}} </p><br>
                        <p> {{ Auth::User()->email }} </p>

                    </a>
                </li>
                @if (Auth::user()->role == "Admin" || Auth::user()->role == "Sekertaris")
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Pengajuan
                            @if ($pengajuan == 0)
                            @else
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">{{$pengajuan}}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-kas')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>KAS</p>
                                @if ($bayar == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$bayar}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-tabungan')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tabungan</p>
                                @if ($bayar_tabungan == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$bayar_tabungan}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-tarik_tabungan')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tarik abungan</p>
                                @if ($tarik_tabungan == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$tarik_tabungan}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-pinjaman')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pinjaman</p>
                                @if ($pinjaman == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$pinjaman}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-bayar_pinjaman')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bayar Pinjaman</p>
                                @if ($bayar_pinjaman == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$bayar_pinjaman}}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Mater Data
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{Route('program.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Program</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('anggaran.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Anggaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('aset.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('role.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role /Akses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('data_pemasukan_admin')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pemasukan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('data_pengeluaran_admin')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengeluaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('keluarga.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Keluarga</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('anggota.index')}}" class="nav-link" id="DataUser">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Data User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                            @endif
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview" id="liViewTrash">
                    <a href="#" class="nav-link" id="ViewTrash">
                        <i class="nav-icon fas fa-recycle"></i>
                        <p>
                            View Trash

                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{Route('role.trash')}}" class="nav-link" id="TrashJadwal">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Trash Role</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{Route('program.trash')}}" class="nav-link" id="TrashProgram">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Program</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('anggaran.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Anggaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('pemasukan.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Pemasukan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('pengajuan.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Pengajuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('pengeluaran.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Pengeluaran</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{Route('aset.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Aset</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{Route('keluarga.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Keluarga</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('foto.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Foto Keluarga</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('anggota.trash')}}" class="nav-link" id="TrashAnggaran">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash user</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">DATA</li>
                <li class="nav-item">
                    <a href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Calendar
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{Route('asetpinjam.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Pinjaman ASET
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{Route('bantuan.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Data Bantuan
                        </p>
                    </a>
                </li>
                @else
                @if (Auth::user()->role == "Bendahara")
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Pengajuan
                            @if ($pengajuan == 0)
                            @else
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">{{$pengajuan}}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-kas')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>KAS</p>
                                @if ($bayar == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$bayar}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-tabungan')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tabungan</p>
                                @if ($bayar_tabungan == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$bayar_tabungan}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-tarik_tabungan')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tarik abungan</p>
                                @if ($tarik_tabungan == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$tarik_tabungan}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-pinjaman')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pinjaman</p>
                                @if ($pinjaman == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$pinjaman}}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{Route('table-pengajuan-bayar_pinjaman')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bayar Pinjaman</p>
                                @if ($bayar_pinjaman == 0)
                                @else
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{$bayar_pinjaman}}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Program KAS
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($data_anggaran as $data)
                        <li class="nav-item">
                            <a href="{{Route('anggaran.show',Crypt::encrypt($data->id))}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{$data->nama_anggaran}}
                                </p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li> -->

                <li class="nav-item">
                    <a href="{{Route('asetpinjam.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Pinjaman ASET
                        </p>
                    </a>
                </li>

                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tugas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($data_tugas as $data)
                        <li class="nav-item">
                            <a href="{{Route('role.show',Crypt::encrypt($data->id))}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{$data->nama_role}}
                                </p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-sign-out-alt"></i> &nbsp; Kaluar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </li>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>