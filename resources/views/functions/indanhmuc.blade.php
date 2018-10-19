<?php
function indanhmuc($danhmuccha,$danhmuccon,$danhmuc_id=0){
    foreach($danhmuccha as $cha){
?>     
        <option @if( old('danhmuc_id') == $cha->danhmuc_id || $danhmuc_id == $cha->danhmuc_id ) selected @endif value="{{$cha->danhmuc_id}}">{{$cha->tendanhmuc}}</option>
<?php
        foreach($danhmuccon as $con){
            if($cha->danhmuc_id==$con->parent_id){
?>
                <option @if( old('danhmuc_id') == $con->danhmuc_id || $danhmuc_id == $con->danhmuc_id ) selected @endif  value="{{$con->danhmuc_id}}">--| {{$con->tendanhmuc}}</option>
<?php
            }
        }
    }
}