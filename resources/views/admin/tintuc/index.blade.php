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
                        <a href="{{route("admin.tintuc.rss",["id"=>"0"])}}" class="btn btn-success btn-md" title="Thêm danh mục cha">RSS</a>
                    </h3>
                </div>
                <!-- /.box-header -->
                <form action="{{route('admin.tintuc.del',['tintuc_id'=>'0'])}}">
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên tin tức</th>
                                <th>Lượt xem</th>
                                <th>Danh mục</th>
                                <th>Giới thiệu</th>                               
                                <th>Ngày tạo</th>
                                <th>Nguồn</th>
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
                            $luotxem=$objItem->luotxem;
                            $danhmuc=$objItem->tendanhmuc;
                            $gioithieu=$objItem->gioithieu;
                            $date=$objItem->ngaytao;
                            $nguon=$objItem->nguon;
                            $picture=$objItem->hinhanh;
                            $active=$objItem->active;
                            $urlEdit=route('admin.tintuc.edit',['tintuc_id'=>$id]);
                            $urlDel=route('admin.tintuc.del',['tintuc_id'=>$id]);
                        @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="arId[]" value="{{$id}}">
                                    <span style="font-size: 18px;margin-left: 5px;">{{$id}}<span>
                                </td>
                                <td style="width:20%;">{{$name}}</td>
                                <td>{{$luotxem}}</td>
                                <td>{{$danhmuc}}</td>
                                <td style="width:20%;">{{$gioithieu}}</td>                              
                                <td>{{$date}}</td>
                                <td>{{$nguon}}</td>
                                <td>
                                    <center>
                                        <img width="100px" src="/storage/app/files/{{$picture}}">
                                    </center>
                                </td>
                                <td id="active{{$id}}">
                                    <center>
                                    @if($active==1)
                                        <a onclick="active('1','{{$id}}')" class="btn btn-primary">Hiện thị</a>
                                    @else
                                        <a onclick="active('0','{{$id}}')" class="btn btn-danger">Đã ẩn</a>
                                    @endif
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a href="{{$urlEdit}}" class="btn btn-primary"><i class="fa fa-edit"></i> Sửa</a>
                                        <a onclick="del('{{$urlDel}}','')" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" onclick="return confirm('Bạn thực sự muốn xóa các bản ghi đã chọn?')" class="btn btn-danger">Xóa các tin đã chọn</a>
                </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@section('modal')

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
        function active(active,tintuc_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('admin.tintuc.active')}}',
                type: 'post',
                cache: false,
                data: {
                    active:active,
                    tintuc_id:tintuc_id
                },
                success: function(data){
                    $('#active'+tintuc_id).html(data);
                },
                error: function (){
                    swal("Có lỗi xảy ra !","","error");
                }
            });
        }
        function del(url,title){
            swal({   
                title: "Bạn có muốn xóa "+title+" tin tức này không ?",
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