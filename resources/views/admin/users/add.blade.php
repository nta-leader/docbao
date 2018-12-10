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
    Thêm user
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
        <form action="{{route("admin.users.add")}}" method="POST" enctype="multipart/form-data" role="form" style="margin: 30px 5% 30px 5%;">
            <!-- username -->
            {{csrf_field()}}
            <div style="width: 45%;float: left;margin-right: 5%;">
                <div class="form-group">
                    <label>Username</label>
                    @if ($errors->has('username'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['username'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Nhập username ...">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    @if ($errors->has('password'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['password'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <input type="password" name="password" value="" class="form-control" placeholder="Nhập password ...">
                </div>
                <div class="form-group">
                    <label>Nhập lại password</label>
                    @if ($errors->has('rpassword'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['rpassword'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <input type="password" name="rpassword" value="" class="form-control" placeholder="Nhập lại password ...">
                </div>
                <div class="form-group">
                    <label>Họ tên</label>
                    @if ($errors->has('fullname'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['fullname'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <input type="text" name="fullname" value="{{ old('fullname') }}" class="form-control" placeholder="Nhập Họ tên ...">
                </div>
            </div>    
            <div style="width: 50%;float: left;">
                <div class="form-group">
                    <label>SDT</label>
                    @if ($errors->has('phone'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['phone'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Nhập SDT ...">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    @if ($errors->has('email'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['email'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Nhập email ...">
                </div>
                <div class="form-group">
                    <label>Facebook</label>
                    @if ($errors->has('facebook'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['facebook'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <input type="text" name="facebook" value="{{ old('facebook') }}" class="form-control" placeholder="Nhập link facebook ...">
                </div>
                <!-- active -->
                <div class="form-group">
                    <label>Trạng thái</label><br>
                    @if ($errors->has('active'))
                    <div class="alert alert-danger alert-dismissible loi">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($loi['active'] as $error)
                            <p><i class="icon fa fa-ban"></i>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-control">
                        <label style="color:#00a65a;">
                            <input type="radio" name="active" id="optionsRadios1" value="1" @if(old("active")=="0")) checked @endif >
                            Hoạt động
                        </label>
                        <label style="margin-left:25px;color:red;">
                            <input type="radio" name="active" id="optionsRadios2" value="0" @if(old("active")=="1")) checked @endif >
                            Khóa
                        </label>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
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