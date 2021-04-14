<?php
// src/Controller/SecurityController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
	
	private $messages = [];
	const MAX_FILE_SIZE = 1024 * 1024;
	const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
	const UPLOAD_DIRECTORY = '/../public/uploads/avatars/';
	
	public function profile()
	{
		/*
			TODO
			
		if (Request::createFromGlobals()->getMethod() == 'POST'
		&& is_uploaded_file( $_FILES['file']['tmp_name'])
		&& $this->validateImage($_FILES['file']))
		{
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$filename = $this->currentUser->getUsername() . '_' . bin2hex(random_bytes(16)) . '.' . $ext;
	
			if (move_uploaded_file(
			$_FILES['file']['tmp_name'],
			dirname(__DIR__) . self::UPLOAD_DIRECTORY . $filename
			)) {
				UserRepository::getInstance()->setUserAvatar($this->currentUser->getEmail(), $filename);
				$this->messages[] = 'Avatar changed.';
			}
			else {
				$this->messages[] = 'Unknown error. Try again.';
			}
		}
		*/
	
		return $this->render('security/profile.html.twig', ['messages' => $this->messages]);	
	}

	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		// if ($this->getUser()) {
		//     return $this->redirectToRoute('target_path');
		// }

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
	}

	public function logout()
	{
		throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
	}

}

