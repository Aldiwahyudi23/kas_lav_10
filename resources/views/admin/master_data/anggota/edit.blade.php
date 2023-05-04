@extends('template.home')

@section('content')
<section class="content card col-12" style="padding: 10px 10px 10px 10px ">
    <div class="box">
        <h4><i class="nav-icon fas fa-user my-1 btn-sm-1"></i> Data User</h4>
        <hr>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <h6 class="card-header bg-light p-3"><i class="fas fa-user-plus"></i> TAMBAH DATA USER</h6>
                            <div class="card-body">
                                <form action="{{Route('anggota.update',Crypt::encrypt($data_anggota->id))}}" method="POST" enctype="multipart/form-data">
                                    @method('Put')
                                    {{csrf_field()}}
                                    <div class="card-body table-responsive">
                                        <div class="row">
                                            <input type="hidden">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="username">User Name</label>
                                                    <input type="text" id="username" name="username" value="{{ old('username', $data_anggota->name) }}" placeholder="Nama inisial" class="form-control @error('username') is-invalid @enderror">
                                                    @error('username')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="text" id="email" name="email" value="{{ old('email', $data_anggota->email) }}" placeholder="contoh@gmail.com" class="form-control @error('email') is-invalid @enderror">
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="no_hp">Nomor Telpon/HP</label>
                                                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $data_anggota->no_hp) }}" placeholder="+62 xxx xxxx xxxx" class="form-control @error('no_hp') is-invalid @enderror">
                                                    @error('no_hp')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="anggota_kel_id">Anggota Keluarga</label>
                                                    <select id="anggota_kel_id" name="anggota_kel_id" class="select2bs4 form-control @error('anggota_kel_id') is-invalid @enderror">
                                                        @if (old('anggota_kel_id',$data_anggota->keluarga_id) == true)
                                                        <option value="{{old('anggota_kel_id',$data_anggota->keluarga_id)}}">{{old('anggota_kel_id',$data_anggota->keluarga_id)}}</option>
                                                        @endif
                                                        <option value="">-- Pilih Nama --</option>
                                                        @foreach ($data_keluarga as $data)
                                                        <option value="{{$data->id}}"> {{$data->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="role_id">Role</label>
                                                    <select id="role_id" name="role_id" class="select2bs4 form-control @error('role_id') is-invalid @enderror">
                                                        @if (old('role_id', $data_anggota->role) == true)
                                                        <option value="{{old('role_id', $data_anggota->role)}}">{{old('role_id',$data_anggota->role)}}</option>
                                                        @endif
                                                        <option value="">-- Pilih Role --</option>
                                                        @foreach ($data_role as $data)
                                                        <option value="{{$data->nama_role}}"> {{$data->nama_role}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" name="password" value="{{ old('password')}}" placeholder="xxxxxxxx" class="form-control @error('password') is-invalid @enderror">
                                            <input type="hidden" id="is_active" name="is_active" value="{{$data_anggota->is_active}}">
                                            @error('password')<div class="invalid-feedback"><strong>{{ $message }}</strong></div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="account-company">Foto Profile</label> <br>
                                            <img src="{{ asset($data_anggota->foto) }}" width="130px" class="profile-user-img img-fluid img-circle" alt="User profile picture">
                                            <input type="file" class="form-control" value="" name="foto" id="foto">
                                            <span class="text-danger" style="font-size: 10px">Kosongkan jika tidak ingin mengubah.</span>
                                        </div>
                                    </div>

                                    <hr>
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Daftar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active btn-sm" href="#setor" data-toggle="tab"><i></i> Data anggota</a></li>
                                    <li class="nav-item"><a class="nav-link btn-sm" href="#anggota" data-toggle="tab"><i></i> Deskripsi</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- Awal data pemasukan -->
                                    <div class="active tab-pane" id="setor">
                                        <div class="row">
                                            <div class="row table-responsive">
                                                <div class="col-12">
                                                    <table class="table table-hover table-head-fixed" id='tabelAgendaMasuk'>
                                                        <thead>
                                                            <tr class="bg-light">
                                                                <th>No.</th>
                                                                <th>anggota</th>
                                                                <th>program</th>
                                                                <th>Role</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 0; ?>
                                                            @foreach($data_anggotas as $data)
                                                            <?php $no++; ?>
                                                            <tr>
                                                                <td>{{$no}}</td>
                                                                <td>{{$data->name}}</td>
                                                                <td>{{$data->program1}} <br> {{$data->program2}} <br> {{$data->program3}}</td>
                                                                <td>{{$data->role}}</td>
                                                                <td>
                                                                    <form action="{{route('anggota.destroy',Crypt::encrypt($data->id))}}" method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <a href="{{route('anggota.show',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-book"></i></a>
                                                                        <a href="{{route('anggota.edit',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-pencil-alt"></i></a>
                                                                        @if (auth()->user()->role == 'Admin')
                                                                        <button class="btn btn-link btn-sm mt-2"><i class="nav-icon fas fa-trash-alt" onclick="return confirm('Leres bade ngahapus data anu namina {{$data->nama}}  ?')"></i> </button>
                                                                        @endif
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir togle data pemasukan -->

                                    <!-- awal data anggota -->
                                    <div class="tab-pane" id="anggota">
                                        <div class="row">
                                            <div class="row table-responsive">
                                                <div class="col-12">
                                                    <table class="table table-hover table-head-fixed" id='tabelAgendaKeluar'>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div><!-- /.container-fluid -->
        </section>
    </div>
</section>

@endsection
@section('script')
<script>
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataUser").addClass("active");
</script>
@endsection