@extends('templates.admin.master')
@include('functions.indanhmuc_rss')
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
    Quản lý rss
@endsection
@section('msg')
    @if(Session::has('msg'))
        <div class="alert alert-success alert-dismissible msg">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i>{{Session::get('msg')}}
        </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible msg">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @foreach ($errors->all() as $error)
            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
        @endforeach
    </div>
    @endif
@endsection
@section('content')
<style>
    .ajax-load-qa {
        background: url("https://2.bp.blogspot.com/-K6t6oBc4jd0/WC1H9h6QBWI/AAAAAAAAAMU/A0C5q9w-mwkVQf_HlezvaJ0lftPP1u9jwCLcB/s1600/loading%2B%25283%2529.gif") no-repeat center center rgba(255,255,255,0.5);
        position: fixed;
        z-index: 100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: none;
        z-index: 1000000000;
    }
    .center{
        text-align:center;
    }
    .list_rss{
        text-align: left;
    }
</style>
<div id="tb">
    <div id="ajax_loader" class="ajax-load-qa"></div>  
</div>
    <div id="row" class="row">
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
                        <a onclick="them()" data-toggle="modal" data-target="#modal-default" class="btn btn-success btn-md" title="Thêm rss">Thêm rss</a>
                        <a data-toggle="modal" data-target="#modal-ds" class="btn btn-success btn-md" title="Danh sách" rss">Danh sách rss</a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success">Chọn rss</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            @foreach($objRss as $item)
                            @php
                                $rss_id=$item->rss_id;
                                $name=$item->link;
                            @endphp
                                <li><a href="{{route('admin.tintuc.rss',['id'=>$rss_id])}}">{{$name}}</a></li>
                            @endforeach
                            </ul>
                        </div>
                        @if($id > 0)
                        <a id="click" onclick="capnhat()" href="{{route('admin.tintuc.rss.update',['id'=>$id])}}" class="btn btn-success btn-md" title="Cập nhật css">Cập nhật</a>
                        @endif
                    </h3>
                </div>
                <!-- /.box-header -->
                <form action="{{route('admin.tintuc.rss.tintucdel',['id'=>'0'])}}">
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên tin tức</th>
                                <th>Nguồn</th>
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
                            $id=$objItem->id;
                            $name=$objItem->name;
                            $link=$objItem->link;
                            $preview=$objItem->preview;
                            $date=$objItem->date;
                            $picture=$objItem->picture;
                            $active=$objItem->active;
                            $urlDel=route('admin.tintuc.rss.tintucdel',['tintuc_id'=>$id]);
                        @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="arId[]" value="{{$id}}">
                                    <span style="font-size: 18px;margin-left: 5px;">{{$id}}<span>
                                </td>
                                <td style="width:15%;">{{$name}}</td>
                                <td style="width:15%;">{{$link}}</td>
                                <td style="width:30%;">{{$preview}}</td>                              
                                <td>{{$date}}</td>
                                <td>
                                    <center>
                                        <img width="100px" src="/storage/app/files/{{$picture}}">
                                    </center>
                                </td>
                                <td id="active{{$id}}">
                                @if($active==0)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success">Chọn danh mục</button>
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            {{ indanhmuc($objDanhmuccha,$objDanhmuccon,$id)}}
                                        </ul>
                                    </div>
                                @else
                                    <a class="btn btn-danger">Tin này đã có</a>
                                @endif
                                </td>
                                <td>
                                    <center>
                                        <a href="{{$urlDel}}" class="btn btn-danger"><i class="fa fa-pencil"></i> Xóa</a>
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
            <h3 class="modal-title" style="color:#00a65a;" id="name">Thêm rss</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <form action="{{route('admin.tintuc.rss.add')}}" method="POST" >
            {{csrf_field()}}
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat">Link rss</button>
                    </div>
                    <input id="link" name="link" type="text" value="{{ old('link') }}" class="form-control" placeholder="Nhập link !">
                    <span class="input-group-btn" id="button">
                        <button type="submit"  class="btn btn-success btn-flat">Thêm</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="modal-footer center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
        </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ds" style="display: none;">
    <div class="modal-dialog">
    <div class="modal-content border_radius">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h3 class="modal-title" style="color:#00a65a;" id="name">Danh sách rss</h3>
        </div>
        <div class="modal-body" id="modal-body">
        @foreach($objRss as $item)
        @php
            $rss_id=$item->rss_id;
            $name=$item->link;
        @endphp
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat">Link rss</button>
                </div>
                <input readonly id="link" type="text" value="{{$name}}" class="form-control" placeholder="Nhập link !">
                <span class="input-group-btn" id="button">
                    <a href="{{route('admin.tintuc.rss.del',['id'=>$rss_id])}}" onclick="return confirm('Bạn thực sự muốn xóa không ?')" class="btn btn-danger btn-flat">Xóa</a>
                </span>
            </div>
        @endforeach
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
    $('#click').click(function(){   
        $('#ajax_loader').css( 'display', 'block' );
            setTimeout(function(){
            $('#ajax_loader').css( 'display', 'none' );
        }, 20000);        
    });
    function active(tintuc_rss_id,danhmuc_id,tendanhmuc){
        swal({   
            title: "Bạn có muốn thêm tin tức này vào danh mục ''"+tendanhmuc+"'' không ?",
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "OK",   
            cancelButtonText: "Hủy",   
            closeOnConfirm: false,   
            }, 
            function(isConfirm){   
                if (isConfirm) {   
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{route('admin.tintuc.rss.move_tintuc')}}',
                        type: 'post',
                        cache: false,
                        data: {
                            tintuc_rss_id:tintuc_rss_id,
                            danhmuc_id:danhmuc_id
                        },
                        success: function(data){
                            $("#active"+tintuc_rss_id).html(data);
                            swal("Thêm thành công !","","success");
                        },
                        error: function (){
                            swal("Có lỗi xảy ra !","","error");
                        }
                    });
                }
            }
        );
    }
</script>
@endsection