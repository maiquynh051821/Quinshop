<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Validation Form</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/bootstrap-5.3.3-dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>
        </nav>
  
        <!-- Main Sidebar Container -->
        @include('admin.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mt-5">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $title }}</h3>
                                </div>
                                <!-- /.card-header -->
                            </div>
                           @yield('content')
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.1.0
            </div>
            <strong>Copyright &copy; MaiThuyQuynh </strong>
        </footer>


    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/plugins/jquery.validate.min.js"></script>
    <script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/plugins/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/js/demo.js"></script>
    <!-- Page specific script -->
</body>

</html>
