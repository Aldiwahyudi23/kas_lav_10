@extends('template.home')

@section('content')
<section class="content card col-12" style="padding: 10px 10px 10px 10px ">
    <div class="box">
        <h4><i class="nav-icon fas fa-users my-1 btn-sm-1"></i> Data Program</h4>
        <hr>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <form class="form-group" action="{{ route('program.update',Crypt::encrypt($program->id)) }}" method="post">
                                @method('PATCH')
                                {{csrf_field()}}
                                <div class="card-header">
                                    <button type="submit" name="submit" class="btn btn-outline-primary">
                                        Edit &nbsp; <i class="nav-icon fas fa-save"></i>
                                    </button>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                            <i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_program">Nama Program</label>
                                    <input type="text" id="nama_program" name="nama_program" value="{{ old('nama_program',$program->nama_program) }}" placeholder="Nama Program" class="form-control  @error('nama_program') is-invalid @enderror">
                                    @error('nama_program')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="card-body pad">
                                    <div class="mb-3">
                                        <input type="hidden" name="id" value="{{ $program->id }}">
                                        <textarea class="textarea @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $program->deskripsi }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    $("#DataProgram").addClass("active");
</script>
@endsection