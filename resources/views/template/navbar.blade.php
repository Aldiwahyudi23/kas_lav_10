<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">

        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
        </li>
        @if(Auth::user()->program1 == "Kas")
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{Route('pemasukan.index')}}" class="nav-link" id="bayar ">Bayar</a>
        </li>
        @endif
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{Route('profile')}}" class="nav-link">Profile</a>
        </li>
        @if(Auth::user()->program1 == "Kas")
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{Route('pengeluaran.index')}}" class="nav-link" id="pinjam">Pinjam</a>
        </li>
        @endif
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/peraturan" class="nav-link" id="pinjam">Setting</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <img src="{{ asset('img/layout/logo.jpg') }}" alt="" class=" img-circle " width="35px">
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline" action="{{Route('cari')}}" method="GET">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="text" name="cari" placeholder="Cari Anggota Keluarga" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <!-- Messages Dropdown Menu -->
        <?php

        use App\Models\Keluarga;
        use App\Models\Pengajuan;
        use App\Models\User;

        $pengajuan_total = Pengajuan::all()->count();
        $pengajuan = Pengajuan::all();
        $pengajuan_pinjaman_total = Pengajuan::where('kategori', 'Pinjaman')->count();
        $pengajuan_pinjaman = Pengajuan::where('kategori', 'Pinjaman');
        // cek pengajuan
        $id = User::find(Auth::user()->id); // mengambil data user yang login
        $data_keluarga = Keluarga::find($id->keluarga_id); //mengambil data dari data keluarga sesuai dengan id dari yang login
        $id_user_hubungan = Keluarga::find($data_keluarga->keluarga_id); //mengambil id dari hubungan si penglogin

        if (
            $data_keluarga->hubungan == "Istri" || $data_keluarga->hubungan == "Suami"
        ) {
            $pengajuan_user_total = Pengajuan::where('anggota_id', $id_user_hubungan->user_id)->count();
            $pengajuan_user = Pengajuan::where('anggota_id', $id_user_hubungan->user_id)->get();
        } else {
            $pengajuan_user_total = Pengajuan::where('anggota_id', Auth::id())->count();
            $pengajuan_user = Pengajuan::where('anggota_id', Auth::user()->id)->get();
        }
        // cek pengajuan sampai die
        ?>
        <!-- Notif buat bendahara dan sekertaris -->
        @if(Auth::user()->role == "Admin" || Auth::user()->role == "Bendahara" ||Auth::user()->role == "Sekertaris")
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if($pengajuan_total >= 1)
                <span class="badge badge-warning navbar-badge">{{$pengajuan_total}}</span>
                @else
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach( $pengajuan as $data)
                @if ($data->kategori == "Pinjaman")
                <a href="{{Route('pengajuan.laporan',Crypt::encrypt($data->id))}}" class="dropdown-item">
                    @else
                    <a href="{{Route('pengajuan.show',Crypt::encrypt($data->id))}}" class="dropdown-item">
                        @endif
                        <!-- Message Start -->
                        <div class="media">
                            <?php
                            $user = User::find($data->anggota_id)
                            ?>
                            <img src="{{ asset($user->foto) }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{$data->anggota->name}}
                                    <span class="float-right text-sm text-danger">{{$data->status}}</i></span>
                                </h3>
                                <p class="text-sm">{{$data->kategori}} {{ "Rp " . number_format($data->jumlah,2,',','.') }} </p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{Carbon\Carbon::parse($data->created_at)->diffForHumans()}}</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a href="{{Route('table-pengajuan-kas')}}" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == "Anggota" || Auth::user()->role == "Penasehat")
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if($pengajuan_user_total >= 1)
                <span class="badge badge-warning navbar-badge">{{$pengajuan_user_total}}</span>
                @else
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach($pengajuan_user as $data)
                <a href="{{Route('pengajuan.show',Crypt::encrypt($data->id))}}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <?php
                        $user = User::find($data->anggota_id)
                        ?>
                        <img src="{{ asset($user->foto) }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{$data->anggota->name}}
                                <span class="float-right text-sm text-danger">{{$data->status}}</i></span>
                            </h3>
                            <p class="text-sm">{{$data->kategori}} {{ "Rp " . number_format($data->jumlah,2,',','.') }} </p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{Carbon\Carbon::parse($data->created_at)->diffForHumans()}}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                @endforeach
                <div class="dropdown-divider"></div>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == "Ketua")
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if($pengajuan_pinjaman_total >= 1)
                <span class="badge badge-warning navbar-badge">{{$pengajuan_pinjaman_total}}</span>
                @else
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach( $pengajuan_pinjaman as $data)
                <a href="{{Route('pengajuan.show',Crypt::encrypt($data->id))}}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <?php
                        $user = User::find($data->anggota_id)
                        ?>
                        <img src="{{ asset($user->foto) }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{$data->anggota->name}}
                                <span class="float-right text-sm text-danger">{{$data->status}}</i></span>
                            </h3>
                            <p class="text-sm">{{$data->kategori}} {{ "Rp " . number_format($data->jumlah,2,',','.') }} </p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{Carbon\Carbon::parse($data->created_at)->diffForHumans()}}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{Route('table-pengajuan-pinjaman')}}" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        @endif
        <!-- notif khusus Ketua dan hanya pengajuan pinjaman saja -->
        <!-- Notifications Dropdown Menu -->

        <!-- <li class="nav-item">
            <a class="nav-link active" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li> -->
        <!-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> -->

        <?php

        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Facades\DB;

        $tabungan = DB::table('pemasukans')->where('pemasukans.kategori', '=', "Tabungan");
        $total_tabungan = $tabungan->where('pemasukans.anggota_id', '=', Auth::user()->id)
            ->sum('pemasukans.jumlah');
        ?>
        @if (Auth::user()->program2 == "Tabungan")
        <li class="nav-item dropdown">
            <a href="{{route('tambah.anggota.tabungan',Crypt::encrypt(Auth::user()->id))}}" class="nav-link" style="color: #fff">
                </i> &nbsp; {{ "Rp " . number_format($total_tabungan,2,',','.') }}
            </a>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link" href="#">
                {{Auth::user()->name}}
            </a>
        </li>
        @endif
    </ul>
</nav>