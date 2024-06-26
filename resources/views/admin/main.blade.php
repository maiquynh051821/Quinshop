<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.head')
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
            <ul class="navbar-nav ml-auto">
                <!-- Logout Button -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" 
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        <button id="logout" class="btn btn-danger btn-logout">Đăng xuất</button>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
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
                    @include('login.alert')
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- Form -->
                            <div class="card card-dark">
                                  <!-- /.card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">{{ $title }}</h3>
                                </div>
                                <!-- /.card-content -->
                                @yield('content') 
                            </div>
                           
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
               <pre> <b>Version</b> 1.1.0     </pre>
            </div>
            <pre><strong>    Copyright &copy; MaiThuyQuynh    </strong></pre>
        </footer>
    </div>
   @include('admin.footer')
  
</body>

</html>