@extends('templates.admin.master')
@section('css')
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@endsection
@section('name')
    Quản lý tin tức
@endsection
@section('msg')
    @if(Session::has('msg'))
        <div class="alert alert-success alert-dismissible msg">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i>{{Session::get('msg')}}
        </div>
    @endif
@endsection
@section('content')
<style>
    .center{
        text-align:center;
    }
</style>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="display: block;text-align: center;">
                        @if(isset($_GET['Page']))
                            {{getenv("PAGE_ADMIN")}} tin tiếp theo
                        @else
                        {{getenv("PAGE_ADMIN")}} tin mới nhât
                        @endif
                    </h3>
                    <h3 class="box-title">
                        <a href="{{route("admin.tintuc.add")}}" class="btn btn-success btn-md" title="Thêm danh mục cha">Thêm</a>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên tin tức</th>
                                <th>Danh mục</th>
                                <th>Giới thiệu</th>                               
                                <th>Ngày tạo</th>
                                <th class="center">Hình ảnh</th>
                                <th class="center">Trạng thái</th>
                                <th class="center">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($objItems as $objItem)
                        @php
                            $id=$objItem->tintuc_id;
                            $name=$objItem->tentintuc;
                            $danhmuc=$objItem->tendanhmuc;
                            $gioithieu=$objItem->gioithieu;
                            $date=$objItem->ngaytao;
                            $picture=$objItem->hinhanh;
                            $active=$objItem->active;
                            $urlEdit="";
                            $urlDel="";
                        @endphp
                            <tr>
                                <td>{{$id}}</td>
                                <td style="width:20%;">{{$name}}</td>
                                <td>{{$danhmuc}}</td>
                                <td style="width:20%;">{{$gioithieu}}</td>
                                <td>{{$date}}</td>
                                <td>
                                    <center>
                                        <img src="/storage/app/files/{{$picture}}">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                    @if($active==1)
                                        <a class="btn btn-primary">Hiện thị</a>
                                    @else
                                        <a class="btn btn-danger">Đã ẩn</a>
                                    @endif
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a class="btn btn-primary"><i class="fa fa-edit"></i> Sửa</a>
                                        <a class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@section('modal')
<style>
    .border_radius{
        border-radius:5px;
    }
    .msg_modal{
        margin: 5px 0px -15px 0px;
        padding: 10px 33px 10px 10px;
    }
</style>
<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
    <div class="modal-content border_radius">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h3 class="modal-title" style="color:#00a65a;" id="name">name</h3>
            <div id="msg">
                
            </div>
        </div>
        <div class="modal-body" id="modal-body">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat">Tên danh mục</button>
                </div>
                <input id="tendanhmuc" type="text" class="form-control" placeholder="Nhập tên">

                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat">Sắp xếp</button>
                </div>
                <input id="sapxep" type="number" min=0 class="form-control" placeholder="Nhập số">

                <span class="input-group-btn" id="button">
                    <button type="button" class="btn btn-success btn-flat">Thêm</button>
                </span>
            </div>
        </div>
        <div class="modal-footer center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
        </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- sua danhmuc -->
<div class="modal fade" id="modal-edit" style="display: none;">
    <div class="modal-dialog">
    <div class="modal-content border_radius">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h3 class="modal-title" style="color:#00a65a;" id="name">Sửa danh mục</h3>
            <div id="msg">
                
            </div>
        </div>
        <div class="modal-body" id="modal-body">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat">Tên danh mục</button>
                </div>
                <input id="tendanhmuc_e" type="text" class="form-control" placeholder="Nhập tên">

                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat">Sắp xếp</button>
                </div>
                <input id="sapxep_e" type="number" min=0 class="form-control" placeholder="Nhập số">
                <input style="display:none;" id="parent_id_e" type="number" value="" min=1 class="form-control" placeholder="Nhập số">
                <span class="input-group-btn" id="button_e">
                    <button type="button" class="btn btn-success btn-flat">Sửa</button>
                </span>
            </div>
        </div>
        <div class="modal-footer center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
        </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('js')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- jQuery 3 -->
<script src="{{$urlAdmin}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{$urlAdmin}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="{{$urlAdmin}}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{$urlAdmin}}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{$urlAdmin}}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{$urlAdmin}}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{$urlAdmin}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{$urlAdmin}}/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
   <script>
        function them(parent_id=0){
            if(parent_id==0){
                document.getElementById("name").innerHTML = "Thêm danh mục cha";
            }else{
                document.getElementById("name").innerHTML = "Thêm danh mục con";
            }
            document.getElementById("button").innerHTML = '<button onclick="add('+parent_id+')" type="button" class="btn btn-success btn-flat">Thêm</button>';
        }
        function sua(danhmuc_id,tendanhmuc,sapxep,parent_id){
            document.getElementById("tendanhmuc_e").value = tendanhmuc;
            document.getElementById("sapxep_e").value = sapxep;
            document.getElementById("parent_id_e").value = parent_id;
            document.getElementById("button_e").innerHTML = '<button onclick="edit('+danhmuc_id+')" type="button" class="btn btn-success btn-flat">sửa</button>'; 
        }
        function add(parent_id){
            tendanhmuc=document.getElementById("tendanhmuc").value;
            sapxep=document.getElementById("sapxep").value;
            if(tendanhmuc != '' && sapxep != '' && tendanhmuc != ' ' && sapxep != ' '){
                $.ajax({
                    url: '{{route('admin.danhmuc.add')}}',
                    type: 'get',
                    cache: false,
                    data: {
                        parent_id:parent_id,
                        tendanhmuc:tendanhmuc,
                        sapxep:sapxep
                    },
                    success: function(data){
                        $('#msg').html(data);
                    },
                    error: function (){
                        alert('Có lỗi xảy ra');
                    }
                });
            }else{
                swal("Không được để rỗng !", "", "error");
            }
        } 
        function edit(danhmuc_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            tendanhmuc=document.getElementById("tendanhmuc_e").value;
            sapxep=document.getElementById("sapxep_e").value;
            parent_id=document.getElementById("parent_id_e").value;
            if(tendanhmuc != '' && sapxep != '' && tendanhmuc != ' ' && sapxep != ' '){
                $.ajax({
                    url: '{{route('admin.danhmuc.edit')}}',
                    type: 'post',
                    cache: false,
                    data: {
                        danhmuc_id:danhmuc_id,
                        parent_id:parent_id,
                        tendanhmuc:tendanhmuc,
                        sapxep:sapxep
                    },
                    success: function(data){
                        $('#msg').html(data);
                    },
                    error: function (){
                        alert('Có lỗi xảy ra');
                    }
                });
            }else{
                swal("Không được để rỗng !", "", "error");
            }
        }
        function del(url){
            swal({   
                title: "Bạn có muốn xóa danh mục này không ?",
                text: "Danh mục này có 10 bài viết",         
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "OK",   
                cancelButtonText: "Hủy",   
                closeOnConfirm: false,   
                }, 
                function(isConfirm){   
                    if (isConfirm) {   
                        window.location.href=url;   
                    }
                }
            );
        }
   </script>
@endsection