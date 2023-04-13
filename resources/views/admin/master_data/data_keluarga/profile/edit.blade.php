@extends('template.home')


@section('content')

<div class="col-md-12">
    <div class="card">
        <h6 class="card-header bg-light p-3"><i class="fas fa-user"></i> Edit DATA anggota</h6>
        <div class="card-body">
            <form action="{{route('keluarga.update',Crypt::encrypt($data_keluarga->id))}}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                {{csrf_field()}}
                <div class="card-body table-responsive">
                    <div class="row">
                        <input type="hidden">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" value="{{ $data_keluarga->nama}}" placeholder="Nami kedah sami sareng KTP" class="form-control @error('nama') is-invalid @enderror">
                                @error('nama')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jk">Jenis Kelamin</label>
                                <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror" value=" {{$data_keluarga->jenis_kelamin}} ">
                                    @if($data_keluarga->jenis_kelamin == $data_keluarga->jenis_kelamin)
                                    <option value="{{$data_keluarga->jenis_kelamin}}">{{$data_keluarga->jenis_kelamin}}</option>
                                    @endif
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-Laki"> Laki-Laki</option>
                                    <option value="Perempuan"> Perempuan</option>
                                </select>
                                @error('jk')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tmp_lahir">Tempat Lahir</label>
                                <input type="text" id="tmp_lahir" name="tmp_lahir" value="{{ $data_keluarga->tempat_lahir }}" placeholder="Contoh : Garut" class="form-control @error('tmp_lahir') is-invalid @enderror">
                                @error('tmp_lahir')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ $data_keluarga->tanggal_lahir}}" placeholder="23-12-2000" class="form-control @error('tgl_lahir') is-invalid @enderror">
                                @error('tgl_lahir')<div class="invalid-feedback"><strong>{{ $message }}</strong></div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" id="nik" name="nik" value="{{ $data_keluarga->nik}}" placeholder="000000001" class="form-control @error('nik') is-invalid @enderror">
                                @error('nik')<div class="invalid-feedback"><strong>{{ $message }}</strong></div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" id="alamat" name="alamat" value="{{ $data_keluarga->alamat }}" placeholder="Kp. Cihanja Rt.03 Rw.03" class="form-control @error('alamat') is-invalid @enderror">
                                @error('alamat')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">Nomor Telpon/HP</label>
                                <input type="text" id="no_hp" name="no_hp" value="{{ $data_keluarga->no_hp }}" placeholder="+62 xxx xxxx xxxx" class="form-control @error('no_hp') is-invalid @enderror">
                                @error('no_hp')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan">Status</label>
                                <select id="pekerjaan" name="pekerjaan" class="select2bs4 form-control @error('pekerjaan') is-invalid @enderror" value=" {{old('pekerjaan')}} ">
                                    @if($data_keluarga->pekerjaan == true)
                                    <option value="{{$data_keluarga->pekerjaan}}">{{$data_keluarga->pekerjaan}}</option>
                                    @endif
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Sekolah">Sekolah</option>
                                    <option value="Bekerja"> Bekerja</option>
                                    <option value="Irt"> Ibu Rumah Tangga</option>
                                    <option value="TBekerja"> Tidak Bekerja</option>
                                    <option value="TSekolah"> Tidak Sekolah</option>
                                </select>
                                @error('pekerjaan')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>
                <hr>
                <H5>
                    <CENTER><strong>Hubungan Keluarga
                </H5>
                </CENTER></strong>
                <hr>
                <div class="form-group">
                    <label for="nama_hubungan">Nama Orang Tua / Suami Istri</label>
                    <select id="nama_hubungan" name="nama_hubungan" class="select2bs4 form-control @error('nama_hubungan') is-invalid @enderror">
                        @if($data_keluarga->keluarga_id == true)
                        <option value="{{$data_keluarga->keluarga_id}}">{{$data_keluarga->keluarga->nama}}</option>
                        @endif
                        <option value="">-- Pilih Nama --</option>
                        @foreach ($data_keluargas as $data)
                        <option value="{{$data->nama}}"> {{$data->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="hubungan">Hubungan</label>
                    <select id="hubungan" name="hubungan" class="select2bs4 form-control @error('hubungan') is-invalid @enderror">
                        @if($data_keluarga->hubungan == true)
                        <option value="{{$data_keluarga->hubungan}}">{{$data_keluarga->hubungan}}</option>
                        @endif
                        <option value="">-- Pilih Hubungan --</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                    </select>
                </div>
                @if ($data_keluarga->hubungan == 'Anak')
                <input type="hidden" id="anak_ke" name="anak_ke" value="{{ $data_keluarga->anak_ke }}">
                @endif
                <div class="form-group row" id="noId">

                </div>
                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPEN</button>
            </form>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#hubungan').change(function() {
            var kel = $('#hubungan option:selected').val();
            if (kel == "Anak") {
                $("#noId").html('<label for="anak_ke">Anak ke</label> <input type="text" id="anak_ke" name="anak_ke" value="{{ $data_keluarga->anak_ke }}" class="form-control">');
            } else if (kel == "Siswa") {
                $("#noId").html(`<label for="nomer">Nomer Induk Siswa</label><input id="nomer" type="text" placeholder="No Induk Siswa" class="form-control" name="nomer" autocomplete="off">`);
            } else if (kel == "Admin" || kel == "Operator") {
                $("#noId").html(`<label for="name">Username</label><input id="name" type="text" placeholder="Username" class="form-control" name="name" autocomplete="off">`);
            } else {
                $("#noId").html(' <input type="hidden" name="anggota_id" value="0">')
            }
        });
    });
</script>
@endsection