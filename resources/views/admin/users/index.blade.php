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
    Quản lý users
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
                    <h3 class="box-title">
                        <a href="{{route("admin.users.add")}}" class="btn btn-success btn-md" title="Thêm danh mục cha">Thêm</a>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Facebook</th>                               
                                <th>SDT</th>
                                <th class="center">Trạng thái</th>
                                <th class="center">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($objItems as $objItem)
                        @php
                            $id=$objItem->id;
                            $username=$objItem->username;
                            $fullname=$objItem->fullname;
                            $email=$objItem->email;
                            $facebook=$objItem->facebook;
                            $phone=$objItem->phone;
                            $active=$objItem->active;
                            $urlEdit=route('admin.users.edit',['id'=>$id]);
                            $urlDel=route('admin.users.del',['id'=>$id]);
                        @endphp
                            <tr>
                                <td>
                                    {{$id}}
                                </td>
                                <td>{{$username}}</td>
                                <td>{{$fullname}}</td>
                                <td>{{$email}}</td>
                                <td>{{$facebook}}</td>                              
                                <td>{{$phone}}</td>
                                <td id="active{{$id}}">
                                    <center>
                                    @if($active==1)
                                        <a onclick="active('1','{{$id}}')" class="btn btn-success">Hoạt động</a>
                                    @else
                                        <a onclick="active('0','{{$id}}')" class="btn btn-danger">Khóa</a>
                                    @endif
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a onclick="doi_mk('{{ $username }}')" data-toggle="modal" data-target="#modal-default" class="btn btn-warning">Đổi mật khẩu</a>
                                        <a href="{{$urlEdit}}" class="btn btn-primary"><i class="fa fa-edit"></i> Sửa</a>
                                        <a onclick="del('{{$urlDel}}','{{ $username }}')" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
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
            <h3 class="modal-title" style="color:#00a65a;" id="name">Đổi Mật khẩu</h3>
            <div id="msg">
                
            </div>
        </div>
        <div class="modal-body" id="modal-body">
            <form>
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-warning btn-flat" style="width:98px;">User</button>
                    </div>
                    <span>
                    <input readonly id="username" type="text" class="form-control">
                </div>
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" style="width:98px;">Mật khẩu</button>
                    </div>
                    <input id="password" type="password" class="form-control" placeholder="Nhập mật khẩu">
                </div>
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" style="width:98px;">Mật khẩu</button>
                    </div>
                    <input id="rpassword" type="password" value="" class="form-control" placeholder="Nhập lại mật khẩu">
                </div>
                <center>
                    <button onclick="doimk()" type="button" class="btn btn-success btn-flat">Đổi</button>
                </center>
            <form>
        </div>
        <div class="modal-footer center">
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
        function doi_mk(username){
            $("#username").val(username);
        }
        function doimk(){
            username=$("#username").val();
            password=$("#password").val();
            if(password.length<6){
                $("#password").val("");
                $("#rpassword").val("");
                return swal("Mật khẩu ít nhất 6 ký tự !","","error");
            }
            rpassword=$("#rpassword").val();
            if(password!=rpassword){
                $("#password").val("");
                $("#rpassword").val("");
                return swal("Mật khẩu không khớp !","","error");
            }
            $.ajax({
                url: '{{route('admin.users.doimk')}}',
                type: 'get',
                cache: false,
                data: {
                    username:username,
                    password:password
                },
                success: function(data){
                    if(data==0){
                        return swal("Bạn không phải admin !","Chỉ admin mới đổi mật khẩu cho người khác","error");
                    }else if(data=="error"){
                        return swal("Có lỗi xảy ra !","","error");
                    }
                    $("#password").val("");
                    $("#rpassword").val("");
                    return swal("Đổi mật khẩu thành công !","","success");
                },
                error: function (){
                    swal("Mất kết nối !","","error");
                }
            });
        }
        function active(active,id){
            $.ajax({
                url: '{{route('admin.users.active')}}',
                type: 'get',
                cache: false,
                data: {
                    active:active,
                    id:id
                },
                success: function(data){
                    $('#active'+id).html(data);
                },
                error: function (){
                    swal("Có lỗi xảy ra !","","error");
                }
            });
        }
        function del(url,username){
            swal({   
                title: "Bạn có muốn xóa ''"+username+"'' này không ?",
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "OK",   
                cancelButtonText: "Hủy",   
                closeOnConfirm: false,   
                }, 
                function(isConfirm){   
                    if (isConfirm) {
                        if(username!='admin'){
                            window.location.href=url;   
                        }else{
                            swal("Không thể xóa admin!","","error");
                        }
                    }
                }
            );
        }
   </script>
@endsection