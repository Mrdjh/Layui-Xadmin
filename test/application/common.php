<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function getCity()
    {
		//配置您申请的appkey
		$appkey = "fdcd5279cb7c7834bec7f75c119737df";
		
		function juhecurl($url,$params=false,$ispost=0){
		  $httpInfo = array();
		  $ch = curl_init();
		
		  curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		  curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
		  curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
		  curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
		  curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		  if( $ispost )
		  {
		      curl_setopt( $ch , CURLOPT_POST , true );
		      curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
		      curl_setopt( $ch , CURLOPT_URL , $url );
		  }
		  else
		  {
		      if($params){
		          curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
		      }else{
		          curl_setopt( $ch , CURLOPT_URL , $url);
		      }
		  }
		  $response = curl_exec( $ch );
		  if ($response === FALSE) {
		      //echo "cURL Error: " . curl_error($ch);
		      return false;
		  }
		  $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		  $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		  curl_close( $ch );
		  return $response;
		}
		//************1.根据IP/域名查询地址************
		$url = "http://apis.juhe.cn/ip/ip2addr";
		$ip=$_SERVER["REMOTE_ADDR"];//获取当前ip
		$params = array(
		    "ip" => $ip,//需要查询的IP地址或域名
		    "key" => $appkey,//应用APPKEY(应用详细页查询)
		    "dtype" => "",//返回数据的格式,xml或json，默认json
		);
		$paramstring = http_build_query($params);
		$content = juhecurl($url,$paramstring);
		// $result = json_decode($content,true);
		if($content){
		    //  json_decode($content,true);
		    $arr = json_decode($content);
		    // $city = $arr->result->area;
		    return $arr;
		}else{
		  return false;
		}
    }
/**
 * 获取当前登录用户的权限
 */
function getUserAuto()
{
    $user = db('user')->where('username',cookie('username'))->field('user_power')->find();
    $userAuto = explode(',', $user['user_power']);//分割字符串中用逗号隔开的数据 分割成数组形式
    return $userAuto;
}
