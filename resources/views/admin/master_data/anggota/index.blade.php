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
                                <form action="{{Route('anggota.store')}}" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="card-body table-responsive">
                                        <div class="row">
                                            <input type="hidden">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="username">User Name</label>
                                                    <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Nama inisial" class="form-control @error('username') is-invalid @enderror">
                                                    @error('username')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" class="form-control @error('email') is-invalid @enderror">
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="no_hp">Nomor Telpon/HP</label>
                                                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="+62 xxx xxxx xxxx" class="form-control @error('no_hp') is-invalid @enderror">
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
                                                        @if (old('anggota_kel_id') == true)
                                                        <option value="{{old('anggota_kel_id')}}">{{old('nama')}}</option>
                                                        @endif
                                                        <option value="">-- Pilih Nama --</option>
                                                        @foreach ($data_keluarga as $data)
                                                        <option value="{{$data->id}}"> {{$data->nama}}</option>

                                                        @endforeach
                                                    </select>
                                                    @error('anggota_kel_id')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>


                                                <div class="form-group">
                                                    <label for="role_id">Role</label>
                                                    <select id="role_id" name="role_id" class="select2bs4 form-control @error('role_id') is-invalid @enderror">
                                                        @if (old('role_id') == true)
                                                        <option value="{{old('role_id')}}">{{old('role_id')}}</option>
                                                        @endif
                                                        <option value="">-- Pilih Role --</option>
                                                        @foreach ($data_role as $data)
                                                        <option value="{{$data->nama_role}}"> {{$data->nama_role}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" name="password" value="{{ old('password')}}" placeholder="xxxxxxxx" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                                            @error('password')<div class="invalid-feedback"><strong>{{ $message }}</strong></div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Confirmasi Password</label>
                                            <input type="password" id="password-confirm" name="password_confirmation" value="{{ old('password')}}" placeholder="xxxxxxxx" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                                            @error('password')<div class="invalid-feedback"><strong>{{ $message }}</strong></div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="is_active">Status</label>
                                            <select id="is_active" name="is_active" class="select2bs4 form-control @error('is_active') is-invalid @enderror">
                                                @if (old('is_active') == true)
                                                <option value="{{old('is_active')}}">{{old('nama_hubungan')}}</option>
                                                @endif
                                                <option value="">-- Aktifkan akun --</option>
                                                <option value="0"> Tidak Aktif</option>
                                                <option value="1"> Aktif</option>
                                            </select>
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
                                                    <table class="table table-hover table-head-fixed" id='example1'>
                                                        <thead>
                                                            <tr class="bg-light">
                                                                <th>No.</th>
                                                                <th>anggota</th>
                                                                <th>Role</th>
                                                                <th>Aksi</th>
                                                                <th>pass</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 0; ?>
                                                            @foreach($data_anggota as $data)
                                                            <?php $no++; ?>
                                                            <tr>
                                                                <td>{{$no}}</td>
                                                                <td>{{$data->name}}</td>
                                                                <td>{{$data->role}}</td>
                                                                <td>
                                                                    @if ($data->is_active == 1)
                                                                    <form action="{{route('is_active',$data->id)}}" method="POST">
                                                                        @csrf

                                                                        @if (auth()->user()->role == 'Admin')
                                                                        <input type="hidden" name="is_active" id="is_active" value="0">
                                                                        <button class="btn btn-link btn-sm mt-2"><i class="nav-icon fas fa-check" onclick="return confirm('Leres bade ngahapus data anu namina {{$data->nama}}  ?')"></i> Aktif </button>
                                                                        @endif
                                                                    </form>
                                                                    @else
                                                                    <form action="{{route('is_active',$data->id)}}" method="POST">
                                                                        @csrf

                                                                        @if (auth()->user()->role == 'Admin')
                                                                        <input type="hidden" name="is_active" id="is_active" value="1">
                                                                        <button class="btn btn-link btn-sm mt-2"><i class="nav-icon " onclick="return confirm('Leres bade ngahapus data anu namina {{$data->nama}}  ?')"></i> Tidak Aktif </button>
                                                                        @endif
                                                                    </form>
                                                                    @endif
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
                                                                <td><a href="{{ route('pengaturan.password') }}">Ubah Password</a></td>

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
    $(document).ready(function() {
        $('#anggota_kel_id').change(function() {
            var kel = $('#anggota_kel_id option:selected').val();
            if (kel == "Transfer") {
                $("#noId").html('<div class="form-group"><label for="account-company">Bukti Transfer</label><input type="file" class="form-control" name="foto" id="foto" required /><span class="text-danger" style="font-size: 10px">Harap kirim tanda bukti transferan.</span></div>');
            } else if (kel == "Siswa") {
                $("#noId").html(`<label for="nomer">Nomer Induk Siswa</label><input id="nomer" type="text" placeholder="No Induk Siswa" class="form-control" name="nomer" autocomplete="off">`);
            } else if (kel == "Admin" || kel == "Operator") {
                $("#noId").html(`<label for="name">Username</label><input id="name" type="text" placeholder="Username" class="form-control" name="name" autocomplete="off">`);
            } else {
                $("#noId").html(' <input type="hidden" name="anggota_id" value="0">')
            }
        });
    });
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataUser").addClass("active");
</script>
@endsection