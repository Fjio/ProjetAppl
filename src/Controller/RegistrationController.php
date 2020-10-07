<?php

// app/src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Personne;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use \Doctrine\DBAL\Exception\UniqueConstraintViolationException as UCVE;
use Symfony\Component\Form\FormError;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
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
            ->add('username', EmailType::class, ['label'=>'Adresse Mail'])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'), 
                'second_options' => array('label' => 'Répéter le mot de passe'), 
            ))
            ->getForm();

        
        $form->handleRequest($request);
        // no unique username check ! warning
        if ($form->isSubmitted() && $form->isValid()) {
            // Met à jour la candidature avec les notes
            $data = $form->getData();
            //manager import
            $manager = $this->getDoctrine()->getManager();
            //new personne defined
            $elevePersonne = new Personne();
            $elevePersonne -> setMail($data['username']);
            $manager -> persist($elevePersonne);
            //new user defined
            $eleveUser = new Utilisateur();
            $eleveUser -> setRoles("ROLE_ELEVE");
            $eleveUser -> setIdPersonne($elevePersonne);
            $eleveUser -> setUsername($data['username']); 
            $eleveUser -> setPassword($this->passwordEncoder->encodePassword($eleveUser,$data['plainPassword']));
            $eleveUser -> setCreationDate(new DateTime());
            //token generation
            $length = 32;
            $token = bin2hex(random_bytes($length));
            $eleveUser -> setToken($token);
            $eleveUser -> setValidatedUser(FALSE); 
            $manager -> persist($eleveUser);
            //flush it
            try {
                $manager->flush();
                $response= $this->forward('App\Controller\MailerController::sendEmailOnRegistration',[
                    'token' => $token
                ]);
                return $response;
            } catch (UCVE $e){
                //for now, "your mail is in use" message - check #GDPR
                $mailError = new FormError("Vous avez déjà un compte");
                $form->get('username')->addError($mailError);
            }
        }
        return $this->render('inscription/index.html.twig', [
            'inscriptionForm' => $form->createView()]);
    }
}
