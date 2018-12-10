@include('templates.admin.header')
<style>
    .msg{
        width:98%;
        margin-left:1%;
        margin-top:15px;
        margin-bottom:0px;
    }
</style>
<!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            @include('templates.admin.left_bar')
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 style="color:red;">
                    @yield('name')
                </h1>
                <!--<ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a>
                    </li>
                    <li class="active">Here</li>
                </ol>-->
            </section>
            <!-- Main content -->
            @yield('msg')
            <section class="content container-fluid">
                <!--------------------------| Your Page Content Here |-------------------------->
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @yield('modal')
        <!-- Main Footer -->
@include('templates.admin.footer')