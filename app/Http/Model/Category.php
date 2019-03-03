<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table      = 'category';
    protected $primaryKey = 'cate_id';
    public    $timestamps = false;
    protected $guarded    = [];

    /*public static function tree() {
        $categorys = Category::all();

        return (new Category)->getTree($categorys, 'cate_name', 'cate_id', 'cate_pid');
    }*/

    public function tree() {
        $categorys = $this->orderBy('cate_order', 'asc')->get();

        return $this->getTree($categorys, 'cate_name', 'cate_id', 'cate_pid');
    }

    public function getTree($data, $field_name, $field_id = 'id', $field_pid = 'pid', $pid = 0) {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v->$field_pid == $pid) {
                $data[$k]['_' . $field_name] = $data[$k][$field_name];
                $arr[] = $v;
                foreach ($data as $k1 => $v1) {
                    if ($v1->$field_pid == $v->$field_id) {
                        $data[$k1]['_' . $field_name] = '├── ' . $data[$k1][$field_name];
                        $arr[] = $v1;
                    }
                }
            }
        }
        return $arr;
    }


}
