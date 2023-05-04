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
                                 <a href="" class="product-title">Jumlah Pemasukan Kas</a>
                                 <h5>{{ "Rp " . number_format($total_pemasukan,2,',','.') }}</h5>
                                 <p>Jumlah sadayana artos pemasukan uang kas nu terkumpul ti awal sareng dugi ayeuna</p>
                                 <hr>
                             </ul>

                             <ul class="products-list product-list-in-card pl-1 pr-1">
                                 <a href="" class="product-title">Jumlah Pengeluaran Kas</a>
                                 <h5>{{ "Rp " . number_format( $total_pengeluaran,2,',','.') }}</h5>
                                 <p> Jumlah sadayana pengluaran sesuai data anggaran, kecuali data pinjaman tidak termasuk pengluaran.</p>
                                 <hr>
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
                                     <th>Kategori</th>
                                     <th>Nama</th>
                                     <th>Nominal Kas</th>
                                     <th>Bulan Pembayaran</th>
                                     <th>Pembayaran</th>
                                     <th>Keterangan</th>
                                     <th>Disetujui Oleh</th>
                                     <th>Tanggal Pengajuan</th>
                                     <th>Tanggal di Setujui</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 0; ?>
                                 @php
                                 $total = 0;
                                 @endphp
                                 @foreach($data_pemasukan as $data)
                                 <?php $no++; ?>
                                 <tr>
                                     <td>{{$no}}</td>
                                     <td>{{$data->kategori}}</td>
                                     <td>{{$data->anggota->name}}</td>
                                     <td>{{$data->jumlah}}</td>
                                     <td>{{date('M-y',strtotime($data->tanggal)) }}</td>
                                     <td>{{$data->pembayaran}}</td>
                                     <td>{!!$data->keterangan!!}</td>
                                     <td>{{$data->pengurus->name}}</td>
                                     <td>{{$data->tanggal}}</td>
                                     <td>{{$data->created_at}}</td>
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