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
                                    <img src="{{asset($data_keluarga->foto)}}" alt="" width="70%" class="brand-image img-circle elevation-3 " style="display:block; margin:auto">
                                    @if($data_keluarga->id == Auth::user()->keluarga_id)
                                    <a href="{{route('keluarga.edit',Crypt::encrypt($data_keluarga->id))}}" class="btn btn-link btn-block btn-light"> Edit Profile</a>
                                    @endif
                                    <tr>
                                        <th style="width:50%">Nama</th>
                                        <td>{{ $data_keluarga->nama}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">NIK</th>
                                        <td>{{ $data_keluarga->nik}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Jenis Kelamin</th>
                                        <td>{{ $data_keluarga->jenis_kelamin}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Tempat,Tanggal Lahir</th>
                                        <td>{{ $data_keluarga->tempat_lahir}},{{ $data_keluarga->tanggal_lahir}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Alamat</th>
                                        <td>{{ $data_keluarga->alamat}}</td>
                                    </tr>
                                    <tr>
                                        <th>No Handphone</th>
                                        <td>{{ $data_keluarga->no_hp}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{$data_keluarga->pekerjaan}}</td>
                                    </tr>
                                    <tr>
                                        <th>hubungan</th>
                                        <td>{{$data_keluarga->hubungan}} dari {{$data_keluarga->nama_hubungan}} </td>
                                    </tr>
                                    <tr>
                                        <th>Anak Ke</th>
                                        <td>{{$data_keluarga->anak_ke}}</td>
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
@endsection
@section('script')
<script>
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataKeluarga").addClass("active");
</script>
@endsection