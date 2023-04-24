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
                                 <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Form Setor Tunai</a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="tab-content" id="custom-tabs-four-tabContent">
                             <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <!-- Form Admin -->
                                 @if(Auth::user()->role == "Admin" | Auth::user()->role == "Sekertaris")
                                 @if($uang_blum_diTF == 0)

                                 <body class="justify-content-center">
                                     <center>
                                         <h3><b> HALLOOOO.....</b></h3>
                                         <h3>Sehat ?</h3>
                                         <img src="https://c.tenor.com/Z8ezUHZzcLoAAAAC/love.gif" alt="" width="50%">
                                         <h3>Teu acan aya artos nu kedah di setor keun ... aman </h3>
                                         <h5>Harappp di antos dicek ka bendahara sareng sekertaris </h5>
                                     </center>
                                 </body>
                                 @else
                                 <center>
                                     <img src="https://media.tenor.com/LAkobF0eiDwAAAAC/assalamu-alaikum-salam.gif" alt="" width="50%">
                                     <h5 class="text-bold card-header bg-light p-0">SETOR TUNAI</h5>
                                 </center>


                                 <div class="">
                                     <form id="basic-form" action="{{Route('pemasukan.store')}}" method="POST" enctype="multipart/form-data" novalidate>
                                         {{csrf_field()}}

                                         <div class="form-group row" id="noId"></div>
                                         <div class="form-group row">
                                             <label for="jumlah">Nominal</label>
                                             <input type="hidden" name="anggota_id" id="anggota_id" value="{{Auth::user()->id}}">
                                             <input type="hidden" name="pengaju_id" id="pengaju_id" value="{{Auth::user()->id}}">
                                             <input type="hidden" id="tanggal" name="tanggal" value="{{$data1 }}">
                                             <input type="hidden" name="kategori" id="kategori" value="Setor_Tunai">
                                             <input type="hidden" name="pembayaran" id="pembayaran" value="Transfer">
                                             <input type="text" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="Cont : 50000    jangan pake titik ataupun koma" class="form-control col-12 @error('jumlah') is-invalid @enderror">
                                             <span class="text-danger" style="font-size: 14px">sia Jumlah nu teu acan di setor keun <b>{{ "Rp " . number_format($uang_blum_diTF,2,',','.') }}</b>.</span>
                                             @error('jumlah')
                                             <div class="invalid-feedback">
                                                 <strong>{{ $message }}</strong>
                                             </div>
                                             @enderror
                                         </div>
                                         <div class="form-group row">
                                             <label for="account-company">Bukti Transfer</label>
                                             <input type="file" class="form-control" name="foto" id="foto" required />
                                             <span class="text-danger" style="font-size: 14px">Harap isi file tanda bukti transferan (gambar/ SC).</span>
                                         </div>

                                         <div class="form-group">
                                             <label for="keterangan">Keterangan</label>
                                             <textarea name="keterangan" class="textarea form-control bg-light @error('keterangan') is-invalid @enderror" id="summernote" rows="6" value="{{ old('keterangan') }}"></textarea>
                                             @error('keterangan')
                                             <div class="invalid-feedback">
                                                 <strong>{{ $message }}</strong>
                                             </div>
                                             @enderror
                                         </div>
                                         <hr>
                                         <button onclick="tombol_setor()" id="myBtn_setor" type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> YUUU BAYAR</button>
                                         <div id="tombol_proses"></div>
                                     </form>
                                 </div>
                                 @endif
                                 @else

                                 <body class="justify-content-center">
                                     <center>
                                         <h3><b> PUNTEN TEU GADUH AKSES</b></h3>
                                         <h3>Sampurasun dulur kabeh !</h3>
                                         <img src="https://media.tenor.com/LAkobF0eiDwAAAAC/assalamu-alaikum-salam.gif" alt="" width="50%">
                                         <h3>Hatur nuhun atos berpasrtisipasi kana uang kas </h3>
                                         <h5>Bissmillah jaya </h5>
                                     </center>
                                 </body>
                                 @endif

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
                                 <a class="nav-link active" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="true">Kas</a>
                             </li>
                             @if(Auth::user()->program2 == "Tabungan")
                             <li class="nav-item">
                                 <a class="nav-link " id="custom-tabs-one-tabungan-tab" data-toggle="pill" href="#custom-tabs-one-tabungan" role="tab" aria-controls="custom-tabs-one-tabungan" aria-selected="false">Tabungan</a>
                             </li>
                             @endif
                             @if(Auth::user()->role == "Admin" || Auth::user()->role == "Sekertaris" || Auth::user()->role == "Bendahara" || Auth::user()->role == "Ketua" || Auth::user()->role == "Ketua")
                             <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Semua</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Anggota</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Setor Tunai</a>
                             </li>
                             @endif
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="tab-content" id="custom-tabs-one-tabContent">
                             <div class="tab-pane fade " id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                 <table id="example1" class="table table-bordered table-striped table-responsive">
                                     <thead>
                                         <tr>
                                             <th>No</th>
                                             <th>Nama</th>
                                             <th>Nominal</th>
                                             <th>Bulan</th>
                                             <th>Aksi</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $no = 0; ?>
                                         @php
                                         $total = 0;
                                         @endphp
                                         @foreach($data_pemasukan_semua as $data)
                                         <?php $no++; ?>
                                         <tr>
                                             <td>{{$no}}</td>
                                             <td>{{$data->anggota->name}}</td>
                                             <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>
                                             <td>{{date('M-y',strtotime($data->tanggal)) }}</td>
                                             <td>
                                                 <form action="{{route('pemasukan.destroy',Crypt::encrypt($data->id))}}" method="POST">
                                                     @csrf
                                                     @method('delete')
                                                     <a href="{{route('pemasukan.show',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-book"></i></a>
                                                     @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Sekertaris')
                                                     <a href="{{route('pemasukan.edit',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-pencil-alt"></i></a>
                                                     @endif
                                                     @if (auth()->user()->role == 'Admin')
                                                     <button class="btn btn-link btn-sm mt-2"><i class="nav-icon fas fa-trash-alt" onclick="return confirm('Leres bade ngahapus data anu namina   ?')"></i> </button>
                                                     @endif
                                                 </form>
                                             </td>
                                         </tr>
                                         @endforeach
                                     </tbody>

                                 </table>
                                 <!-- /.table-body -->
                             </div>
                             <div class="tab-pane fade show active" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                 <table id="table1" class="table table-bordered table-striped table-responsive">

                                     @include('pemasukan.table.kas_user')
                                 </table>
                                 <!-- /.table-body -->
                             </div>
                             <div class="tab-pane fade show" id="custom-tabs-one-tabungan" role="tabpanel" aria-labelledby="custom-tabs-one-tabungan-tab">
                                 <table id="table3" class="table table-bordered table-striped table-responsive">
                                     @include('pemasukan.table.tabungan_user')
                                 </table>
                                 <!-- /.table-body -->
                             </div>
                             <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                 <table id="table4" class="table table-bordered table-striped table-responsive">
                                     @include('pemasukan.table.perAnggota')
                                 </table>
                                 <!-- /.table-body -->
                             </div>
                             <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                 <table id="table5" class="table table-bordered table-striped table-responsive">
                                     @include('pemasukan.table.setor_tunai')
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
     </div><!--/. container-fluid -->
 </section>
 @endsection
 @section('script')
 <script>
     $("#bayar").addClass("active");
 </script>
 @endsection