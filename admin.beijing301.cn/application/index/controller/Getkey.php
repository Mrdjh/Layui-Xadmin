<?php
namespace app\index\controller;
use think\Controller;
class Getkey extends controller
{
    
    //----------不跳转
    //正常附带log的跑法复制+1
    public function Nokey($key,$url)
    {
        $Nokey = db('key')
            ->where('url',$url)
            ->where('created_at','>',date('Y-m-d 00:00:00', time()))
            ->find();
        if($Nokey)
        {
            db('key')
                ->where('url',$Nokey['url'])
                ->where('created_at','>',date('Y-m-d 00:00:00', time()))
                ->setInc('copy');
            db('key')
                ->where('url', $Nokey['url'])
                ->where('created_at', '>', date('Y-m-d 00:00:00', time()))
                ->update(
                    [
                        'created_at' => date('Y-m-d H:i:s', time())
                    ]);
        }else{
            $data = [
                'keyword'=>urldecode($key),
                'num'=>'1',
                'created_at'=>date('Y-m-d H:i:s', time()),
                'copy'=>'1',
                'url'=>$url
            ];
            db('key')->insert($data);
        }
    }
    //自带log不跳转的访问+1
    public function havekeynum($log='',$url)
    {
        $ave = db('key')
            ->where('url',$url)
            ->where('created_at','>',date('Y-m-d 00:00:00', time()))
            ->find();
        if($ave)
        {
            db('key')
                ->where('url',$url)
                ->where('created_at','>',date('Y-m-d 00:00:00', time()))
                ->setInC('num');
        }else{
            $data = [
                'keyword'=>urldecode($log),
                'num'=>'1',
                'created_at'=>date('Y-m-d H:i:s', time()),
                'copy'=>'0',
                'url'=>$url
            ];
            db('key')->insert($data);
        }
    }

    //-----------------跳转
    //跳转跑法复制+1
    public function getkey($url)
    {
        //查询今天是否有这个关键词
        $getkey = db('key')
            ->where('url',$url)
            ->where('created_at','>',date('Y-m-d 00:00:00', time()))
            ->find();

        if($getkey)
        {
            db('key')
                ->where('url',$getkey['url'])
                ->where('created_at','>',date('Y-m-d 00:00:00', time()))
                ->setInc('copy');
            db('key')
                ->where('url', $getkey['url'])
                ->where('created_at', '>', date('Y-m-d 00:00:00', time()))
                ->update(
                    [
                        'created_at' => date('Y-m-d H:i:s', time())
                    ]);
        }else{
            $data = [
                'keyword'=>'跳转链接,关键词请查看url尾部',
                'num'=>'1',
                'created_at'=>date('Y-m-d H:i:s', time()),
                'copy'=>'1',
                'url'=>$url
            ];
            db('key')->insert($data);
        }
    }
    //跳转跑法访问+1
    public function nokeynum($url)
    {
        $nokeynum = db('key')
            ->where('url',$url)
            ->where('created_at','>',date('Y-m-d 00:00:00', time()))
            ->find();
        if($nokeynum)
        {
            db('key')
                ->where('url',$nokeynum['url'])
                ->where('created_at','>',date('Y-m-d 00:00:00', time()))
                ->setInc('num');
        }else{
            $data = [
                'keyword'=>'跳转链接,关键词请查看url尾部',
                'num'=>'1',
                'created_at'=>date('Y-m-d H:i:s', time()),
                'copy'=>'0',
                'url'=>$url
            ];
            db('key')->insert($data);
        }
    }

}