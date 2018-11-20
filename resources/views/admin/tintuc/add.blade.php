@extends('templates.admin.master')
@include('functions.indanhmuc')
@section('css')
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{$urlAdmin}}/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .loi{
            padding: 1px 7px;
            margin-bottom: 2px;
        }
    </style>
@endsection
<!-- Phan title -->
@section('name')
    Thêm tin tức
@endsection
<!-- Phan thong bao -->
@section('msg')
    @if(Session::has('msg'))
        <div class="alert alert-success alert-dismissible msg">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i>{{Session::get('msg')}}
        </div>
    @endif
@endsection
<!-- Phan noi dung chinh -->
@section('content')
@if ($errors->any())
    @php $loi=$errors->toArray(); @endphp
@endif
<div class="box box-warning">
    <!-- /.box-header -->
    <div class="box-body">
        <form action="{{route("admin.tintuc.add")}}" method="POST" enctype="multipart/form-data" role="form" style="margin: 30px 5% 30px 5%;">
            <!-- Ten tin tuc -->
            {{csrf_field()}}
            <div class="form-group">
                <label>Tên tin tức</label>
                @if ($errors->has('tentintuc'))
                <div class="alert alert-danger alert-dismissible loi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($loi['tentintuc'] as $error)
                        <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <input type="text" name="tentintuc" value="{{ old('tentintuc') }}" class="form-control" placeholder="Nhập tên tin tức ...">
            </div>
            <!-- Ten danh muc -->
            <div class="form-group">
                <label>Danh mục</label>
                @if ($errors->has('danhmuc_id'))
                <div class="alert alert-danger alert-dismissible loi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($loi['danhmuc_id'] as $error)
                        <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <select name="danhmuc_id" class="form-control">
                    <option value="">--Chọn danh mục--</option>
                    {{ indanhmuc($objDanhmuccha,$objDanhmuccon) }}
                </select>
            </div>
            <!-- hinh anh -->
            <div class="form-group">
                <label>Hình ảnh</label>
                @if ($errors->has('hinhanh'))
                <div class="alert alert-danger alert-dismissible loi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($loi['hinhanh'] as $error)
                        <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <input type="file" name="hinhanh"  value="{{ old('hinhanh') }}" class="form-control">
            </div>
            <!-- Gioi thieu -->
            <div class="form-group">
                <label>Giới thiệu</label>
                @if ($errors->has('gioithieu'))
                <div class="alert alert-danger alert-dismissible loi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($loi['gioithieu'] as $error)
                        <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <textarea name="gioithieu" class="form-control" rows="3" placeholder="Nhập giới thiệu tin tức...">{{old('gioithieu')}}</textarea>
            </div>
            <!-- Text -->
            <div class="form-group">
                <label>Text</label>
                @if ($errors->has('text'))
                <div class="alert alert-danger alert-dismissible loi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($loi['text'] as $error)
                        <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <textarea name="text" class="form-control" rows="3" placeholder="Nhập text tin tức...">{{old('text')}}</textarea>
            </div>
            <!-- Chi tiet -->
            <div class="form-group">
                <label>Chi tiết</label>
                @if ($errors->has('chitiet'))
                <div class="alert alert-danger alert-dismissible loi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($loi['chitiet'] as $error)
                        <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <textarea name="chitiet" class="form-control ckeditor" rows="3" placeholder="Nhập chi tiết tin tức...">
                {{old('chitiet')}}
                </textarea>
            </div>
            <!-- active -->
            <div class="form-group">
                @if ($errors->has('active'))
                <div class="alert alert-danger alert-dismissible loi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach ($loi['active'] as $error)
                        <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <label>
                    <input type="radio" name="active" id="optionsRadios1" value="0" @if(old("active")=="0")) checked @endif >
                    Ẩn
                </label>
                <label style="margin-left:25px;">
                    <input type="radio" name="active" id="optionsRadios2" value="1" @if(old("active")=="1")) checked @endif >
                    Hiện
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat">Thêm</button>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
</div>
@endsection
<!-- Phan modal -->
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

<script src="{{$urlAdmin}}/bower_components/ckeditor/ckeditor.js"></script>
<!-- page script -->
@endsection