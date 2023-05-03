@extends('template.home')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- ./row -->
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-body">
                        <center>
                            <h5 class="text-bold card-header bg-light p-0"> EDIT DATA BANTUAN</h5>
                        </center>
                        <hr>
                        <form action="{{ route('bantuan.update',Crypt::encrypt($bantuan->id)) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="nama_bantuan">Nama bantuan</label>
                                <input type="hidden" name="id" value="{{ $bantuan->id }}">
                                <input type="text" id="nama_bantuan" name="nama_bantuan" value="{{ old('nama_bantuan',$bantuan->nama_bantuan) }}" placeholder="Nama bantuan" class="form-control col-12 @error('nama_bantuan') is-invalid @enderror">
                                @error('nama_bantuan')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="textarea form-control bg-light @error('deskripsi') is-invalid @enderror" id="summernote" rows="6" value="{{ old('deskripsi') }}">{!! $bantuan->deskripsi !!}</textarea>
                                @error('deskripsi')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="account-company">Video</label>
                                <input type="file" class="form-control" name="video" id="video" value="{{$bantuan->video}}" required />
                                <span class="text-danger" style="font-size: 13px">Lebih sae ngange video.</span>
                            </div>

                            <hr>
                            <button onclick="tombol()" id="myBtn" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i> Geuntos</button>
                            <div id="tombol_proses"></div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DATA BANTUAN</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-light">
                                    <th>No.</th>
                                    <th>Nama Bantuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 0; ?>
                                @foreach($data_bantuan as $data)
                                <?php $no++; ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$data->nama_bantuan}}</td>
                                    <td>
                                        <form action="{{route('bantuan.destroy',Crypt::encrypt($data->id))}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <a href="{{route('bantuan.show',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-book"></i></a>
                                            <a href="{{route('bantuan.edit',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-pencil-alt"></i></a>
                                            @if (auth()->user()->role == 'Admin')
                                            <button class="btn btn-link btn-sm mt-2"><i class="nav-icon fas fa-trash-alt" onclick="return confirm('Leres bade ngahapus data anu namina {{$data->nama}}  ?')"></i> </button>
                                            @endif
                                        </form>
                                    </td>


                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-body -->

                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>
@endsection