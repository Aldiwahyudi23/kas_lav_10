 @extends('template.home')
 @section('content')
 <section class="content">
     <div class="container-fluid">
         <!-- ./row -->
         <div class="row">
             <div class="col-12 col-sm-6">
                 <div class="card card-primary card-outline card-outline-tabs">
                     <div class="card-body">
                         <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
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
                                 <h5>{{"Rp" . number_format($total_dana_kas - $total_pengeluaran_lain,2,',','.')}}</h5>
                             </ul>
                             <ul class="products-list product-list-in-card pl-1 pr-1">
                                 <a href="{{Route('table_pengeluaran_detail',Crypt::encrypt(6))}}" class="product-title">Jumlah Dana Kas nu tos ka angge </a>
                                 <h7>{{ "Rp " . number_format($total_pengeluaran_lain + $total_pengeluaran_usaha + $total_pengeluaran_acara  ,2,',','.') }}</h7>
                                 <hr>
                             </ul>
                             <ul class="products-list product-list-in-card pl-1 pr-1">
                                 <a href="{{Route('anggaran.show',Crypt::encrypt(3))}}">Jumlah Dana Pinjam</a>
                                 <h5>{{"Rp" . number_format($total_dana_pinjam -  $total_pengeluaran_pinjaman,2,',','.')}}</h5>
                             </ul>
                             <ul class="products-list product-list-in-card pl-1 pr-1">
                                 <a href="{{Route('table_pengeluaran_detail_pinjaman',Crypt::encrypt(3))}}" class="product-title">Uang nu di pinjem</a>
                                 <h7>{{"Rp" . number_format($total_pengeluaran_pinjaman,2,',','.')}}</h7>
                                 <hr />
                             </ul>
                         </div>
                     </div>
                     <!-- /.card -->
                 </div>
             </div>

             <div class="col-12 col-sm-6">
                 <div class="card card-primary card-tabs">
                     <div class="card-body">
                         <table id="example1" class="table table-bordered table-striped table-responsive">
                             <thead>
                                 <tr>
                                     <th>No</th>
                                     <th>Anggaran</th>
                                     <th>Nama / Di Input</th>
                                     <th>Nominal Kas</th>
                                     <th>iD Keluarga</th>
                                     <th>Di Setujui Oleh</th>
                                     <th>Bulan Pembayaran</th>
                                     <th>Pembayaran</th>
                                     <th>Status</th>
                                     <th>Keterangan</th>
                                     <th>Laporan Sekertaris</th>
                                     <th>Laporan Bendahara</th>
                                     <th>Laporan Ketua</th>
                                     <th>Tanggal Pengajuan</th>
                                     <th>Tanggal di Update</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php

                                    use App\Models\Keluarga;

                                    $no = 0;
                                    ?>
                                 @php
                                 $total = 0;
                                 @endphp
                                 @foreach($data_pengeluaran as $data)
                                 <?php $no++;
                                    $status2 = DB::table('pengeluarans')->find($data->id);
                                    $keluarga = Keluarga::Find($data->keluarga_id);
                                    ?>
                                 <tr>
                                     <td>{{$no}}</td>
                                     <td>{{$data->anggaran->nama_anggaran}}</td>
                                     <td>{{$data->anggota->name}}</td>
                                     <td>{{$data->jumlah}}</td>

                                     @if ($data->anggota_id == $data->keluarga_id)
                                     <td></td>
                                     @else
                                     <td>{{$data->keluarga_id}}</td>
                                     @endif
                                     <td> {{$data->pengurus->name}}</td>

                                     <td>{{$data->tanggal}}</td>
                                     <td>{{$data->pembayaran}}</td>
                                     <td>
                                         @if ($data->anggaran->nama_anggaran == "Pinjaman")
                                         <a href="{{Route('pinjaman.show',Crypt::encrypt($data->id))}}" class="">
                                             @if ( $status2->status == 'Lunas')
                                             <i class="btn btn-success "> LUNAS </i>
                                             @elseif ( $status2->status == 'Nunggak')
                                             <i class=" btn btn-warning "> Bayar </i>
                                             @endif
                                         </a>
                                         @else
                                         <i class=" btn btn-success "> {{$data->status}} </i>
                                         @endif
                                     </td>
                                     <td>{!!$data->alasan!!}</td>
                                     <td>{!!$data->sekertaris!!}</td>
                                     <td>{!!$data->bendahara!!}</td>
                                     <td>{!!$data->ketua!!}</td>
                                     <td>{{$data->created_at}}</td>
                                     <td>{{$data->updated_at}}</td>
                                     <td>
                                         <form action="{{route('pengeluaran.destroy',Crypt::encrypt($data->id))}}" method="POST">
                                             @csrf
                                             @method('delete')
                                             <a href="{{route('pengeluaran.show',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-book"></i></a>
                                             @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Sekertaris')
                                             <a href="{{route('pengeluaran.edit',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-pencil-alt"></i></a>
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