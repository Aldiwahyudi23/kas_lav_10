 @extends('template.home')
 @section('content')
 <section class="content">
     <div class="container-fluid">
         <!-- ./row -->
         <div class="row">
             <div class="col-12 col-sm-6">
                 <div class="card card-primary card-outline card-outline-tabs">
                     <div class="card-header p-0 border-bottom-0">
                         <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                             <li class="nav-item">
                                 <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">PINJAM</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Deskripsi</a>
                             </li>
                             @if(Auth::user()->role == "Admin" || Auth::user()->role == "Sekertaris")
                             <li class="nav-item">
                                 <a href="{{Route('pengeluaran.create')}}" class="nav-link" id="custom-tabs-four-messages-tab">PENGELUARAN</a>
                             </li>
                             @endif
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="tab-content" id="custom-tabs-four-tabContent">
                             <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <!-- Form Admin -->
                                 @if (Auth::user()->role == "Admin")
                                 <center>
                                     <img src="https://media.tenor.com/LAkobF0eiDwAAAAC/assalamu-alaikum-salam.gif" alt="" width="50%">
                                     <h5 class="text-bold card-header bg-light p-0"> FORM PINJAMAN</h5>
                                 </center>
                                 <form id="basic-form" action="{{Route('pengajuan.store')}}" method="POST" enctype="multipart/form-data" novalidate>
                                     {{csrf_field()}}
                                     <div class="form-group row">
                                         <label for="pengaju_id">Nama Keluarga</label>
                                         <select id="pengaju_id" name="pengaju_id" class="select2 form-control @error('pengaju_id') is-invalid @enderror">
                                             @if (old('pengaju_id') == true)
                                             <option value="{{old('pengaju_id')}}">{{old('nama')}}</option>
                                             @endif
                                             <option value="">-- Pilih keluarga --</option>
                                             @foreach ($keluarga as $data)
                                             <option value="{{$data->id}}"> {{$data->nama}}</option>
                                             @endforeach
                                         </select>
                                         @error('pengaju_id')
                                         <div class="invalid-feedback">
                                             <strong>{{ $message }}</strong>
                                         </div>
                                         @enderror
                                     </div>
                                     <div class="form-group row">
                                         <label for="jumlah">Nominal</label>
                                         <input type="hidden" name="anggota_id" id="anggota_id" value="{{Auth::id()}}">
                                         <input type="hidden" name="kategori" id="kategori" value="Pinjaman">
                                         <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="Cont : 50000    jangan pake titik ataupun koma" class="form-control col-12 @error('jumlah') is-invalid @enderror">
                                         @error('jumlah')
                                         <div class="invalid-feedback">
                                             <strong>{{ $message }}</strong>
                                         </div>
                                         @enderror
                                         <span class="text-dark" style="font-size: 10px">Jatah perorang {{$data_anggaran_max_pinjaman->persen}} % tina jumlah sadayana anggaran pinjaman yaeta {{"Rp" . number_format($jatah,2,',','.')}}, teu kengeng ngalebihi.</span>
                                     </div>
                                     <div class="form-group row">
                                         <label for="pembayaran">Metode Pembayaran</label>
                                         <select name="pembayaran" id="pembayaran" class="form-control select2bs4 @error('pembayaran') is-invalid @enderror">

                                             <option value="">--Pilih Pembayaran--</option>
                                             <option value="Cash">Uang Tunai</option>
                                             <option value="Transfer">Transfer</option>
                                         </select>
                                         @error('pembayaran')
                                         <div class="invalid-feedback">
                                             <strong>{{ $message }}</strong>
                                         </div>
                                         @enderror
                                     </div>
                                     <div class="form-group">
                                         <label for="keterangan">Keterangan</label>
                                         <textarea name="keterangan" class="textarea form-control bg-light @error('keterangan') is-invalid @enderror" id="summernote" rows="6" value="{{ old('keterangan') }}">{{ old('keterangan') }}
                                         <p id="keterangann"></p>
                                         </textarea>
                                         @error('keterangan')
                                         <div class="invalid-feedback">
                                             <strong>{{ $message }}</strong>
                                         </div>
                                         @enderror
                                     </div>
                                     <p id="keterangan"></p>
                                     <hr>
                                     <button onclick="tombol_pinjam()" id="myBtn_pinjam" type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> PINJAM</button>
                                     <div id="tombol_proses"></div>
                                     <span class="text-dark" style="font-size: 10px">Pinjaman di batasi Jatah {{$data_anggaran_max_pinjaman->max_orang}} Orang sesuai anggaran nu aya. <br> Ayeuna nembe aya nu Nambut {{$cek_pengeluaran_pinjaman}} Orang, Masih aya sisa jatah {{$data_anggaran_max_pinjaman->max_orang - $cek_pengeluaran_pinjaman }} Orang deui</span>
                                 </form>
                                 @else
                                 <!-- Form Anggota -->
                                 @if($cek_pengajuan >= 1)

                                 <body class="justify-content-center">
                                     <center>
                                         <h3><b> NUJU DI PROSES...</b></h3>
                                         <h3>Sampurasun dulur kabeh !</h3>
                                         <img src="https://c.tenor.com/Z8ezUHZzcLoAAAAC/love.gif" alt="" width="50%">
                                         <h3>Pengajuan pinjaman nuju di proses </h3>
                                         <h5>Harappp di antos nya sampe proses di setujui</h5>
                                     </center>
                                 </body>
                                 @elseif($cek_pengeluaran_pinjaman_user >= 1)

                                 <body class="justify-content-center">
                                     <center>
                                         <h3><b> YAHHH TEU ACAN TIASA NGAJUKEUN DEUI...</b></h3>
                                         <h3>Sampurasun dulur kabeh !</h3>
                                         <img src="https://c.tenor.com/Z8ezUHZzcLoAAAAC/love.gif" alt="" width="50%">
                                         <h3>Pinjaman masih teu acan lunas </h3>
                                         <h5>Pami misalkeun bade ngajukeun deui harap lunasi heula
                                         </h5>
                                     </center>
                                 </body>
                                 @elseif($cek_pengeluaran_pinjaman >= $data_anggaran_max_pinjaman->max_orang)

                                 <body class="justify-content-center">
                                     <center>
                                         <h3><b> YAHHH PUNTEN PISAN...</b></h3>
                                         <h3>Sampurasun dulur kabeh !</h3>
                                         <img src="https://c.tenor.com/Z8ezUHZzcLoAAAAC/love.gif" alt="" width="50%">
                                         <h3>Pinjaman atos full maxsimal {{$data_anggaran_max_pinjaman->max_orang}} Orang</h3>
                                         <h5>Pami misalkeun bade ngajukeun deui ngantosan salah saorang LUNAS</h5>
                                     </center>
                                 </body>
                                 @elseif($cek_total_pinjaman <= $data_anggaran_max_pinjaman->nominal_max_anggaran)

                                     <body class="justify-content-center">
                                         <center>
                                             <h3><b> YAHHH SALDO CAN CUKUP...</b></h3>
                                             <h3>Sampurasun dulur kabeh !</h3>
                                             <img src="https://c.tenor.com/Z8ezUHZzcLoAAAAC/love.gif" alt="" width="50%">
                                             <h3>Saldo / Anggaran Pinjaman masih kurang, saldo ayeuna nembe {{ "Rp " . number_format($cek_total_pinjaman,2,',','.') }}</h3>
                                             <h5>Pami misalkeun atos lebih ti nominal nu di tentukeun nembe tiasa </h5>
                                         </center>
                                     </body>
                                     @else
                                     @include('pengajuan.form_pinjam')
                                     @endif

                                     @endif

                             </div>
                             <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                 {!!$program->deskripsi!!}
                             </div>

                         </div>
                     </div>
                     <!-- /.card -->
                 </div>
             </div>

             <div class="col-12 col-sm-6">
                 <div class="card card-primary card-tabs">
                     <div class="card-header p-0 pt-1">
                         <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                             <li class="nav-item">
                                 <a class="nav-link active" id="custom-tabs-one-pinjaman-tab" data-toggle="pill" href="#custom-tabs-one-pinjaman" role="tab" aria-controls="custom-tabs-one-pinjaman" aria-selected="true">pinjaman"</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link " id="custom-tabs-one-pengajuan-tab" data-toggle="pill" href="#custom-tabs-one-pengajuan" role="tab" aria-controls="custom-tabs-one-pengajuan" aria-selected="false">pengajuan</a>
                             </li>

                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="tab-content" id="custom-tabs-one-tabContent">

                             <div class="tab-pane fade show active" id="custom-tabs-one-pinjaman" role="tabpanel" aria-labelledby="custom-tabs-one-pinjaman-tab">
                                 <table id="example1" class="table table-bordered table-striped table-responsive">
                                     <thead>
                                         <tr class="bg-light">
                                             <th>No.</th>
                                             <th>Ket.</th>
                                             <th>Tanggal</th>
                                             <th>Jumlah</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php

                                            use Illuminate\Support\Facades\DB;

                                            $no = 0;
                                            ?>
                                         @php
                                         $total = 0;
                                         @endphp
                                         @foreach($data_pengeluaran_pinjaman as $data)
                                         <?php $no++;
                                            $status2 = DB::table('pengeluarans')->find($data->id);
                                            ?>
                                         <tr>
                                             <td>{{$no}}</td>
                                             <td>
                                                 <a href="{{Route('pinjaman.show',Crypt::encrypt($data->id))}}" class="">
                                                     @if ( $status2->status == 'Lunas')
                                                     <i class="btn btn-success "> LUNAS </i>
                                                     @elseif ( $status2->status == 'Nunggak')
                                                     <i class=" btn btn-warning "> Bayar </i>
                                                     @endif
                                                     </i></a>
                                             </td>
                                             <td>{{$data->tanggal}}</td>
                                             <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>

                                         </tr>

                                         @php
                                         $total += $data->jumlah;
                                         @endphp
                                         @endforeach
                                     </tbody>
                                 </table>
                                 <!-- /.table-body -->
                             </div>
                             <div class="tab-pane fade show" id="custom-tabs-one-pengajuan" role="tabpanel" aria-labelledby="custom-tabs-one-pengajuan-tab">
                                 <table id="example" class="table table-bordered table-striped table-responsive">
                                     <thead>
                                         <tr class="bg-light">
                                             <th>No.</th>
                                             <th>Nama</th>
                                             <th>Proses</th>
                                             <th>Tanggal</th>
                                             <th>Jumlah</th>
                                             <th>Hapus</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $no = 0;
                                            ?>
                                         @php
                                         $total = 0;
                                         @endphp
                                         @foreach($cek_pengajuan_proses as $data)
                                         <?php $no++;
                                            $status2 = DB::table('pengeluarans')->find($data->id);
                                            ?>
                                         <tr>
                                             <td>{{$no}}</td>
                                             <td>{{$data->kategori}}</td>
                                             <td>
                                                 <a href="{{Route('pengajuan.show',Crypt::encrypt($data->id))}} " class="">
                                                     @if ( $data->status == 'Proses')
                                                     <i class="btn btn-success "> {{ $data->status}} </i>
                                                     @else
                                                     <i class=" btn btn-warning "> {{ $data->status}} Sementara </i>
                                                     @endif
                                                     </i></a>
                                             </td>
                                             <td>{{$data->tanggal}}</td>
                                             <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>
                                             <td>
                                                 <form action="{{route('pengajuan.destroy',Crypt::encrypt($data->id))}}" method="POST">
                                                     @csrf
                                                     @method('delete')
                                                     <button class="btn btn-link btn-sm mt-2"><i class="nav-icon fas fa-trash-alt" onclick="return confirm('Leres bade ngahapus data anu namina   ?')"></i> </button>
                                                 </form>
                                             </td>
                                         </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                                 <!-- /.table-body -->
                             </div>

                         </div>
                     </div>
                     <!-- /.card -->
                 </div>
             </div>
         </div>
         <!-- /.row -->
         <div class="card">
             <div class="card card-primary card-tabs">
                 <div class="card-header p-0 pt-1">
                     <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                         <li class="nav-item">
                             <a class="nav-link active" id="custom-tabs-one-lain-tab" data-toggle="pill" href="#custom-tabs-one-lain" role="tab" aria-controls="custom-tabs-one-lain" aria-selected="true">Lain"</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link " id="custom-tabs-one-darurat-tab" data-toggle="pill" href="#custom-tabs-one-darurat" role="tab" aria-controls="custom-tabs-one-darurat" aria-selected="false">Darurat</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link " id="custom-tabs-one-usaha-tab" data-toggle="pill" href="#custom-tabs-one-usaha" role="tab" aria-controls="custom-tabs-one-usaha" aria-selected="false">Usaha</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link " id="custom-tabs-one-amal-tab" data-toggle="pill" href="#custom-tabs-one-amal" role="tab" aria-controls="custom-tabs-one-amal" aria-selected="false">Amal</a>
                         </li>
                         @if(Auth::user()->role == "Admin" || Auth::user()->role == "Sekertaris" || Auth::user()->role == "Bendahara" || Auth::user()->role == "Ketua" || Auth::user()->role == "Penasehat")
                         <li class="nav-item">
                             <a class="nav-link" id="custom-tabs-one-pinjam-tab" data-toggle="pill" href="#custom-tabs-one-pinjam" role="tab" aria-controls="custom-tabs-one-pinjam" aria-selected="false">Pinjam</a>
                         </li>

                         @endif
                     </ul>
                 </div>
                 <div class="card-body">
                     <div class="tab-content" id="custom-tabs-one-tabContent">

                         <div class="tab-pane fade show active" id="custom-tabs-one-lain" role="tabpanel" aria-labelledby="custom-tabs-one-lain-tab">
                             <table id="table1" class="table table-bordered table-striped table-responsive">
                                 @include('pengeluaran.table.dana_lain')
                             </table>
                             <!-- /.table-body -->
                         </div>
                         <div class="tab-pane fade show" id="custom-tabs-one-darurat" role="tabpanel" aria-labelledby="custom-tabs-one-darurat-tab">
                             <table id="table2" class="table table-bordered table-striped table-responsive">
                                 @include('pengeluaran.table.dana_darurat')
                             </table>
                             <!-- /.table-body -->
                         </div>
                         <div class="tab-pane fade show" id="custom-tabs-one-usaha" role="tabpanel" aria-labelledby="custom-tabs-one-usaha-tab">
                             <table id="table3" class="table table-bordered table-striped table-responsive">
                                 @include('pengeluaran.table.dana_usaha')
                             </table>
                             <!-- /.table-body -->
                         </div>
                         <div class="tab-pane fade show" id="custom-tabs-one-amal" role="tabpanel" aria-labelledby="custom-tabs-one-amal-tab">
                             <table id="table4" class="table table-bordered table-striped table-responsive">
                                 @include('pengeluaran.table.dana_amal')
                             </table>
                             <!-- /.table-body -->
                         </div>
                         <div class="tab-pane fade" id="custom-tabs-one-pinjam" role="tabpanel" aria-labelledby="custom-tabs-one-pinjam-tab">
                             <table id="table5" class="table table-bordered table-striped table-responsive">
                                 @include('pengeluaran.table.dana_pinjam')
                             </table>
                             <!-- /.table-body -->
                         </div>
                     </div>
                 </div>
                 <!-- /.card -->
             </div>
         </div>
     </div><!--/. container-fluid -->
 </section>
 @endsection
 @section('script')
 <script>
     $("#pinja").addClass("active");
 </script>
 @endsection