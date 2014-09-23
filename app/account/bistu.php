<?php
/*
+--------------------------------------------------------------------------
|   WeCenter [#RELEASE_VERSION#]
|   ========================================
|   by Jason Zhu
|   © 2014 idefs.com. All Rights Reserved
|   http://www.idefs.com
|   ========================================
|   Support: root@idefs.com
|   
+---------------------------------------------------------------------------
*/


if (!defined('IN_ANWSION'))
{
	die;
}

class bistu extends AWS_CONTROLLER
{
	public function get_access_rule()
	{
		$rule_action['rule_type'] = 'white'; //黑名单,黑名单中的检查  'white'白名单,白名单以外的检查
		$rule_action['actions'] = array();
		
		return $rule_action;
	}
	
	public function setup()
	{
		if (get_setting('bistu_oauth_enabled') != 'Y')
		{
			die;
		}
	}

	function binding_action()
	{
		$oauth = new Services_Bistu_BistuOAuth(get_setting('bistu_akey'), get_setting('bistu_skey'));
		
		HTTP::redirect($oauth->getAuthorizeURL(get_js_url('/account/bistu/binding_callback/')));
	}

	function binding_callback_action()
	{	
		$oauth = new Services_Bistu_BistuOAuth(get_setting('bistu_akey'), get_setting('bistu_skey'));
		
		AWS_APP::session()->bistu_token = $oauth->getAccessToken('code', array(
			'code' => $_GET['code'],
			'redirect_uri' => get_js_url('/account/bistu/binding_callback/')
		));
		
		$client = new Services_Bistu_BistuClient(get_setting('bistu_akey'), get_setting('bistu_skey'), AWS_APP::session()->bistu_token['access_token']);
		
		$bistu_profile = $client->account_profile_basic();
		
		if ($bistu_profile['error'])
		{
			H::redirect_msg(AWS_APP::lang()->_t('与微博通信出错, 错误代码: %s', $bistu_profile['error']), "/account/setting/openid/");
		}
		
		if (!$this->model('integral')->fetch_log($this->user_id, 'BIND_OPENID'))
		{
			$this->model('integral')->process($this->user_id, 'BIND_OPENID', round((get_setting('integral_system_config_profile') * 0.2)), '绑定 OPEN ID');
		}
		
		$this->model('openid_bistu')->bind_account($bistu_profile, get_js_url('/account/setting/openid/'), $this->user_id);
	
	}

	function del_bind_action()
	{
		$this->model('openid_bistu')->del_users_by_uid($this->user_id);
		
		HTTP::redirect("/account/setting/openid/");
	}
}
	