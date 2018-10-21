@if(Session::has('url'))
<script type="text/javascript">
	window.location.href="{{Session::get('url')}}";
</script>
@else
<div class="alert alert-danger alert-dismissible msg_modal">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-ban"></i>Tên danh mục đã được sử dụng
</div>
@endif