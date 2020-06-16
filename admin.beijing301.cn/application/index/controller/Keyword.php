<?php
namespace app\index\controller;
use think\Controller;
class Keyword extends controller
{
    /**
     * 网址历时搜索
     */
    public function timesear($time,$url)
    {
        $created_at=$time;
        $created_at[20]=',';
        $created_at=explode(',', $created_at);
        $like = db('keyword')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->where('url','like',"%".$url."%")
            ->select();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => 10,
            'data' => $like
        ]; //封装layui需要的json格式
        return json($data);
    }
	   /**
    * 网址关键词统计
    * 默认查询昨天9点到今早9点的数据数据
    * 复制为0的不显示
    */
	   /*
	    * 网址备注点击修改功能
	    */
	   public function editbz($id,$bz)
       {
            $edis = db('keyword')->where('id',$id)->update(['bz'=>$bz]);
            if($edis){return json(['suc'=>200]);}
       }

    public function keyword($page,$limit)
    {
    	$user = db('keyword')
    	->page($page)
    	->limit($limit)
    	->where('created_at','>=',date('Y-m-d 09:00:00', strtotime("-1 day")))
        ->where('created_at','<=',date('Y-m-d 09:00:00', time()))
        ->where('copy','>=',1)
    	->select();

    	$ount = db('keyword')
   		->where('created_at','>=',date('Y-m-d 09:00:00', strtotime("-1 day")))
        ->where('created_at','<=',date('Y-m-d 09:00:00', time()))
        ->where('copy','>=',1)
        ->sum('copy');
        
    	$user['0']['copycount'] = $ount;//递增全部复制数
   		$users = db('keyword')
   		->where('created_at','>=',date('Y-m-d 09:00:00', strtotime("-1 day")))
        ->where('created_at','<=',date('Y-m-d 09:00:00', time()))
        ->where('copy','>=',1)
   		->count();
   		$data = [
				'code' => 0,
				'msg' => '',
				'count' => $users,
				'data' => $user
			]; //封装layui需要的json格式
			return json($data);
    }

    //今天9点到晚上12点的实时网址数据
    //复制为0不显示
    public function zuoday()
    {
    	$zuori = db('keyword')
    			->where('created_at','>=',date('Y-m-d 09:00:00', time()))
    			->where('created_at','<=',date('Y-m-d 23:59:59', time()))
    			->where('copy','>=',1)
    			->select();

		$ount = db('keyword')
   		->where('created_at','>=',date('Y-m-d 09:00:00', time()))
        ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
        ->sum('copy');
        
    	$zuori['0']['copycount'] = $ount;
    	$data = [
				'code' => 0,
				'msg' => '',
				'count' => count($zuori),
				'data' => $zuori
			]; //封装layui需要的json格式
			return json($data);
    }

    //查询出今天的这个网址的数据
    public function keyurl($keyurl)
    {
    	$like = db('keyword')
    	->where('url','like',"%".$keyurl."%")
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

    /*
     *记录网址关键词 
     *如果是新网站进来就创建新的记录
     *旧的网站就执行访问量+1
     */
     //1
     public function inserturl($url)
     {
     	//切割url 以确保url不被 重复
     	$urls = substr($url,0,25);
     	$min = date('Y-m-d 00:00:00', time());
     	
     	$isurl = db('keyword')
     	->where('url',$urls)
     	->where('created_at','>',$min)
     	->find();
     	//如果今天已经有这个网址了
     	if($isurl)
     	{
     		db('keyword')
     		->where('url',$isurl['url'])
     		->where('created_at','>',$min)
     		->setInc('shownum');//展示数+1
     	}else{
     		//若果是新的网址
     		$data = [
     			'url'=>$urls,
     			'shownum'=>1,
     			'copy'=>0,
     			'copyrate'=>'0',
     			'created_at'=>date('Y-m-d H:i:s')
     			];
     		db('keyword')->insert($data);
     	}
     }

     public function copyrate($url)
     {
         //截取URL
         $urls = substr($url,0,25);
         //查询出创建时间是今天的网址
     	$select = db('keyword')
     			->where('url',$urls)
     			->where('created_at','>',date('Y-m-d 00:00:00', time()))
     			->find();
         $min = date('Y-m-d 00:00:00', time());
     	if($select) {
            //如果这个网址存在就给他的复制+1
            db('keyword')
                ->where('url', $select['url'])
                ->where('created_at', '>', $min)
                ->setInc('copy');

                //修改时间为最新复制的时间
                db('keyword')
                    ->where('url', $select['url'])
                    ->where('created_at', '>', date('Y-m-d 00:00:00', time()))
                    ->update(
                        [
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);
            } else {
                //很少会走到这里 除非异常
                //也就是用户进来的时候 没有加载插入url的ajax
                $data = [
                    'url' => $urls,
                    'shownum' => 1,
                    'copy' => 0,
                    'copyrate' => '0',
                    'created_at' => date('Y-m-d H:i:s', time())
                ];
                db('keyword')->insert($data);
            }
        }


     public function ww()
     {
     	$url = "http://ccc2.pbazt.cn/?sg-0021107";
     	 echo substr($url,0,20);
     }
}