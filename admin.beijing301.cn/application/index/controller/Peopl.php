<?php
namespace app\index\controller;
use think\Controller;
class Peopl extends controller
{
    public function getPeopl()
    {
        $user = db('peopl')->select();
        $users = db('peopl')->count();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => $users,
            'data' => $user
        ]; //封装layui需要的json格式
        return json($data);
    }
    public function editPeopl($id,$class,$name,$fink,$wechat,$cate,$count,$countmoney,$catemoney)
    {
        $data = [
            'class'=>$class,
            'name'=>$name,
            'fink'=>$fink,
            'wechat'=>$wechat,
            'cate'=>$cate,
            'count'=>$count,
            'countmoney'=>$countmoney,
            'catemoney'=>$catemoney,
        ];

        if(db('peopl')->where('id',$id)->update($data)){
            return json(['suc'=>200]);
        }else{
            return json(['err'=>400]);
        }
    }
    public function addPeopl($class,$name,$fink,$wechat,$cate,$count,$countmoney,$catemoney)
    {
        $data = [
            'class'=>$class,
            'name'=>$name,
            'fink'=>$fink,
            'wechat'=>$wechat,
            'cate'=>$cate,
            'count'=>$count,
            'countmoney'=>$countmoney,
            'catemoney'=>$catemoney,
            'createtime'=>date("Y-m-d H:i:s",time()),
        ];

        if(db('peopl')->insert($data)){
            return json(['suc'=>200]);
        }else{
            return json(['err'=>400]);
        }
    }
    public function delPeopl($id)
    {
        if(db('peopl')->where('id',$id)->delete())
        {
            return json(['suc'=>200]);
        }else{
            return json(['err'=>400]);
        }

    }
}