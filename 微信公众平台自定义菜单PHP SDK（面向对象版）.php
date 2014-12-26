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

	//微信公众平台自定义菜单PHP SDK  （面向对象版）

	class Weichat_menu_api{

		private $appid;
		private $appsecret;
		//构造函数
		public function __construct($appid,$appsecret)
		{
			$this->appid = $appid;
			$this->appsecret = $appsecret;
		}

		//获取access_token（支持自动更新凭证）
		public function get_access_token()
		{
			$this->last_time = 1408851194;
			$access_token = "jIGpovtFGZDXCB_K2vqDPTA05zP7VWZaKIHXC_qZDqEiSGONWfCzQ45fI9aksl2L188yhtPpNB61iOBS4TTtgw";

			if(time() > ($this->last_time + 7200))
			{
				//GET请求的地址
				$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
		 		$access_token_Arr =  $this->https_request($url);
		 		$this->last_time = time();
		 		return $access_token_Arr['access_token'];			
			}

			return $access_token;
		}


		//https请求（支持GET和POST）
		protected function https_request($url,$data = null)
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
		public function menu_create($data)
		{
			$access_token = $this->get_access_token();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
			return $this->https_request($url,$data);
		}

		//查询菜单
		public function menu_select()
		{
			$access_token = $this->get_access_token();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
			return $this->https_request($url);
		}

		//删除菜单

		public function menu_delete()
		{
			$access_token = $this->get_access_token();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access_token}";
			return $this->https_request($url);
		}
	}