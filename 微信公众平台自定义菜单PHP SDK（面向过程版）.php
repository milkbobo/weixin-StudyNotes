<?php
	/**
	 * 
	 * @authors 云知梦-军哥
	 * @email zhanglijun@lampym.com
	 * @date    2014-08-24 10:56:49
	 * @link    http://www.lampym.com
	 * @version 1.0
	 * @course 《军哥带你玩转微信开发》系列教程之初级篇
	 */

	//微信公众平台自定义菜单PHP SDK  （面向过程）

	define("APPID","");
	define("APPSECRET","");

	//获取access_token（支持自动更新凭证）
	function get_access_token()
	{
		static $last_time = 1408851194;
		$access_token = "jIGpovtFGZDXCB_K2vqDPTA05zP7VWZaKIHXC_qZDqEiSGONWfCzQ45fI9aksl2L188yhtPpNB61iOBS4TTtgw";

		if(time() > ($last_time + 7200))
		{
			//GET请求的地址
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={APPID}&secret={APPSECRET}";
	 		$access_token_Arr =  https_request($url);
	 		$last_time = time();
	 		return $access_token_Arr['access_token'];			
		}

		return $access_token;
	}


	//https请求（支持GET和POST）
	function https_request($url,$data = null)
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(!empty($data))
		{
			curl_setopt($ch,CURLOPT_POST,1);//模拟POST
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//POST内容
		}
		$outopt = curl_exec($ch);
		curl_close($ch);
		$outopt = json_decode($outopt,true);
		return $outopt;
	}

	//创建菜单
	function menu_create($data)
	{
		$access_token = get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
		return https_request($url,$data);
	}

	//查询菜单
	function menu_select()
	{
		$access_token = get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
		return https_request($url);
	}

	//删除菜单

	function menu_delete()
	{
		$access_token = get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access_token}";
		return https_request($url);
	}
