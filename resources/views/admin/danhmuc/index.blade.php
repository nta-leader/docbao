@extends('templates.admin.master')
@section('css')
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@endsection
@section('name')
    Quản lý danh mục
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
    .danhmuc{
        width:40%;
    }
    .danhmuccha{
        width:40%;
    }
    .danhmuccon{
        width:40%;
        margin-left:5%;
    }
    .them{
        width:40%;
        margin-left:5%;
    }
</style>
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                <a onclick="them()" data-toggle="modal" data-target="#modal-default" class="btn btn-success btn-md" title="Thêm danh mục cha">Thêm</a>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th class="center">ID</th>
                        <th class="danhmuc"">Tên danh mục</th>
                        <th>Chức năng</th>
                    </tr>
                    <tbody>
                    @foreach($objDanhmuccha as $objItem)
                    @php
                        $dmcha_id=$objItem->danhmuc_id;
                        $name_cha=$objItem->tendanhmuc;
                        $soluong_cha=$soluong[$objItem->danhmuc_id];
                        $sx_cha=$objItem->sapxep;
                        $urlDel_cha=route('admin.danhmuc.del',['id'=>$dmcha_id]);
                    @endphp
                        <tr>
                            <td class="center">{{$dmcha_id}}</td>
                            <td>
                                <span class="btn btn-primary danhmuccha"> {{$name_cha}} </span>
                                @foreach($objDanhmuccon as $Item)
                                @php
                                    $dmcon_id=$Item->danhmuc_id;
                                    $name_con=$Item->tendanhmuc;
                                    $soluong_con=$soluong[$Item->danhmuc_id];
                                    $sx_con=$Item->sapxep;
                                    $parent_id=$Item->parent_id;
                                    $urlDel_con=route('admin.danhmuc.del',['id'=>$dmcon_id]);
                                @endphp
                                @if($dmcha_id==$parent_id)
                                <div>
                                    <span class="btn btn-success danhmuccon"> {{$name_con}} </span>
                                    <a onclick="sua('{{$dmcon_id}}','{{$name_con}}','{{$sx_con}}','{{$parent_id}}')" data-toggle="modal" data-target="#modal-edit"  class="btn btn-primary"><i class="fa fa-edit "></i> Sửa</a>
                                    <a onclick="del('{{$urlDel_con}}','{{$soluong_con}}')" title="" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
                                </div>
                                @endif
                                @endforeach
                                <div>
                                    <a onclick="them('{{$dmcha_id}}')" data-toggle="modal" data-target="#modal-default" class="btn btn-warning btn-sm them" title="Thêm danh mục con">Thêm</a>
                                </div>
                            </td>
                            <td>
                                <a onclick="sua('{{$dmcha_id}}','{{$name_cha}}','{{$sx_cha}}','0')" data-toggle="modal" data-target="#modal-edit" class="btn btn-primary"><i class="fa fa-edit "></i> Sửa</a>
                                <a onclick="del('{{$urlDel_cha}}','{{$soluong_cha}}')" title="" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
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
                <input id="sapxep" type="number" min=0 value="0" class="form-control" placeholder="Nhập số">

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
<script src="{{$urlAdmin}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{$urlAdmin}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="{{$urlAdmin}}/dist/js/adminlte.min.js"></script>
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
        function del(url,soluong){
            swal({   
                title: "Bạn có muốn xóa danh mục này không ?",
                text: "Danh mục này có "+soluong+" bài viết",         
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