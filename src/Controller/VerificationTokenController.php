<?php

namespace App\Controller;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
class VerificationTokenController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @var UtilisateurRepository
     */
    private $utilisateurRepository;

      public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->UtilisateurRepository = $utilisateurRepository;
    }
    /**
     * @Route("/verification/{token}", name="app_verification")
     * @param $token
     */
    public function tokenVerification(string $token): Response
    {
      $userArray = $this -> UtilisateurRepository -> findByToken($token);
      $this -> UtilisateurRepository -> verifyUser($token);
      $user = array_pop($userArray);
      $username = $user['username'];
      return $this->render('inscription/valide.html.twig',['username' => $username]);
    }
}
