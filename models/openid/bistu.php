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

class openid_bistu_class extends AWS_MODEL
{
	function check_bistu_id($bistu_id)
	{
		return $this->count('users_bistu', "userid = '" . $this->quote($bistu_id) . "'");
	}

	function get_users_bistu_by_id($bistu_id)
	{
		return $this->fetch_row('users_bistu', "userid = '" . $this->quote($bistu_id) . "'");
	}

	function get_users_bistu_by_uid($uid)
	{
		return $this->fetch_row('users_bistu', 'uid = ' . intval($uid));
	}

	function update_token($userid, $access_token)
	{
		return $this->update('users_bistu', array(
			'access_token' => serialize($this->quote($access_token)),
			//'oauth_token' => $this->quote($access_token), 
			//'oauth_token_secret' => $this->quote($oauth_token_secret)
		), "userid = '" . $this->quote($userid) . "'");
	}

	function del_users_by_uid($uid)
	{
		return $this->delete('users_bistu', 'uid = ' . intval($uid));
	}

	function users_bistu_add($userid, $uid, $username, $profile_image_url, $gender)
	{		
		if (! $uid or ! $userid)
		{
			return false;
		}
		
		$data['userid'] = $userid;
		$data['uid'] = intval($uid);
		$data['username'] = htmlspecialchars($username);
		$data['profile_image_url'] = '';
		$data['idtype'] = htmlspecialchars($idtype);
		$data['add_time'] = time();
		
		return $this->insert('users_bistu', $data);
	
	}

	function bind_account($bistu_profile, $redirect, $uid, $is_ajax = false)
	{		
		if ($openid_info = $this->get_users_bistu_by_uid($uid))
		{
			if ($openid_info['id'] != $bistu_profile['userid'])
			{
				if ($is_ajax)
				{
					H::ajax_json_output(AWS_APP::RSM(null, '-1', AWS_APP::lang()->_t('此账号已经与另外一个 Bistu 绑定')));
				}
				else
				{
					H::redirect_msg(AWS_APP::lang()->_t('此账号已经与另外一个 Bistu 绑定'), '/account/logout/');
				}
			
			}
		}
		
		if (! $user_bistu = $this->get_users_bistu_by_id($bistu_profile['userid']))
		{
			$this->users_bistu_add($bistu_profile['userid'], $uid, $bistu_profile['username'], '', $bistu_profile['idtype']);
		
		}
		else if ($user_bistu['uid'] != $uid)
		{
			if ($is_ajax)
			{
				H::ajax_json_output(AWS_APP::RSM(null, '-1', AWS_APP::lang()->_t('此账号已经与另外一个 Bistu 绑定')));
			}
			else
			{
				H::redirect_msg(AWS_APP::lang()->_t('此账号已经与另外一个 Bistu 绑定'), '/account/setting/openid/');
			}
		}
		
		if (AWS_APP::session()->bistu_token['access_token'])
		{
			$this->update_token($bistu_profile['userid'], AWS_APP::session()->bistu_token['access_token']);
		}
		
		if ($redirect)
		{
			HTTP::redirect($redirect);
		}
	}
}
	