<?php
namespace app\index\controller;
use think\Controller;
use app\common\JWT\JWT;
class Login extends controller
{
   public function dologin()
   {
   	$dousername = db('user')->where('username',input('username'))->find();
   	if(!$dousername)
   	{
   		return '无此用户或已被管理员禁用';
   	}else{
   		if($dousername['password'] == md5(input('password')))
   		{
   			// cookie();
   			$payload_test=array(
	   					'iss'=>$dousername['username'],
			    		'iat'=>time(),
			    		'exp'=>time()+7200,
			    		'nbf'=>time(),
			    		'sub'=>'301.php314.cn',
			    		'jti'=>md5(uniqid('JWT').time()));
	    	$token_test=Jwt::getToken($payload_test);
	    
   			cookie('username',input('username'));
   			// var_dump(session('username'));
   			return json(['suc'=>200]);
   		}else{
   			return json(['suc'=>400]);
   		}
   	}
   		
   }
   
   //生成
   public function login()
   {
	   	$payload_test=array(
	   					'iss'=>'admin',
			    		'iat'=>time(),
			    		'exp'=>time()+7200,
			    		'nbf'=>time(),
			    		'sub'=>'301.php314.cn',
			    		'jti'=>md5(uniqid('JWT').time()));
	    $token_test=Jwt::getToken($payload_test);
	    var_dump($token_test);
   }
   
   //Jwt验证
   public function vielogin($token_test)
   {
   		$getPayload_test=Jwt::verifyToken($token_test);
	    echo "<br><br>";
	    var_dump($getPayload_test);
	    echo "<br><br>";
   }
}
