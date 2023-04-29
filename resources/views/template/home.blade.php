<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keluarga MaHAYA</title>
    <link rel="shrotcut icon" href="{{ asset('img/logo.png') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('layouts/dist/css/adminlte.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('layouts/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('layouts/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- Theme style -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('layouts/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('layouts/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

</head>

<body class="hold-transition white-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{asset('img/logo.jpg')}}" alt="AdminLTELogo" height="60" width="60">
        </div> -->

        <!-- Navbar -->
        @include('template.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('template.sidebar')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(Auth::user()->is_active == 0)

            <body class="justify-content-center">
                <center>
                    <h1>Hapunten !</h1>
                    <img src="https://c.tenor.com/Z8ezUHZzcLoAAAAC/love.gif" alt="">
                    <h1>Akun Anjeun Teu Aktif</h1>
                    <h3>Kanggo ngaktifkeun deui, mangga chat wae ka Official </h3>
                    <a id="btn_mau" href="http://api.whatsapp.com/send?phone=6283825740395&text=Punten A Admin, Akun Abdi teu acan AKTIF . Hoyong di aktifkeun nya, Nuhun">Chat Official</a>
                    <button id="btn_gamau" onclick="gamau(this)" style="position: relative;">Gamau</button>
                </center>
            </body>


            @else
            @include('template.notifikasi')
            <!-- Main content -->
            @yield('content')
            <!-- /.content -->

            @endif
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('template.footer')
    </div>
    <!-- ./wrapper -->
    <!-- ./wrapper -->


    <!-- REQUIRED SCRIPTS -->
    <!-- Script jika tidak aktif -->
    <script>
        function gamau(id) {
            var mau = document.getElementById("btn_mau");
            var i = Math.floor(Math.random() * 150) + 1;
            var j = Math.floor(Math.random() * 50) + mau.offsetHeight;
            id.style.left = i + "px";
            id.style.top = j + "px";
        }
    </script>
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
    <!-- DataTables  & Plugins -->
    <script src="{{asset('layouts/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('layouts/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('layouts/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('layouts/plugins/select2/js/select2.full.min.js')}}"></script>
    @yield('script')
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#table1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');
            $("#table2").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table2_wrapper .col-md-6:eq(0)');

            $("#table3").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table3_wrapper .col-md-6:eq(0)');
            $("#table4").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table4_wrapper .col-md-6:eq(0)');
            $("#table5").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table5_wrapper .col-md-6:eq(0)');

        });
    </script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    <script>
        $(function() {
            // Summernote
            $('#summernote1').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- page script -->
    <!-- scrip untuk navigasi bawah -->
    <script>
        /*
 $("#headera").addClass("fixed-bottom");
  
    Sticky Header. Auto hide on scroll bottom, show on scroll top.
    By: www.igniel.com
  */
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                $("#headera").addClass("fixed-bottom");

            } else {
                $("#headera").removeClass("fixed-bottom");

            }
            prevScrollpos = currentScrollPos;
        }
    </script>

    <!-- scrip Untuk elemen Button -->
    <script>
        function tombol_pinjam() {
            if (document.getElementById("myBtn_pinjam").hidden = true) {
                // membuat objek elemen
                // alert("Nuju di proses...");
                var hasil = document.getElementById("tombol_proses");
                hasil.innerHTML = "Nuju di proses ...";
            }
        }
        <?php

        use App\Models\Anggaran;
        use App\Models\BayarPinjaman;
        use App\Models\Pemasukan;

        $total_pembayaran_cash = Pemasukan::where('pembayaran', 'Cash')->sum('jumlah');
        // menghitung jumlah setor tunai
        $total_setor_tunai = Pemasukan::where('kategori', 'Setor_tunai')->sum('jumlah');
        // Uang nu teu acan di transfer
        $total_bayar_pinjaman_cash = BayarPinjaman::where('pembayaran', 'Cash')->sum('jumlah');
        $uang_blum_diTF = $total_pembayaran_cash - $total_setor_tunai + $total_bayar_pinjaman_cash;
        // Data Anggaran
        $data_anggaran = Anggaran::all();
        $data_anggaran_max_pinjaman = Anggaran::find(3);
        $cek_semua_pemasukan = Pemasukan::where('kategori', 'Kas')->sum('jumlah');
        $cek_pemasukan_2 = $cek_semua_pemasukan / 2; // Membagi jumlah semua pemasukan
        $tahap_1 = $cek_pemasukan_2 * 90 / 100; // Menghitung Jumlah anggaran pinjaman dari hasil pembagian 2,
        $cek_total_pinjaman = $tahap_1 / 2; // Menghitung total Anggaran
        $jatah = $cek_total_pinjaman * $data_anggaran_max_pinjaman->persen / 100; //Jath Persenan di ambil dari data anggaran
        ?>
        let jumlah_pinjam = document.getElementById("jumlah");
        let button_pinjam = document.getElementById("myBtn_pinjam");
        button_pinjam.disabled = true;
        jumlah_pinjam.addEventListener("change", stateHandle);

        function stateHandle() {
            if (document.getElementById("jumlah").value <= 49999) {
                button_pinjam.disabled = true;
                document.getElementById("keterangann").innerHTML = "";
            } else if (document.getElementById("jumlah").value >= <?php echo $jatah ?>) {
                button_pinjam.disabled = true;
                document.getElementById("keterangann").innerHTML = "";
            } else {
                button_pinjam.disabled = false;
                document.getElementById("keterangann").innerHTML = "<b> Alasan</b>    : <br> <br> <b> Pami Transfer Esian Data Bank </b> <br> Nama Bank  : <br> No Req    : <br> A/N  : <br> <br><b> Pami bade cash mangga input prosesna pengambilanna : </b> <br> <br><b> Tanggal Di kembalikeun </b> : <br> <hr> <center> Pami Atos di Setujui Bukti di Cantumkeun di Handap </center>";
            }

        }
    </script>

    <script>
        function tombol_kas() {
            if (document.getElementById("myBtn_k").hidden = true) {
                // membuat objek elemen
                // alert("Nuju di proses...");
                var hasil = document.getElementById("tombol_proses");
                hasil.innerHTML = "Nuju di proses ...";
            }
        }
    </script>

    <script>
        let jumlah_kas = document.getElementById("jumlah");
        let button_kas = document.getElementById("myBtn_k");
        button_kas.disabled = true;
        jumlah_kas.addEventListener("change", stateHandle);

        function stateHandle() {
            if (document.getElementById("jumlah").value <= 49999) {
                button_kas.disabled = true;
            } else {
                button_kas.disabled = false;
            }
        }
    </script>
    <!-- // setor Tunai -->

    <script>
        function tombol_setor() {
            if (document.getElementById("myBtn_setor").hidden = true) {
                // membuat objek elemen
                // alert("Nuju di proses...");
                var hasil = document.getElementById("tombol_proses");
                hasil.innerHTML = "Nuju di proses ...";
            }
        }

        let jumlah_setor = document.getElementById("jumlah");
        let foto_setor = document.getElementById("foto");
        let button_setor = document.getElementById("myBtn_setor");
        button_setor.disabled = true;
        jumlah_setor.addEventListener("change", stateHandle);
        foto_setor.addEventListener("change", stateHandle);

        function stateHandle() {
            if (document.getElementById("jumlah").value === "") {
                button_setor.disabled = true;
            } else if (document.getElementById("jumlah").value <= 49999) {
                button_setor.disabled = true;
            } else if (document.getElementById("jumlah").value >= <?php echo $uang_blum_diTF + 1 ?>) {
                button_setor.disabled = true;
            } else {
                button_setor.disabled = false;
            }
        }
    </script>

    <script>
        function tombol() {
            if (document.getElementById("myBtn").hidden = true) {
                // membuat objek elemen
                // alert("Nuju di proses...");
                var hasil = document.getElementById("tombol_proses");
                hasil.innerHTML = "Nuju di proses ...";
            }
        }
    </script>

    <!-- SCrip Untuk tanda bukti pembayaran -->
    <script>
        $(document).ready(function() {
            $('#pembayaran').change(function() {
                var kel = $('#pembayaran option:selected').val();
                if (kel == "Transfer") {
                    $("#noId").html('<div class="form-group"><label for="account-company">Bukti Transfer</label><input type="file" class="form-control" name="foto" id="foto" required /><span class="text-danger" style="font-size: 13px">Harap kirim tanda bukti transferan.</span></div>');
                } else {
                    $("#noId").html('');
                }
            });
        });
    </script>

    <script>
        var rupiah = document.getElementById("jumlahh");
        rupiah.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, "Rp. ");
        });
        // tidak di pake ==============================================
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : "");
        }
    </script>

    <!-- Validasi jumlah  ============================================-->
    <?php


    use App\Models\Pengajuan;

    $jumlah_data_pengajuan = Pengajuan::all()->count();
    ?>
    @if (Auth::user()->role == 'Bendahara' || Auth::user()->role == 'Admin' )
    @if ($jumlah_data_pengajuan >= 1 )
    <script>
        toastr.warning(" Aya Pengajuan nu kedah di konfirmasi ");
    </script>
    @endif
    @endif
    <!-- form validasi jumlahhhh teu kapake  -->
</body>

</html>