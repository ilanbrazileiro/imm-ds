<?php 

session_start();

set_time_limit(60);
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once("vendor/autoload.php");

use \Slim\Slim;
use \InstagramScraper\Instagram;
use \InstagramScraper\Model\Account;
use \Phpfastcache\Helper\Psr16Adapter;

$app = new Slim();

$app->config('debug', true);

	$app->get('/', function() {////////////////////

		$lang = substr(Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 2);

		if ($lang == 'pt'){
			header('Location: /instagram2/pt');
			exit;
		} else if ($lang == 'es'){
			header('Location: /instagram2/es');
			exit;
		} else if ($lang == 'en'){
			header('Location: /instagram2/en');
			exit;
		} else {
			header('Location: /instagram2/pt');
			exit;
		}

	});

	$app->get("/privacidade", function(){

		include ('about.php');

	});

	$app->get("/contato", function(){

		include ('contact.php');

	});

	$app->post("/contato", function(){

		include ('contact.php');

	});

	$app->get("/pt", function(){////////////////Português

		include ('locales/pt/pt.php');

	});

	/*
		Depois de postar a url no box em português		
	*/
	$app->post("/pt", function(){/////////////////Português

		$instagram = new \InstagramScraper\Instagram();

		if (isset($_SESSION['login_instagram'])){//Verifica se sessão já aberta

			try{
				
				$instagram = \InstagramScraper\Instagram::withCredentials($_SESSION['login_instagram'], base64_decode($_SESSION['senha_instagram']), new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}

		} else if (isset($_POST['login']) && isset($_POST['senha'])){//testa se logou

			if(filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)){//Valida se e-mail válido
				$login = $_POST['login'];
			} else {
				$login = str_replace('@', '', $_POST['login']);//caso logue com nome de usuario, retira o '@'
			}
			
			$senha = $_POST['senha'];
			try{

				$_SESSION['login_instagram'] = $login;
				$_SESSION['senha_instagram'] = base64_encode($senha);
				$instagram = \InstagramScraper\Instagram::withCredentials($login, $senha, new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}
		}

		try {
		
		    $media = $instagram->getMediaByUrl($_POST['url']);
		
			$type = $media->getType();

			if ($type == 'video'){
				$url = $media->getVideoStandardResolutionUrl();
			} else if ($type == 'image'){
				$url = $media->getImageHighResolutionUrl();
			} else if ($type == 'sidecar'){
				foreach ($media->getSidecarMedias() as $k => $sidecarMedia) {
					if ($sidecarMedia->getType() == 'image'){
	    				$url[$k]['link'] = $sidecarMedia->getImageHighResolutionUrl();
	    				$url[$k]['tipo'] = 'image';
	    			} else if ($sidecarMedia->getType() == 'video'){
	    				$url[$k]['link'] = $sidecarMedia->getVideoStandardResolutionUrl();
	    				$url[$k]['tipo'] = 'video';
	    			}
				}
			}
			
		} catch (Exception $e) {
		    $erro =  $e->getMessage();
		}

		include ('locales/pt/pt.php');
	
	});



	///////////////////////INGLES

	$app->get("/en", function(){/////////////////////

		include ('locales/en/en.php');


	});

	/*
		Depois de postar a url no box em INGLES		
	*/
	$app->post("/en", function(){

		$instagram = new \InstagramScraper\Instagram();

		if (isset($_SESSION['login_instagram'])){//Verifica se sessão já aberta

			try{
				
				$instagram = \InstagramScraper\Instagram::withCredentials($_SESSION['login_instagram'], base64_decode($_SESSION['senha_instagram']), new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}

		} else if (isset($_POST['login']) && isset($_POST['senha'])){//testa se logou

			if(filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)){//Valida se e-mail válido
				$login = $_POST['login'];
			} else {
				$login = str_replace('@', '', $_POST['login']);//caso logue com nome de usuario, retira o '@'
			}
			
			$senha = $_POST['senha'];
			try{

				$_SESSION['login_instagram'] = $login;
				$_SESSION['senha_instagram'] = base64_encode($senha);
				$instagram = \InstagramScraper\Instagram::withCredentials($login, $senha, new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}
		}

		try {
		
		    $media = $instagram->getMediaByUrl($_POST['url']);
		
			$type = $media->getType();

			if ($type == 'video'){
				$url = $media->getVideoStandardResolutionUrl();
			} else if ($type == 'image'){
				$url = $media->getImageHighResolutionUrl();
			} else if ($type == 'sidecar'){
				foreach ($media->getSidecarMedias() as $k => $sidecarMedia) {
					if ($sidecarMedia->getType() == 'image'){
	    				$url[$k]['link'] = $sidecarMedia->getImageHighResolutionUrl();
	    				$url[$k]['tipo'] = 'image';
	    			} else if ($sidecarMedia->getType() == 'video'){
	    				$url[$k]['link'] = $sidecarMedia->getVideoStandardResolutionUrl();
	    				$url[$k]['tipo'] = 'video';
	    			}
				}
			}
			
		} catch (Exception $e) {
		    $erro =  $e->getMessage();
		}

		include ('locales/en/en.php');
	
	});	






	///////////////////////ESPANHOL NÃO TRADUZIDO

	$app->get("/es", function(){/////////////////////

		include ('locales/en/en.php');


	});

	/*
		Depois de postar a url no box em português		NÃO TRADUZIDO
	*/
	$app->post("/es", function(){/////////////////Espanhol

		$instagram = new \InstagramScraper\Instagram();

		if (isset($_SESSION['login_instagram'])){//Verifica se sessão já aberta

			try{
				
				$instagram = \InstagramScraper\Instagram::withCredentials($_SESSION['login_instagram'], base64_decode($_SESSION['senha_instagram']), new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}

		} else if (isset($_POST['login']) && isset($_POST['senha'])){//testa se logou

			if(filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)){//Valida se e-mail válido
				$login = $_POST['login'];
			} else {
				$login = str_replace('@', '', $_POST['login']);//caso logue com nome de usuario, retira o '@'
			}
			
			$senha = $_POST['senha'];
			try{

				$_SESSION['login_instagram'] = $login;
				$_SESSION['senha_instagram'] = base64_encode($senha);
				$instagram = \InstagramScraper\Instagram::withCredentials($login, $senha, new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}
		}

		try {
		
		    $media = $instagram->getMediaByUrl($_POST['url']);
		
			$type = $media->getType();

			if ($type == 'video'){
				$url = $media->getVideoStandardResolutionUrl();
			} else if ($type == 'image'){
				$url = $media->getImageHighResolutionUrl();
			} else if ($type == 'sidecar'){
				foreach ($media->getSidecarMedias() as $k => $sidecarMedia) {
					if ($sidecarMedia->getType() == 'image'){
	    				$url[$k]['link'] = $sidecarMedia->getImageHighResolutionUrl();
	    				$url[$k]['tipo'] = 'image';
	    			} else if ($sidecarMedia->getType() == 'video'){
	    				$url[$k]['link'] = $sidecarMedia->getVideoStandardResolutionUrl();
	    				$url[$k]['tipo'] = 'video';
	    			}
				}
			}
			
		} catch (Exception $e) {
		    $erro =  $e->getMessage();
		}

		include ('locales/es/es.php');
	
	});

	/////////// FIM ESPANHOL


	///////////////////////FRANCES NÃO TRADUZIDO

	$app->get("/fr", function(){/////////////////////

		include ('locales/en/en.php');


	});

	/*
		Depois de postar a url no box em português		NÃO TRADUZIDO
	*/
	$app->post("/fr", function(){/////////////////Espanhol

		$instagram = new \InstagramScraper\Instagram();

		if (isset($_SESSION['login_instagram'])){//Verifica se sessão já aberta

			try{
				
				$instagram = \InstagramScraper\Instagram::withCredentials($_SESSION['login_instagram'], base64_decode($_SESSION['senha_instagram']), new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}

		} else if (isset($_POST['login']) && isset($_POST['senha'])){//testa se logou

			if(filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)){//Valida se e-mail válido
				$login = $_POST['login'];
			} else {
				$login = str_replace('@', '', $_POST['login']);//caso logue com nome de usuario, retira o '@'
			}
			
			$senha = $_POST['senha'];
			try{

				$_SESSION['login_instagram'] = $login;
				$_SESSION['senha_instagram'] = base64_encode($senha);
				$instagram = \InstagramScraper\Instagram::withCredentials($login, $senha, new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}
		}

		try {
		
		    $media = $instagram->getMediaByUrl($_POST['url']);
		
			$type = $media->getType();

			if ($type == 'video'){
				$url = $media->getVideoStandardResolutionUrl();
			} else if ($type == 'image'){
				$url = $media->getImageHighResolutionUrl();
			} else if ($type == 'sidecar'){
				foreach ($media->getSidecarMedias() as $k => $sidecarMedia) {
					if ($sidecarMedia->getType() == 'image'){
	    				$url[$k]['link'] = $sidecarMedia->getImageHighResolutionUrl();
	    				$url[$k]['tipo'] = 'image';
	    			} else if ($sidecarMedia->getType() == 'video'){
	    				$url[$k]['link'] = $sidecarMedia->getVideoStandardResolutionUrl();
	    				$url[$k]['tipo'] = 'video';
	    			}
				}
			}
			
		} catch (Exception $e) {
		    $erro =  $e->getMessage();
		}

		include ('locales/fr/fr.php');
	
	});

	/////////// FIM FRANCES




	///////////////////////ALEMÃO NÃO TRADUZIDO

	$app->get("/de", function(){/////////////////////

		include ('locales/de/de.php');


	});

	/*
		Depois de postar a url no box em português		NÃO TRADUZIDO
	*/
	$app->post("/de", function(){/////////////////Espanhol

		$instagram = new \InstagramScraper\Instagram();

		if (isset($_SESSION['login_instagram'])){//Verifica se sessão já aberta

			try{
				
				$instagram = \InstagramScraper\Instagram::withCredentials($_SESSION['login_instagram'], base64_decode($_SESSION['senha_instagram']), new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}

		} else if (isset($_POST['login']) && isset($_POST['senha'])){//testa se logou

			if(filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)){//Valida se e-mail válido
				$login = $_POST['login'];
			} else {
				$login = str_replace('@', '', $_POST['login']);//caso logue com nome de usuario, retira o '@'
			}
			
			$senha = $_POST['senha'];
			try{

				$_SESSION['login_instagram'] = $login;
				$_SESSION['senha_instagram'] = base64_encode($senha);
				$instagram = \InstagramScraper\Instagram::withCredentials($login, $senha, new Psr16Adapter('Files'));
				$instagram->login();
				//$instagram->saveSession(); ///// Não estou salvando 
			} catch (Exception $e){
				$erro_login = $e->getMessage();
			}
		}

		try {
		
		    $media = $instagram->getMediaByUrl($_POST['url']);
		
			$type = $media->getType();

			if ($type == 'video'){
				$url = $media->getVideoStandardResolutionUrl();
			} else if ($type == 'image'){
				$url = $media->getImageHighResolutionUrl();
			} else if ($type == 'sidecar'){
				foreach ($media->getSidecarMedias() as $k => $sidecarMedia) {
					if ($sidecarMedia->getType() == 'image'){
	    				$url[$k]['link'] = $sidecarMedia->getImageHighResolutionUrl();
	    				$url[$k]['tipo'] = 'image';
	    			} else if ($sidecarMedia->getType() == 'video'){
	    				$url[$k]['link'] = $sidecarMedia->getVideoStandardResolutionUrl();
	    				$url[$k]['tipo'] = 'video';
	    			}
				}
			}
			
		} catch (Exception $e) {
		    $erro =  $e->getMessage();
		}

		include ('locales/de/de.php');
	
	});

	/////////// FIM ALEMÃO

$app->run();

 ?>
