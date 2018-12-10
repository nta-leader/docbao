<?php

namespace App\Model\Admin\Users;

use Illuminate\Database\Eloquent\Model;

class AuModel extends Model
{
    protected $table="users";
    protected $primarKey="id";
    public $timestamps=false;

    public function getItems(){
        return $this->orderBy('id')->get();
    }
    public function getItem($id){
        return $this->findOrFail($id);
    }
    public function add($arItem){
        return $this->insert($arItem);
    }
    public function edit($id,$arItem){
        return $this->where('id',$id)->update($arItem);
    }
    public function del($id){
        return $this->where('id',$id)->delete();
    }
}
