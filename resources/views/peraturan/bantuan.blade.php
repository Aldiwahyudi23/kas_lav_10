<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bantuan / Tutor</title>

    <link rel="shrotcut icon" href="{{ asset('img/logo.jpg') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('layouts/dist/css/adminlte.min.css')}}">
</head>

<body class="hold-transition white-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="brand-link" style="color: #fff;" data-widget="pushmenu" href="#">
                        <img src="{{ asset('img/layout/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Bantuan / Tutor
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/layout/logo.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Keluarga Ma. Haya</a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search.." title="Type in a category">

                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2" id="myMenu">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        @foreach($data_bantuan as $data)
                        <li class="nav-item">
                            <a href="{{Route('bantuan.detail',Crypt::encrypt($data->id))}}" class="nav-link">
                                * {{$data->nama_bantuan}}
                            </a>
                        </li>
                        @endforeach
                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i> &nbsp;
                                Keluar (dari tutor)
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Main row -->
                    <div class="card-body">
                        <p>{!!$detail_bantuan->deskripsi!!}</p>
                    </div>
                    @if ($detail_bantuan->video == true)
                    <center>
                        <p>Cek Video na</p>
                    </center>
                    <video src="{{asset($detail_bantuan->video)}}" controls width="100%"></video>
                    @else
                    @endif
                    <!-- /.row -->
                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <marquee>
                <strong>KELUARGA BESAR Alm. MA HAYA. Mengucapkan selamat menunaikan Ibadah PUASA </strong>
            </marquee>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{asset('layouts/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('layouts/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('layouts/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('layouts/dist/js/adminlte.js')}}"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{asset('layouts/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('layouts/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('layouts/plugins/chart.js/Chart.min.js')}}"></script>

    <script src="{{asset('layouts/dist/js/pages/dashboard2.js')}}"></script>
    <!-- scrip untuk navigasi bawah -->

    <script>
        function myFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("mySearch");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myMenu");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
</body>

</html>