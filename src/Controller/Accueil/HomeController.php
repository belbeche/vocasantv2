<?php

namespace App\Controller\Accueil;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index()
    {
        return $this->render('front/accueil/home.html.twig');
    }
}
