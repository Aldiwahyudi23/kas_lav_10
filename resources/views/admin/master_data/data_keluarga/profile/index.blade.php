@extends('template.home')

@section('content')

<div class="col-12">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">

                <a href="{{ asset(Auth::user()->foto) }}" data-toggle="lightbox" data-title="Foto Profile {{ Auth::user()->name }}" data-gallery="gallery" data-footer=' <form action="{{ Route('anggota.update.foto', Crypt::encrypt(Auth::user()->id)) }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}<input type="file" class="form-control"  name=" foto" id="foto"> <input type="hidden" class="form-control" name=" user" id="user" value="{{$data_keluarga->keluarga_id}}"> <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-file-upload"></i> </button></form>'>


                    <img src="{{ asset( Auth::user()->foto) }}" width="130px" class="profile-user-img img-fluid img-circle" alt="User profile picture">
                </a>

            </div>


            <h3 class="profile-username text-center">{{ $data_keluarga->nama }}</h3>
            <h5 class="profile-username text-center">( {{ Auth::user()->name }} )</h5>
            <!-- <p class="text-muted text-center">{{ Auth::user()->role }}</p> -->
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>No INduk</b> <a class="float-right">{{ $data_keluarga->nik }}</a>
                </li>
            </ul>
            <a href="{{route('profile.edit',Crypt::encrypt($data_keluarga->id))}}" class="btn btn-primary btn-block"><b>Edit Profile</b></a>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<div class="col-12">
    <!-- Profile Image -->
    <form action="{{ Route('anggota.update.foto', Crypt::encrypt($data_keluarga->id)) }}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <label for="foto">Ganti Foto Profile</label>
        <input type="file" class="form-control" name=" foto" id="foto"> <input type="hidden" class="form-control" name=" user" id="user" value="{{$data_keluarga->keluarga_id}}">

        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach($foto as $data)
                    <div class="product-img">
                        <a href="{{ asset( $data->foto) }}" data-toggle="lightbox" data-title="Foto {{ Auth::user()->name }}" data-gallery="gallery">

                            <img src="{{ asset( $data->foto) }}" alt="Product Image" width="65px" height="65px" alt="Saya" class="brand-image img-circle elevation-3">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-file-upload"></i> Upload</button>
    </form>
</div>
<!-- /.card -->
</div>
<div class="col-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Profil</h3>
        </div>
        <div class="table-responsive">
            <table class="table">
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
                    <th>Pekerjaan</th>
                    <td>{{$data_keluarga->pekerjaan}}</td>
                </tr>
                <tr>
                    <th>hubungan</th>
                    <td><a href="{{Route('keluarga.detail',Crypt::encrypt($data_keluarga->keluarga_id))}}">{{$data_keluarga->hubungan}} dari {{$data_keluarga->keluarga->nama}} </a> </td>
                </tr>
                <tr>
                    <th>Anak Ke</th>
                    <td>{{$data_keluarga->anak_ke}}</td>
                </tr>
                <tr>
                    <th>
                        <a href="{{Route('keluarga.detail',Crypt::encrypt($data_keluarga->id))}}">Klik & Cek Kanggo ningal Data Keluarga anjeun</a>
                    </th>
                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<div class="col-12">
    <div class="row">
        <div class="col-6 table-responsiv ">
            <!-- About Me Box -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Akun</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="far fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <hr>

                    <strong><i class="fas fa-phone mr-1"></i> No Telepon</strong>
                    <p class="text-muted">{{ $data_keluarga->no_hp}}</p>
                    <hr>
                    <strong><i class="fas fa-setting mr-1"></i> Program</strong>
                    <p class="text-muted">{{ Auth::user()->program1 }}</p> <br>
                    <p class="text-muted">{{ Auth::user()->program2 }}</p> <br>
                    <p class="text-muted">{{ Auth::user()->program3 }}</p> <br>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-6 table-responsive">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan Akun</h3>
                </div>
                <div class="card-body">
                    <table class="table" style="margin-top: -21px;">
                        <tr>
                            <td width="50"><i class="nav-icon fas fa-envelope"></i></td>
                            <td> <a href="{{ route('pengaturan.email') }}">Ubah Email<a></td>
                        </tr>
                        <tr>
                            <td width="50"><i class="nav-icon fas fa-key"></i></td>
                            <td><a href="{{ route('pengaturan.password') }}">Ubah Password</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section(' script') <script>
    $("#profile").addClass("active");
</script>
@endsection