@extends('template.home')

@section('content')
<section class="content card col-12" style="padding: 10px 10px 10px 10px ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-user"></i> Detail Data Anggota
                            </h4>
                        </div>
                    </div>
                    <!-- info row -->
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-12">
                            <p class="lead">Catatan :</p>
                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                - Data sesuai anu atos di nput sebelumna <br>
                                - Konfirmasi, emangna leres data ieu sareng aslina
                            </p>

                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <p class="lead">Rekap data Anggota :</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <a href="{{asset($data_anggota->foto)}}" data-toggle="lightbox" data-title="Foto {{ $data_anggota->nama}}" data-gallery="gallery">

                                        <img src="{{asset($data_anggota->foto)}}" alt="" width="70%" class="brand-image img-circle elevation-3 " style="display:block; margin:auto">
                                    </a>

                                    <a href="{{route('keluarga.edit',Crypt::encrypt($data_anggota->id))}}" class="btn btn-link btn-block btn-light"> Edit Profile</a>

                                    <tr>
                                        <th style="width:50%">Nama</th>
                                        <td>{{ $data_anggota->nama}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">NIK</th>
                                        <td>{{ $data_anggota->nik}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Jenis Kelamin</th>
                                        <td>{{ $data_anggota->jenis_kelamin}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Tempat,Tanggal Lahir</th>
                                        <td>{{ $data_anggota->tempat_lahir}},{{ $data_anggota->tanggal_lahir}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Alamat</th>
                                        <td>{{ $data_anggota->alamat}}</td>
                                    </tr>
                                    <tr>
                                        <th>No Handphone</th>
                                        <td>{{ $data_anggota->no_hp}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{$data_anggota->pekerjaan}}</td>
                                    </tr>
                                    <tr>
                                        <th>hubungan</th>

                                        <td>{{$data_anggota->hubungan}} dari {{$data_anggota->keluarga->nama}} </td>

                                    </tr>
                                    <tr>
                                        <th>Anak Ke</th>
                                        <td>{{$data_anggota->anak_ke}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <form action="/pengajuan/bayar/anggota/tambah" method="post">
                                @csrf
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content card col-12" style="padding: 10px 10px 10px 10px ">
    <div class="box">
        <h4><i class="nav-icon fas fa-users my-1 btn-sm-1"></i> Data Anggota Keluarga</h4>
        <a href="{{Route('keluarga.tambah',Crypt::encrypt($data_anggota->id))}}" class="btn btn-primary">Tambih Keluarga</a>
        <hr>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="row table-responsive">
                        <div class="col-12">
                            <table class="table table-hover table-head-fixed" id='example1'>
                                <thead>
                                    <tr class="bg-light">
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Status Kekeluargaan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0; ?>
                                    @foreach($data_keluarga_hubungan as $data)
                                    <?php $no++; ?>
                                    <tr>
                                        <td> <img src="{{asset($data->foto)}}" class="img-circle" alt="" width="50px"> </td>
                                        <td> <a href="{{Route('keluarga.detail',Crypt::encrypt($data->id))}}" class="">{{$data->nama}}</a></td>
                                        <td> <a href="{{route('keluarga.detail',Crypt::encrypt($data->id))}}" class=""> {{$data->hubungan}} {{$data->anak_ke}} Dari {{$data->keluarga->nama}} </a></td>
                                        <td>
                                            @if (auth()->user()->role == 'Admin')
                                            <form action="{{route('keluarga.destroy',Crypt::encrypt($data->id))}}" method="POST">
                                                @method('delete')
                                                {{csrf_field()}}
                                                <button class="btn btn-link fas fa-trash " onclick="return confirm('Leres bade ngahapus data anu namina {{$data->nama}}  ?')"><i class="nav-icon fas fa-trash "></i></button>
                                            </form>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

@endsection
@section('script')
<script>
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataKeluarga").addClass("active");
</script>
@endsection