@php
    $danhmuc_id=$objItem->danhmuc_id;
    $tendanhmuc=$objItem->tendanhmuc;
    $sapxep=$objItem->sapxep;
    $parent_id=$objItem->parent_id;
@endphp
<div class="input-group">
    <div class="input-group-btn">
        <button type="button" class="btn btn-primary btn-flat">Tên danh mục</button>
    </div>
    <input id="tendanhmuc" type="text" value="{{$tendanhmuc}}" class="form-control" placeholder="Nhập tên">

    <div class="input-group-btn">
        <button type="button" class="btn btn-primary btn-flat">Sắp xếp</button>
    </div>
    <input id="sapxep" type="number" value="{{$sapxep}}" min=0 class="form-control" placeholder="Nhập số">
    <input style="display:none;" id="parent_id" type="number" value="{{$parent_id}}" min=1 class="form-control" placeholder="Nhập số">
    <span class="input-group-btn" id="button">
        <button onclick="edit('{{$danhmuc_id}}')" type="button" class="btn btn-success btn-flat">Sửa</button>
    </span>
</div>