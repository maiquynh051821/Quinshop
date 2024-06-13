<aside class="main-sidebar elevation-4" style="background-color: rgb(235, 223, 230)">
    <!-- Brand Logo -->
    <div class="ml-2 mt-4 ">
        <b style="font-size: 30px">QUIN-SHOP</b>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mb-3 d-flex">
            <div class="image">
                <pre style="font-size: 20px;">  <i class="fas fa-user" style="color:rgb(219, 2, 49)"></i> {{ Auth::user()->name }} </pre>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-list"> </i>
                        <p>
                            Danh mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/admin/menus/add" class="nav-link">
                                <i class="fa-solid fa-carrot"></i>
                                <p>Thêm danh mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/menus/list" class="nav-link">
                                <i class="fa-solid fa-circle-right"></i>
                                <p>Danh sách danh mục</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-shop"></i>
                        <p>
                            Sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/admin/products/add" class="nav-link">
                                <i class="fa-solid fa-carrot"></i>
                                <p>Thêm sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/products/list" class="nav-link">
                                <i class="fa-solid fa-circle-right"></i>
                                <p>Danh sách sản phẩm</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-tv"></i>
                        <p>
                            Slider
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/admin/sliders/add" class="nav-link">
                                <i class="fa-solid fa-carrot"></i>
                                <p>Thêm slider</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/sliders/list" class="nav-link">
                                <i class="fa-solid fa-circle-right"></i>
                                <p>Danh sách slider</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <p>
                            Giỏ hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/admin/customers" class="nav-link">
                                <i class="fa-solid fa-circle-right"></i>
                                <p>Danh sách đơn hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-user"></i>
                        <p>
                            Tài khoản
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/admin/users/list" class="nav-link">
                                <i class="fa-solid fa-circle-right"></i>
                                <p>Danh sách tài khoản</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-shoe-prints"></i>
                        <p>
                            Footer
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/admin/footers/add" class="nav-link">
                                <i class="fa-solid fa-carrot"></i>
                                <p>Thêm footer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/footers/list" class="nav-link">
                                <i class="fa-solid fa-circle-right"></i>
                                <p>Danh sách footer</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-circle-info"></i>
                        <p>
                            Cửa hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/admin/siteInfos/list" class="nav-link">
                                <i class="fa-solid fa-circle-right"></i>
                                <p>Thông tin cửa hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.contacts.list') }}">
                                    <i class="fa-solid fa-circle-right"></i>
                                    <p>Danh sách liên hệ</p>
                                </a>
                            </li>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
