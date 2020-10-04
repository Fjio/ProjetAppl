<?php

// app/src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\Utilisateur as User;
use App\Form\EleveInscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(EleveInscription::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            
            // do anything else you need here, like send an email
            // in this example, we are just redirecting to the homepage
            return $this->redirectToRoute('app_index');
        }

        return $this->render('inscription/inscription.html.twig', [
            'inscriptionForm' => $form->createView(),
        ]);
    }
}