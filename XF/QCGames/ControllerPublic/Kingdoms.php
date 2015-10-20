<?php

class QCGames_ControllerPublic_Kingdoms extends XenForo_ControllerPublic_Abstract {

	public function actionIndex() {
		$options = XenForo_Application::get('options');
		
		if(!XenForo_Visitor::getInstance()->hasPermission('games', 'kingdoms') && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayKingdoms && !XenForo_Visitor::getInstance()->isSuperAdmin()) {
			return $this->responseNoPermission();
		}
		
		$viewParams = array(
			'null' => null
		);

		return $this->responseView('QCGames_ViewPublic_Kingdoms_Index', 'kingdom_index', $viewParams);
	}
	
	public function actionLeaderboards() {
		$options = XenForo_Application::get('options');

		if(!XenForo_Visitor::getInstance()->hasPermission('games', 'kingdoms') && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayKingdoms && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayKingdomsLeaderboard && !XenForo_Visitor::getInstance()->isSuperAdmin()) {
			return $this->responseNoPermission();
		}
				
		$viewParams = array(
			'null' => null
		);
					
		return $this->responseView('QCGames_ViewPublic_Kingdoms_Leaderboard', 'kingdom_leaderboard', $viewParams);
	}
	
	public function actionGuide() {
		$options = XenForo_Application::get('options');
		
		if(!XenForo_Visitor::getInstance()->hasPermission('games', 'kingdoms') && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayKingdoms && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayKingdomsGuide && !XenForo_Visitor::getInstance()->isSuperAdmin()) {
			return $this->responseNoPermission();
		}
		
		/* Set the ID of the post to be loaded */
		$postId = $options->kingdomGuidePostId;

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
		
	 	/* These parameters will be used in our template. We need to pass them into the response view. The $post param will be used too in the XenForo_ViewPublic instance */
		$viewParams = array (
		   	'post' => $post,
		);
					
		return $this->responseView('QCGames_ViewPublic_Kingdoms_Guide', 'kingdom_guide', $viewParams);
	}
	
	public static function getSessionActivityDetailsForList(array $activities) {
		return new XenForo_Phrase('viewing_game_kingdoms');;
	} 
}

?>