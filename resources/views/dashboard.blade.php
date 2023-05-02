@extends ('template.home')

@section('content')
<section class="content">
    <div class="container-fluid">
        @if(Auth::user()->role == "Admin" || Auth::user()->role == "Bendahara" || Auth::user()->role == "Sekertaris" || Auth::user()->role == "Ketua" || Auth::user()->role == "Penasehat" )
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan Kas</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="it">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-wrench"></i>
                                </button>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="products-list product-list-in-card pl-1 pr-1">
                            <a href="javascript:void(0)" class="product-title">Saldo ATM</a>
                            <h5>{{"Rp" . number_format($saldo_bank ,2,',','.')}}</h5>
                            <p>Saldo ATM, saldo anu aya tina tabungan kas keluarga. Jumlah <b>saldo ATM</b> di tambah artos nu masih di <b>bendahara</b> kedah <b>sami</b> sareng jumlah <b>SALDO tiap Laporan</b> </p>
                            <hr />
                        </ul>
                        <ul class="products-list product-list-in-card pl-1 pr-1">
                            <a href="{{Route('pemasukan.create')}}" class="product-title">Uang dibendahara nu teu acan di TF</a>
                            <h5>{{"Rp" . number_format( $uang_blum_diTF,2,',','.')}}</h5>
                            <p>Artos nu teu acan di setor tunai keun ku bendahara, sareng nu masih di pegang ku bendahara atanapi sekertaris</p>
                            <hr />
                        </ul>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>
                                    <h5 class="description-header">{{"Rp" . number_format(  $total_dana_kas - $total_pengeluaran_kas_3,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO KAS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                                    <h5 class="description-header">{{"Rp" . number_format( $total_dana_darurat - $total_pengeluaran_darurat,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO DARURAT</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>
                                    <h5 class="description-header">{{"Rp" . number_format( $total_dana_amal - $total_pengeluaran_amal,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO AMAL</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 0%</span>
                                    <h5 class="description-header">{{"Rp" . number_format( $total_dana_pinjam -  $total_pengeluaran_pinjaman + $total_bayar_pinjaman_semua,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO PINJAMAN</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- /.row -->

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan KAS</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-wrench"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                    <a href="#" class="dropdown-item">Something else here</a>
                                    <a class="dropdown-divider"></a>
                                    <a href="#" class="dropdown-item">Separated link</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="/pemasukan/detail" class="product-title">Jumlah Pemasukan Kas</a>
                                    <h5>{{ "Rp " . number_format($total_pemasukan_kas,2,',','.') }}</h5>
                                    <p>Jumlah sadayana artos pemasukan uang kas nu terkumpul ti awal sareng dugi ayeuna</p>
                                    <hr>
                                </ul>

                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="/pengeluaran/detail" class="product-title">Jumlah Pengeluaran Kas</a>
                                    <h5>{{ "Rp " . number_format( $total_pengeluaran_kas - $total_pengeluaran_pinjaman,2,',','.') }}</h5>
                                    <p> Jumlah sadayana pengluaran sesuai data anggaran, kecuali data pinjaman tidak termasuk pengluaran.</p>
                                    <hr>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <b> <a href="javascript:void(0)" class="product-title">Saldo Kas</a>
                                        <h4>{{"Rp" . number_format(  $saldo_kas ,2,',','.')}}</h4>
                                        <p> Jumlah Total saldo anu aya di bendahara atawa sisa tina pengeluaran termasuk data pinjaman. </p>
                                        <hr />
                                    </b>
                                </ul>

                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="javascript:void(0)" class="product-title">Uang nu di pinjem</a>
                                    <h5>{{"Rp" . number_format( $total_pengeluaran_pinjaman - $total_bayar_pinjaman_semua ,2,',','.')}}</h5>
                                    <hr />
                                </ul>

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan TABUNGAN</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-wrench"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                    <a href="#" class="dropdown-item">Something else here</a>
                                    <a class="dropdown-divider"></a>
                                    <a href="#" class="dropdown-item">Separated link</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="/pemasukan/detail" class="product-title">Jumlah Pemasukan Tabungan</a>
                                    <h5>{{ "Rp " . number_format( $total_tabungan,2,',','.') }}</h5>
                                    <p>Jumlah sadayana artos tabungan anggota</p>
                                    <hr>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="/pengeluaran/detail" class="product-title">Jumlah Penarikan Tabungan</a>
                                    <h5>{{ "Rp " . number_format($total_pengeluaran_tarik_pinjaman,2,',','.') }}</h5>
                                    <p> Jumlah sadayana Penarikan tabungan anggota.</p>
                                    <hr>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <b> <a href="javascript:void(0)" class="product-title">Jumlah sisa Tabungan</a>
                                        <h4>{{"Rp" . number_format($total_tabungan - $total_pengeluaran_tarik_pinjaman,2,',','.')}}</h4>
                                        <p> Jumlah sisa tabungan anggota, sisa tina penarikan. </p>
                                        <hr />
                                    </b>
                                </ul>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        @else
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan Kas</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-wrench"></i>
                                </button>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <b> <a href="{{route('data_pemasukan_all')}}" class="product-title">Saldo Kas</a>
                                        <h4>{{"Rp" . number_format( $saldo_kas,2,',','.')}}</h4>
                                        <p> Jumlah Total saldo anu aya di bendahara atawa sisa tina pengeluaran termasuk data pinjaman. </p>
                                        <hr />
                                    </b>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{route('anggaran.show',Crypt::encrypt(1))}}" class="product-title">Jumlah Dana Darurat</a>
                                    <h5>{{ "Rp " . number_format($total_dana_darurat - $total_pengeluaran_darurat ,2,',','.') }}</h5>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{Route('table_pengeluaran_detail',Crypt::encrypt(1))}}" class="product-title">Jumlah Dana Darurat nu tos ka angge </a>
                                    <h7>{{ "Rp " . number_format($total_pengeluaran_darurat ,2,',','.') }}</h7>
                                    <hr>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{route('anggaran.show',Crypt::encrypt(2))}}" class="product-title">Jumlah Dana Amal</a>
                                    <h5>{{ "Rp " . number_format($total_dana_amal - $total_pengeluaran_amal,2,',','.') }}</h5>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{Route('table_pengeluaran_detail',Crypt::encrypt(2))}}" class="product-title">Jumlah Dana Amal nu tos ka angge </a>
                                    <h7>{{ "Rp " . number_format($total_pengeluaran_amal ,2,',','.') }}</h7>
                                    <hr>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{route('anggaran.show',Crypt::encrypt(6))}}" class="product-title">Jumlah dana KAS</a>
                                    <h5>{{"Rp" . number_format($total_dana_kas - $total_pengeluaran_kas_3,2,',','.')}}</h5>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{Route('table_pengeluaran_detail',Crypt::encrypt(6))}}" class="product-title">Jumlah Dana Kas nu tos ka angge </a>
                                    <h7>{{ "Rp " . number_format($total_pengeluaran_kas_3  ,2,',','.') }}</h7>
                                    <hr>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{Route('anggaran.show',Crypt::encrypt(3))}}">Jumlah Dana Pinjam</a>
                                    <h5>{{"Rp" . number_format($total_dana_pinjam -  $total_pengeluaran_pinjaman + $total_bayar_pinjaman_semua,2,',','.')}}</h5>
                                </ul>
                                <ul class="products-list product-list-in-card pl-1 pr-1">
                                    <a href="{{Route('table_pengeluaran_detail_pinjaman',Crypt::encrypt(3))}}" class="product-title">Sisa Uang nu di pinjem</a>
                                    <h7>{{"Rp" . number_format($total_pengeluaran_pinjaman - $total_bayar_pinjaman_semua,2,',','.')}}</h7>
                                    <hr />
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <!-- TABLE: LATEST ORDERS -->
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Kategori</th>
                                                        <th>Status</th>
                                                        <th>Nominal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data_pengajuan_baru as $data)
                                                    <tr>
                                                        <td><a href="">PE_{{date('dmy',strtotime($data->tanggal)) }}-{{$data->id}}</a></td>
                                                        <td>{{$data->kategori}}</td>
                                                        @if ($data->status == "Tunda")
                                                        <td><span class="badge badge-warning">{{$data->status}}</span></td>
                                                        @else
                                                        <td><span class="badge badge-info">{{$data->status}}</span></td>
                                                        @endif
                                                        <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @foreach($data_pemasukan_baru as $data)
                                                    <tr>
                                                        <td><a href="{{route('data_pemasukan_all')}}">IN_{{date('dmy',strtotime($data->tanggal)) }}-{{$data->id}}</a></td>
                                                        <td>{{$data->kategori}}</td>
                                                        <td><span class="badge badge-success">Disetujui</span></td>
                                                        <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @foreach($data_pengeluaran_baru as $data)
                                                    <tr>
                                                        <td><a href="{{Route('table_pengeluaran_detail_pinjaman',Crypt::encrypt(3))}}">EX_{{date('dmy',strtotime($data->tanggal)) }}-{{$data->id}}</a></td>
                                                        <td>{{$data->anggaran->nama_anggaran}}</td>
                                                        <td><span class="badge badge-success">Disetujui</span></td>
                                                        <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>
                                    <h5 class="description-header">{{"Rp" . number_format(  $total_dana_kas - $total_pengeluaran_kas_3,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO KAS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                                    <h5 class="description-header">{{"Rp" . number_format( $total_dana_darurat - $total_pengeluaran_darurat,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO DARURAT</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                                    <h5 class="description-header">{{"Rp" . number_format( $total_dana_amal - $total_pengeluaran_amal,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO AMAL</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                                    <h5 class="description-header">{{"Rp" . number_format( $total_dana_pinjam -  $total_pengeluaran_pinjaman + $total_bayar_pinjaman_semua,2,',','.')}}</h5>
                                    <span class="description-text">TOTAL SALDO PINJAMAN</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        @endif
        <!-- Main row  Aset -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-6">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Aktivitas peminjaman ASET</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Nama Aset</th>
                                        <th>Status</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tanggal di kembalikan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_pinjaman_aset as $data)
                                    <tr>
                                        <td><a href="{{route('asetpinjam.show',Crypt::encrypt($data->id))}}">{{$data->kode}}</a></td>
                                        <td>{{$data->aset->nama_aset}}</td>
                                        @if ($data->status == "Pinjam")
                                        <td><span class="badge badge-warning">{{$data->status}}</span></td>
                                        @else
                                        <td><span class="badge badge-info">{{$data->status}}</span></td>
                                        @endif
                                        <td>{{ $data->nama_peminjam}}</td>
                                        <td>{{ $data->tanggal_kembali}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DATA ASET</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-light">
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Nama aset</th>
                                    <th>persen</th>
                                    <th>lokasi terakhir</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Kondisi</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 0; ?>
                                @foreach($data_aset as $data)
                                <?php $no++; ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$data->kode}}</td>
                                    <td>{{$data->nama_aset}}</td>
                                    <td>{{$data->persen}}</td>
                                    <td>{{$data->lokasi}}</td>
                                    <td>{{$data->tanggal}}</td>
                                    <td>{{$data->kondisi}}</td>
                                    <td>{!!$data->deskripsi!!}</td>
                                    <td>
                                        <a href="{{route('aset.show',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-book"></i></a>
                                    </td>


                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-body -->

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- Main row  -->
        <div class="row">
            <!-- Left col -->

            <div class="col-md-12">
                <!-- PRODUCT LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Login</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($data_login as $user_login)
                            <li class="item">
                                <div class="product-img">
                                    <a href="{{ asset($user_login->foto) }}" data-toggle="lightbox" data-title="Foto {{ $user_login->name }}" data-gallery="gallery">

                                        <img src="{{ asset($user_login->foto) }}" alt="Product Image" class="img-size-50 img-circle">
                                    </a>
                                </div>
                                <div class="product-info">
                                    <a href="{{route('profile.user',Crypt::encrypt($user_login->id))}}" class="product-title">{{$user_login->name}} </a>
                                    @if(Cache::has('user-is-online-' .$user_login->id))
                                    <span class="text-success badge float-right">Online</span>
                                    @else
                                    <span class="text-secondary badge float-right">Offline</span>
                                    @endif <br>
                                    <span class="badge float-right"><i class="far fa-clock"></i> {{Carbon\Carbon::parse($user_login->last_seen)->diffForHumans()}}</span>
                                </div>
                            </li>
                            @endforeach
                            <!-- /.item -->
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>

    </div><!--/. container-fluid -->
</section>
@endsection
@section('script')
<script>
    $("#imah").addClass("active");
</script>
@endsection