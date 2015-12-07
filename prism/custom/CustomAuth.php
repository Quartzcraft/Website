<?php
/**
 *
 * This is an example of how you can write a custom
 * authorization class, so that you can bridge your
 * own systems with the Prism web ui.
 *
 * Essentially, make sure your custom auth file is
 * included from the config, extend the primary auth
 * file, and override the authenticator.
 *
 * This example will pretend we're loading users from
 * an existing database, like forum software.
 */
class CustomAuth extends Auth {


    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function authUser( $username, $password ) {

        // Just check if the config says we should even auth people
        if(!REQUIRE_AUTH) return true;

        // Here you'd run a query to your private system
        // authenticating the username/password

        if($this::_authXF($username, $password)) {

            // If this page returns true, the login system will auto set
            // a hash and the username entered to the form, so that we
            // remember the session for the user.

            return true;

        }
        return false;
    }

	private function _authXF($username, $password) {
		$post_url = XenAPI_URL;
		$post_data = array('action' => 'authenticate',
		                   'username'  => $username,
		                   'password'  => $password);
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $post_url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($handle);
		$http_status_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		$json_decode = json_decode($output, true);
		if ($http_status_code == 200) {
		    if($this::_checkPerms($username, $json_decode['hash'])) {
				return true;
			} else {
				return false;
			}
		} else {
		    return false;
		}
	}
	
	private function _checkPerms($username, $hash) {
		$post_url = XenAPI_URL;
		$post_data = array('action' => 'getUser',
		                   'hash'  => $username . ':' . $hash);
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $post_url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($handle);
		$http_status_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		$json_decode = json_decode($output, true);
		if ($http_status_code == 200) {
			if($this::_hasCorrectPerms($json_decode['primary_group_id'])) {
				return true;
			}
								
			$secondary_group_ids = explode ( ",", $json_decode['secondary_group_ids']);
			foreach ($secondary_group_ids as $key) {
				if($this::_hasCorrectPerms($key)) {
					return true;
				}
			}
					
			return false;
		} else {
			return false;
		}
	}
				
	private function _hasCorrectPerms($groupId) {
		$groups_access = explode(",", GROUPS_WITH_ACCESS);
		foreach ($groups_access as $group) {
			if($groupId == $group) {
				return true;
			}
		}
		return false;
	}
}
