@extends('template.home')

@section('content')

<section class="content card col-md-12" style="padding: 10px 10px 10px 10px ">
    <div class="box">
        <h4><i class="nav-icon fas fa-credit-card my-1 btn-sm-1"></i> Peraturan</h4>
        <hr>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-danger card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Profile</h3>
                            </div>
                            <div class="card-body">
                                <table class="table" style="margin-top: -21px;">
                                    <tr>
                                        <td width="50"><i class="nav-icon fas fa-user-edit"></i></td>
                                        <td> <a href="{{ route('profile.edit',Crypt::encrypt($keluarga->keluarga_id) ) }}" class="text-dark">Edit Data Diri<a></td>
                                    </tr>
                                    <tr>
                                        <td width="50"><img src="{{ asset( Auth::user()->foto) }}" class="img-fluid img-circle" alt="User profile picture"></td>
                                        <td>
                                            <a href="{{ asset(Auth::user()->foto) }}" data-toggle="lightbox" data-title="Foto {{ Auth::user()->name }}" data-gallery="gallery" data-footer=' <form action="{{Route('anggota.update.foto', Crypt::encrypt(Auth::user()->id))}}" method="post" enctype="multipart/form-data">
                                            {{csrf_field()}}<input type="file" class="form-control"  name=" foto" id="foto"> <input type="hidden" class="form-control" name=" user" id="user" value="{{Auth::user()->id}}"> <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-file-upload"></i> </button></form>' class="text-dark"> Edit Foto
                                            </a>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Pengaturan Akun</h3>
                            </div>
                            <div class="card-body">
                                <table class="table" style="margin-top: -21px;">
                                    <tr>
                                        <td width="50"><i class="nav-icon fas fa-envelope"></i></td>
                                        <td> <a href="{{ route('pengaturan.email') }}" class="text-dark">Ubah Email<a></td>
                                    </tr>
                                    <tr>
                                        <td width="50"><i class="nav-icon fas fa-key"></i></td>
                                        <td> <a href="{{ route('pengaturan.password') }}" class="text-dark"> Ubah Password
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50"><i class="nav-icon fas fa-check"></i></td>
                                        <td>Sambungkan</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            @if ($id_user_hubungan == FALSE)
                                            <p>Account teu acan tersambung</p>
                                            @else
                                            <p class="">Account atos tersambung, pami anu tos berkeluarga data tiasa di akses</p>
                                            @endif
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="card card-warning card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Program</h3>
                            </div>
                            <div class="card-body">
                                <table class="table" style="margin-top: -21px;">
                                    <tr>
                                        <td width="50"><i class="nav-icon fas fa-list"></i></td>
                                        <td> <a href="/roleprogram " class="text-dark">Program<a></td>
                                    </tr>
                                    <tr>
                                        <td width="50"><i class="nav-icon fas fa-list"></i></td>
                                        <td> <a href="{{Route('role.show',Crypt::encrypt(5))}} " class="text-dark">Cek Tugas<a></td>
                                    </tr>
                                    <tr>
                                        <td width="50"><i class="nav-icon fas fa-list"></i></td>
                                        <td> <a href="{{Route('keturunan_detail',crypt::encrypt(3))}} " class="text-dark">Cek keluarga<a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="card card-warning card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Bantuan</h3>
                            </div>
                            <div class="card-body">
                                <table class="table" style="margin-top: -21px;">
                                    <tr>
                                        <td width="50"><i class="nav-icon far fa-plus-square"></i>
                                        <td> <a href="{{Route('bantuan.detail',Crypt::encrypt(2))}} " class="text-dark">Bantuan<a></td>
                                    </tr>
                                </table>
                            </div>
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
    $("#Pengaturan").addClass("active");
</script>
@endsection