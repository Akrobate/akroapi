<?php

/**
 *	Cette classe est le controlleur qui gere
 *	Le upload des mails depuis une boite gmail
 *	ici le user doit obligatoirement etre connecté
 *	Pour toutes les datas login / PAssword gmail
 *	
 *	@author	Artiom FEDOROV
 *	@date	2014
 *
 */

class Modules_Emails_Index extends CoreController {

	/**
	 *	Surcharge de l'init() et traitements principaux
	 *	
	 */

	public function init() {

		$modules = $this->getModule();
		$list = new List_Frameview();
		
		$user = users::getMe();
		
		$login = $user['email_login'];
		$password = $user['email_password'];
		$host = "{imap.gmail.com:993/imap/ssl}INBOX";
		
		$client = new MyMail();
		$client->setUsername($login);
		$client->setPassword($password);
		$client->setHost($host);
		
		// Affichage un peu en mode debug
		$mres = $client->getNew();	
		$listContent = "<pre>";
		$listContent .= print_r($user, 1);
		$listContent .= print_r($mres, 1);
		$listContent .= "</pre>";
		
		// Assignation de toutes les données
		$this->assign('listContent', $listContent);
	}
}
