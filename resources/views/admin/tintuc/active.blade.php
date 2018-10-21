<center>
@if($req->active==0)
    <a onclick="active('1','{{$req->tintuc_id}}')" class="btn btn-primary">Hiện thị</a>
@else
    <a onclick="active('0','{{$req->tintuc_id}}')" class="btn btn-danger">Đã ẩn</a>
@endif
</center>