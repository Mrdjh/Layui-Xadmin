<?php
namespace app\index\controller;
use think\Controller;
class Time extends controller
{
    public function dateurl($time,$url,$page,$limit)
    {
        $user = db('wxcopy')
            ->where('created_at','>=',$time.' '.'00:00:00')
            ->where('created_at','<=',$time.' '.'23:59:59')
            ->where('url','like',"%".$url."%")
            ->page($page)
            ->limit($limit)
            ->order('created_at desc')
            ->select();
        $users = db('wxcopy')
            ->where('created_at','>=',$time.' '.'00:00:00')
            ->where('created_at','<=',$time.' '.'23:59:59')
            ->where('url','like',"%".$url."%")
            ->count();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => $users,
            'data' => $user
        ]; //封装layui需要的json格式
        return json($data);

    }
    public function wxcopy($page,$limit)
    {
        //默认查询出昨天9点到今天早上9点的数据
        $user = db('wxcopy')
            ->page($page)
            ->limit($limit)
            ->order('id desc')
//            ->where('created_at','>=',date('Y-m-d 09:00:00', strtotime("-1 day")))
//            ->where('created_at','<=',date('Y-m-d 09:00:00', time()))
            ->select();
        //统计总数
        $users = db('wxcopy')
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

    public function wxcopydate($time,$wx,$page,$limit)
    {
        $created_at=$time;
        $created_at[20]=',';
        $created_at=explode(',', $created_at);
        $zuori = db('wxcopy')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->where('wx','like',"%".$wx."%")
            ->page($page)
            ->limit($limit)
            ->order('id desc')
            ->select();
        $zuoris = db('wxcopy')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->where('wx','like',"%".$wx."%")
            ->select();
        $ount = db('wxcopy')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->where('wx','like',"%".$wx."%")
            ->sum('num');

        $zuori['0']['copycount'] = $ount;
            $data = [
                'code' => 0,
                'msg' => '',
                'count' => count($zuoris),
                'data' => $zuori
            ]; //封装layui需要的json格式
            return json($data);
    }
	public function slects($time)
	{
		$created_at=$time;
		$created_at[20]=',';
		$created_at=explode(',', $created_at);
		$timeer = 
			db('count')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->where('copy','>=',1)
            ->select();
        $data = [
			'code' => 0,
			'msg' => '',
			'count' => 20,
			'data' => $timeer
		]; //封装layui需要的json格式
		return json($data);
	}
	
	//日期筛选功能
	public function keyslects($time)
	{
		$created_at=$time;
		$created_at[20]=',';
		$created_at=explode(',', $created_at);
		$timeer = 
			db('keyword')
            ->where('created_at','>=',$created_at['0'])
            ->where('created_at','<=',$created_at['1'])
            ->where('copy','>=',1)
            ->select();
        $data = [
			'code' => 0,
			'msg' => '',
			'count' => 20,
			'data' => $timeer
		]; //封装layui需要的json格式
		return json($data);
	}
	
	//定时删除垃圾微信号
	public function deletes()
	{
		db('count')->where('wx','wx')->delete();
		
	}

	//删除多余0点数据
	public function deltw()
    {
        $del = db('keyword')
            ->where('created_at',date('Y-m-d 00:00:00', time()))
            ->delete();
        if($del)
        {
            $stream = fopen("log.txt", "a");
            fwrite($stream, "\n"."删除了一次异常");
        }else{
            $stream = fopen("log.txt", "a");
            fwrite($stream, "\n"."今天并没有出现异常哦");
        }

    }

	//定时删除未被复制的网址
	public function delzero()
	{
		db('keyword')->where('copy','0')->delete();
	}
	
	public function kk()
	{
		db('keyword')
		->where('created_at','2020-04-15 10:20:02')
		->where('url','http://yue11.kmlaikou.cn/')
		->delete();
	}
}