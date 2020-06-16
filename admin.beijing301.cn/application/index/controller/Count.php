<?php
namespace app\index\controller;
use think\Controller;
class Count extends controller
{
	//后台统计
   public function counts($page,$limit)
   {
   	
   		//默认查询出昨天9点到今天早上9点的数据
   		$user = db('count')
   		->page($page)
   		->limit($limit)
   		->where('created_at','>=',date('Y-m-d 09:00:00', strtotime("-1 day")))
        ->where('created_at','<=',date('Y-m-d 09:00:00', time()))
   		->select();
		//统计总数
   		$users = db('count')
   		->where('created_at','>=',date('Y-m-d 09:00:00', strtotime("-1 day")))
        ->where('created_at','<=',date('Y-m-d 09:00:00', time()))
   		->count();
   		$data = [
				'code' => 0,
				'msg' => '',
				'count' => $users,
				'data' => $user
			]; //封装layui需要的json格式
		return json($data);
   		
   }
   
		//按微信号查询//mohuchaxun
       public function countwx($wx)
    {
    	//只查询昨天9点到今天9点的数据
    	//今天9点后的数据是默认查不到的
    	$like = db('count')
    	->where('wx','like',"%".$wx."%")
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

        //今天9点到当前时间的实时数据
    public function zuoday()
    {
    	$zuori = db('count')
    			->where('created_at','>=',date('Y-m-d 09:00:00', time()))
    			->where('created_at','<=',date('Y-m-d 23:59:59', time()))
    			->select();
		
		$ount = db('count')
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
    
   /**
    * 记录微信号被复制次数
    **/
	
   public function insertwx($wx,$url)
   {

   	   	//防空白操作
   	if($wx == '')
   	{
   		die();
   	}else{
        $urls = substr($url,0,25);
   	    //微信实时统计
   	    db('wxcopy')->insert(
   	        [
   	            'wx'=>$wx,
                'created_at'=>date('Y-m-d H:i:s', time()),
                'url'=>$urls
            ]
        );
    }

   	if(strlen($wx) < 5)
   	{
   		return false;
   	}elseif($wx == 'index.php'){
   		return false;
   	}
   	
  //查询出是否有这个微信号 并且这个微信号的创建时间早于今天的0点才是今天新建的

	   	$countwx = db('count')
	   	->where('wx',$wx)//微信号存在
	   	->where('created_at','>',date('Y-m-d 00:00:00', time()))
	   	->find();
	   	//如果有给这个微信号的copy次数+1
	   	if($countwx){
	   		$mins = date('Y-m-d H:i:s', time());
	   		 //    		db('count')
     		// ->where('wx',$countwx['wx'])
     		// ->where('created_at','>',date('Y-m-d 00:00:00', time()))
     		// ->update(
     		// 	[ 
     		// 		'created_at'=>$mins,
     		// 	]);
     	    // $stream = fopen("log.txt", "a");fwrite($stream, "\n".'修改了');
	   		db('count')
	   		->where('wx',$countwx['wx'])
	   		->where('created_at','>',date('Y-m-d 00:00:00', time()))
	   		->setInc('copy');//复制数+1
			
	   		//修改时间为最新复制的时间
     		db('count')
     		->where('wx',$countwx['wx'])
     		->where('created_at','>',date('Y-m-d 00:00:00', time()))
     		->update(
     			[
     				'created_at'=>$mins,
     			]);

	   	}else{
	   		// 如果没有 新建一个微信号初始值都为1
	   		$data = [
			   			'wx'=>$wx,
			   			'copy'=>1,
			   			'shownum'=>1,
			   			'created_at'=>date('Y-m-d H:i:s')
	   				];
			// $stream = fopen("log.txt", "a");fwrite($stream, "\n".'新增了');
	   		db('count')->insert($data,true);
	   	}
   }

   /**
    * 用户一进来就会执行
    * 记录微信号展示次数
    * 如果是新微信号就新增一条wx数据
    * 时间戳要大于今天9点的时间戳
    */
   public function shownum($wx)
   {
	   	$shownems = db('count')
	   	->where('wx',$wx)//微信号必须存在
	   	->where('created_at','>',date('Y-m-d 00:00:00', time()))//创建时间必须是今天的时间
	   	->find();
	   	if($shownems)
	   	{
	   		//展示次数+1
	   		db('count')
	   		->where('wx',$shownems['wx'])
	   		->where('created_at','>',date('Y-m-d 00:00:00', time()))
	   		->setInc('shownum');
		}else{
	   		$data = [
	   			'wx'=>$wx,
	   			'shownum'=>1,
	   			'created_at'=>date('Y-m-d H:i:s')//当前时间
	   			];
	   		db('count')->insert($data,true);
	   }
   }

   //设置微信号列表
    //后台统计
    public function wechat($page,$limit)
    {

        //默认查询出昨天9点到今天早上9点的数据
        $user = db('wechat')
            ->page($page)
            ->limit($limit)
            ->order('index desc')
            ->select();
        
        //统计总数
        $users = db('wechat')
            ->count();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => $users,
            'data' => $user
        ]; //封装layui需要的json格式
        return json($data);
    }
    //删除网址相关token微信号
    public function deltoken($id)
    {
        if(in_array('1',getUserAuto()))//判断用户是否有新增权限
        {
            $a = db('wechat')->where('id',$id)->delete();
            if($a)
            {
                return json(['suc'=>200]);
            }
        }else{
            return json(['err'=>400]);
        }
    }

    public function getWechat($token)
    {
//        var_dump($token);
        $data = db('wechat')->where('token',$token)->field('wechat')->find();
        if($data)
        {
            return json($data['wechat']);
        }

    }
    //新增网址微信号
    public function insertWechat($token,$wechat,$url)
    {
        if(in_array('1',getUserAuto()))//判断用户是否有新增权限
        {
            $data = [
                'token'=>$token,
                'url'=>$url,
                'wechat'=>$wechat
            ];
            $a = db('wechat')->insert($data);
            if($a)
            {
                return json(['suc'=>200]);
            }
        }else{
            return json(['err'=>400]);
        }

    }
    //修改数据
    public function upwechat($token,$wechat,$id,$url)
    {
        if(in_array('1',getUserAuto()))//判断用户是否有新增权限
        {
            $data = [
                'token'=>$token,
                'wechat'=>$wechat,
                'url'=>$url
            ];
            db('wechat')->where('id',$id)->update($data);
            return json(['suc'=>200]);
        }else{
            return json(['err'=>400]);
        }

    }
    //获取指定微信号
   public function setWechat($token)
   {
       return db('wechat')->where('token',$token)->field('wechat')->find();
   }

   //置顶功能
    public function upindex($id,$index)
    {
        $index= db('wechat')->where('id',$id)->update(['index'=>$index]);
        if($index){return json(['suc'=>200]);}
    }

}

