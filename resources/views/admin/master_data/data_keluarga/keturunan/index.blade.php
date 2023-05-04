@extends('template.home')

@section('content')



<section class="content card col-12" style="padding: 10px 10px 10px 10px ">
    <div class="box">
        <h4><i class="nav-icon fas fa-users my-1 btn-sm-1"></i> Data Anggota Keluarga</h4>
        <hr>
        <section class="content">
            <div class="container-fluid">
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
                                        <tr>
                                            <th style="width:50%">Nama</th>
                                            <td>{{ $data_anggota->nama}} ({{$umurr->y}})</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Jenis Kelamin</th>
                                            <td>{{ $data_anggota->jenis_kelamin}}</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Alamat</th>
                                            <td>{{ $data_anggota->alamat}}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{$data_anggota->pekerjaan}}</td>
                                        </tr>
                                        <tr>
                                            <th>hubungan</th>

                                            <td><a href="{{Route('keturunan_detail',Crypt::encrypt($data_anggota->keluarga_id))}}">{{$data_anggota->hubungan}} dari {{$data_anggota->keluarga->nama}} </a> </td>

                                        </tr>
                                        <tr>
                                            <th>Anak Ke</th>
                                            <td>{{$data_anggota->anak_ke}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="http://wa.me/62{{$data_anggota->no_hp}}" class="btn btn-sm bg-teal">
                                            <i class="fas fa-comments">Chat</i>
                                        </a>
                                        <a href="{{route('keluarga.show',Crypt::encrypt($data_anggota->id))}}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> Lihat Profile
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="card-body p-0">
                                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                                    @foreach($foto as $data)
                                    <div class="product-img">
                                        <a href="{{ asset( $data->foto) }}" data-toggle="lightbox" data-title="Foto {{ Auth::user()->name }}" data-gallery="gallery">
                                            <img src="{{ asset( $data->foto) }}" alt="Product Image" width="65px" height="65px" alt="Saya" class="brand-image img-circle elevation-3">
                                        </a>
                                        <center>
                                            <span class="users-list-date">{{date("Y-M",strtotime($data->created_at))}}</span>
                                        </center>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
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

                <center>
                    <h3>Cek Data Keluarga dari <br> {{$data_anggota->nama}}</h3>
                </center>
                <div class="row">

                    @foreach($data_keluarga_hubungan as $data)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column" id="myMenu">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header">
                                <h5 class="card-title"> <b>{{$data->nama}}</b> {{$data->hubungan}} ke {{$data->anak_ke}} dari {{$data->keluarga->nama}}
                                </h5>

                                <div class="card-tools">
                                    <button type="button" class="  btn btn-tool " data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <?php
                            $lahir    = new DateTime($data->tanggal_lahir);
                            $today        = new DateTime();
                            $umur = $today->diff($lahir);
                            ?>
                            <div class="card-body pt-0" id="card">
                                <div class="row">
                                    <div class="col-7">
                                        <a href="{{Route('keturunan_detail',Crypt::encrypt($data->id))}}" class="">
                                            <h2 class="lead" id="nama"><b>{{$data->nama}} </b>
                                                ({{ $umur->y }})
                                            </h2>
                                            <p class="text-muted text-sm"><b>Status: </b> {{$data->pekerjaan}} </p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: {{$data->alamat}}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{$data->no_hp}}</li>
                                            </ul>
                                        </a>
                                    </div>
                                    <div class="col-5 text-center">
                                        <a href="{{ asset($data->foto) }}" data-toggle="lightbox" data-title="Foto {{ $data->name }}" data-gallery="gallery">
                                            <img src="{{ asset($data->foto) }}" alt="user-avatar" class="img-circle img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="http://wa.me/62{{$data->no_hp}}" class="btn btn-sm bg-teal">
                                        <i class="fas fa-comments"> Chat</i>
                                    </a>
                                    <a href="{{route('keluarga.show',Crypt::encrypt($data->id))}}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-user"></i> Lihat Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div><!-- /.container-fluid -->
        </section>
    </div>
</section>


@endsection