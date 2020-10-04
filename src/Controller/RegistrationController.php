<?php

// app/src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\Utilisateur as User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationController extends AbstractController
{
    /**
     * Undocumented function
     * @Route("/inscription", name="app_inscription")
     * @param Request $request
     * @param null $idPersonne
     * @return void
     */
    public function inscrireCandidat(Request $request, $idPersonne = null)
    {
        $defaultData = ['idPersonne' => $idPersonne];

        $form = $this->createFormBuilder($defaultData)
            ->add('idPersonne', HiddenType::class)
            ->add('username', TextType::class, ['label'=>'Adresse Mail'])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'), 
                'second_options' => array('label' => 'Répéter le mot de passe'), 
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Met à jour la candidature avec les notes
            $data = $form->getData();
            //$candidatureEleve -> setNoteAutobiographie($data['noteAutobiographie']);

            // Sauvegarde la candidature
            //$entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($candidatureEleve);
            //$entityManager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('inscription/index.html.twig', [
            'inscriptionForm' => $form->createView()]);
    }
}
