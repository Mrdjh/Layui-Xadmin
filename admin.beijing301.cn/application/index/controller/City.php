<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class City extends controller
{

    public function ip($ip)
    {
//        $stream = fopen("log.txt", "a");fwrite($stream, "\n".$_SERVER["REMOTE_ADDR"]);
        $reasip = Db::name('city')
                    ->where('ip',$ip)
                    ->select();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => 10,
            'data' => $reasip
        ]; //封装layui需要的json格式
        return json($data);

    }
    public function datekey($time)
    {
        $created_at=$time;
        $created_at[20]=',';
        $created_at=explode(',', $created_at);
        $zuori = db('key')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->order('num desc')
            ->select();
        $zuoris = db('key')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->count();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => $zuoris,
            'data' => $zuori
        ]; //封装layui需要的json格式
        return json($data);
    }
	//百度关键词//增加展示数量
	public function logs($log='',$url)
	{
	    
        $newlog = urldecode($log);
        // $urls = substr($url,0,25);
        //截取尾椎处理
        $min = date('Y-m-d 00:00:00', time());
        $dblog = db('key')
            ->where('keyword',$newlog)
            ->where('url',$url)
            ->where('created_at','>',$min)
            ->find();
            
	    if($dblog)
        {
            db('key')
                ->where('keyword',$dblog['keyword'])
                ->where('url',$dblog['url'])
                ->where('created_at','>',$min)
                ->setInc('num');
        }else{
	        $data = [
	            'keyword'=>$newlog,
                'num'=>'1',
                'copy'=>'0',
                'created_at'=>date('Y-m-d H:i:s', time()),
                'url'=>$url
            ];
            db('key')->insert($data,true);
        }
	}
    public function logstz($url)
    {
        //截取尾椎处理
        $dblog = db('key')
            ->where('url',$url)
            ->where('created_at','>',date('Y-m-d 00:00:00', time()))
            ->find();
        //如果今天存在了这个链接
        if($dblog)
        {
            db('key')
                ->where('url',$dblog['url'])
                ->where('created_at','>',date('Y-m-d 00:00:00', time()))
                ->setInc('num');
        }else{
            $data = [
                'keyword'=>'跳转链接请查看url尾部',
                'num'=>'1',
                'copy'=>'0',
                'created_at'=>date('Y-m-d H:i:s', time()),
                'url'=>$url
            ];
            db('key')->insert($data,true);
        }
    }

	public function readlog($page,$limit)
    {
        $user = db('key')
            ->page($page)
            ->limit($limit)
            ->where('created_at','>=',date('Y-m-d 00:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
            ->order('copy desc')
            ->select();
        $users = db('key')
            ->where('created_at','>=',date('Y-m-d 00:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
            ->count();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' =>$users,
            'data' => $user
        ]; //封装layui需要的json格式
        return json($data);
    }
    //后台统计
    public function citys($page,$limit)
    {
        //默认查询出昨天9点到今天早上9点的数据
        $user = db('city')
            ->page($page)
            ->limit($limit)
            ->order('id desc')
//            ->where('created_at','>=',date('Y-m-d 00:00:00', time()))
//            ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
            ->select();
        //统计总数
        $users = db('city')
//            ->where('created_at','>=',date('Y-m-d 00:00:00', time()))
//            ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
            ->count();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => $users,
            'data' => $user
        ]; //封装layui需要的json格式
        return json($data);
    }

	public function getCity($copytext,$url,$ip,$city)
	{
        $urls = substr($url,0,25);
		$data = [
		    	'city'=>$city,//用户所在城市
		    	'ip'=>$ip,
		    	'copytext'=>$copytext,
		    	'created_at'=>date("Y-m-d H:i:s",time()),
		    	'url'=>$urls,
		    	];
		db('city')->insert($data,true);
	}

	public function selkey($key)
    {
        $like = db('key')
            ->where('keyword','like',"%".$key."%")
            ->where('created_at','>=',date('Y-m-d 00:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
            ->select();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => count($like),
            'data' => $like
        ];
        return json($data);
    }
}