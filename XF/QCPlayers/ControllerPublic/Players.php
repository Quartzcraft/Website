<?php

class QCPlayers_ControllerPublic_Players extends XenForo_ControllerPublic_Abstract {

	public function actionIndex() {
		$options = XenForo_Application::get('options');

		if(!XenForo_Visitor::getInstance()->hasPermission('players', 'view') || !$options->displayPlayers && !XenForo_Visitor::getInstance()->isSuperAdmin()) {
			return $this->responseNoPermission();
		}
		
		$mod_raw = file_get_contents($options->restApiUrl . 'player.php?action=getMods&value=name');
		$ss_raw = file_get_contents($options->restApiUrl . 'player.php?action=getSS&value=name');
		$newest_raw = file_get_contents($options->restApiUrl . 'player.php?action=getNewestPlayers&limit=18&value=name');
		$number_raw = file_get_contents($options->restApiUrl . 'player.php?action=getNumPlayers');
				
		$mods = array();
		$ss = array();
		$newest = array();
		
		while ($name = json_decode($mod_raw, true)) {
			array_push($mods, $name);
		}
		
		while ($name = json_decode($ss_raw, true)) {
			array_push($ss, $name);
		}
		
		while ($name = json_decode($newest_raw, true)) {
			array_push($newest, $name);
		}
		
		$viewParams = array(
			'mods' => $mods,
			'ss' => $ss,
			'newest' => $newest,
			'number' => json_decode($number_raw, true)['number']
		);
		
		return $this->responseView('QCPlayers_ViewPublic_Players_Index', 'player_index', $viewParams);
	}
	
	public function actionStaff() {
		$options = XenForo_Application::get('options');

		if(!XenForo_Visitor::getInstance()->hasPermission('players', 'view') || !$options->displayPlayers && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayStaffList && !XenForo_Visitor::getInstance()->isSuperAdmin()) {
			return $this->responseNoPermission();
		}
		
		/* Set the ID of the post to be loaded */
		$postId = $options->applyStaffPostId;
				
		/* Create a new ControllerHelper that will help us to get the post */
		$ftpHelper = new XenForo_ControllerHelper_ForumThreadPost($this);

		/* Use the ControllerHelper to see if the post we want to get is viewable by the user browsing */
		list($post, $thread) = $ftpHelper->assertPostValidAndViewable($postId);

		/* If the post has attachments */
		if ($post['attach_count'] > 0) {
			/* Let's get all the attachments of this post, if exists  */
			$attachmentModel = XenForo_Model::create('XenForo_Model_Attachment');
			$attachments = $attachmentModel->getAttachmentsByContentId('post', $postId);
			foreach ($attachments AS $attachment) {
				/* Insert into the post data the attachments */
				$post['attachments'][$attachment['attachment_id']] = $attachmentModel->prepareAttachment($attachment);
	  		}
		}
			
		$mod_raw = file_get_contents($options->restApiUrl . 'player.php?action=getMods&value=name');
		$ss_raw = file_get_contents($options->restApiUrl . 'player.php?action=getSS&value=name');
			
		$mods = array();
		$ss = array();
			
		while ($name = json_decode($mod_raw, true)) {
			array_push($mods, $name);
		}
		
		while ($name = json_decode($ss_raw, true)) {
			array_push($ss, $name);
		}
				
		$viewParams = array(
			'mods' => $mods,
			'ss' => $ss,
			'post' => $post
		);
			
		return $this->responseView('QCPlayers_ViewPublic_Players_staff', 'player_staff_list', $viewParams);
	}
	
	public function actionSearch()
	{
		// note: intentionally not post-only
		$options = XenForo_Application::get('options');

		if (!$options->enableSearchPlayers)
		{
			throw $this->getNoPermissionResponseException();
		}

		$input = $this->_input->filter(array(
			'ign' => XenForo_Input::STRING
		));

		return $this->responseRedirect(
			XenForo_ControllerResponse_Redirect::SUCCESS,
			XenForo_Link::buildPublicLink('player', $input['ign']),
			''
		);
	}
	
	public static function getSessionActivityDetailsForList(array $activities) {
   		return new XenForo_Phrase('viewing_players');
	} 
}