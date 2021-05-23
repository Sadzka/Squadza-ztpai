<?php
// src/Controller/SecurityController.php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\User;
use App\Entity\Avatar;
use App\Form\AvatarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SecurityController extends AbstractController {
	
	private $messages = [];
	const MAX_FILE_SIZE = 1024 * 1024;
	const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
	const UPLOAD_DIRECTORY = '/../public/uploads/avatars/';
	
	public function profile(Request $request, $profile_id = -1)
	{
        $entityManager = $this->getDoctrine()->getManager();

        $avatar = new Avatar();
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $avatar->getImage();

            $fileName = $this->getUser()->getUsername().'_'.bin2hex(random_bytes(16)).'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            //

            $file->move(
                $this->getParameter('avatar_directory'),
                $fileName
            );

            $avatar->setImage($fileName);
            $this->getDoctrine()->getManager()->persist($avatar);

            $this->getUser()->setAvatar($avatar);
            $this->getDoctrine()->getManager()->persist($this->getUser());

            $entityManager->flush();

        }


        $profile_id = $profile_id == -1 ? $this->getUser()->getId() : $profile_id;
        $user = $this->getDoctrine()->getRepository(User::class)->findById($profile_id);
        $characters = $this->getDoctrine()->getRepository(Character::class)->findByUser($user);

		return $this->render('security/profile.html.twig', [
            'form' => $form->createView(),
		    'messages' => $this->messages,
            'characters' => $characters
        ]);
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

