<?php
namespace app\index\controller;
use think\Controller;
use app\common\Daixs;
use app\common\Kpl\Kpl;
use \think\Request;
class Index extends controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function test()
    {
    	//访问数组格式
    	$data = [
		    		['value'=>'22',
		    		'name'=>'直接访问'
		    		],
		    		['value'=>'44',
		    		'name'=>'邮件营销',
		    		],
		    		['value'=>'99',
		    		'name'=>'联盟广告',
		    		],
		    		['value'=>'88',
		    		'name'=>'视频广告'
		    		],
		    		['value'=>'99',
		    		'name'=>'搜索引擎',
		    		]
    		];
    	return json($data);
    }

    //查询今天0-24每小时的复制量
    public function kpl()
    {
       return json(Kpl::todayKpl());
    }

    //查询用户提供的天数0-24小时的服质量
    public function lastkpls($date)
    {
       return json(Kpl::lastDay($date));
    }

    //定时插入当前时间的访问量
    public function hour()
    {
        //先查出全部展示
        $show = db('keyword')
                ->where('created_at','>=',date('Y-m-d 00:00:00', time()))
                ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
                ->sum('shownum');

        $data = [
            'show'=>$show,
            'time'=>date('Y-m-d H:i:s')
        ];

        db('hour')->insert($data);
    }
    public function shownum()
    {
        return json(Kpl::CountShow());
    }
    public function pvu()
    {
    	$data = [
                $pv=[1,2,3,4,5,6,7],
                $pu=[7,6,5,4,3,2,1],
    		];
    	return json($data);
    }
    public function tests()
    {
    	$data = ['test'=>'test'];
    	// $a = new Daixs();
    	$b = Daixs::test($data);
    	
    }

    /**
     * 文件上传
     */
    public function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
        $reubfo = array();  //定义一个返回的数组
        if($info){
            $reubfo['code']= 1;
            $reubfo['savename'] = "/upload/".$info->getSaveName();
        }else{
            // 上传失败获取错误信息
            $reubfo['code']= 0;
            $reubfo['err'] = $file->getError();
        }
        return json($reubfo);

    }

}
