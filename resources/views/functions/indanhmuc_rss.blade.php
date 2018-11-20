<?php
function indanhmuc($danhmuccha,$danhmuccon,$tintuc_rss_id){
    foreach($danhmuccha as $cha){
?>     
        <li  class="btn btn-block btn-primary btn-sm list_rss" onclick="active('{{$tintuc_rss_id}}','{{$cha->danhmuc_id}}','{{$cha->tendanhmuc}}')">{{$cha->tendanhmuc}}</li>
<?php
        foreach($danhmuccon as $con){
            if($cha->danhmuc_id==$con->parent_id){
?>
                <li class="btn btn-block btn-primary btn-sm list_rss" onclick="active('{{$tintuc_rss_id}}','{{$con->danhmuc_id}}','{{$con->tendanhmuc}}')">--| {{$con->tendanhmuc}}</li>
<?php
            }
        }
    }
}