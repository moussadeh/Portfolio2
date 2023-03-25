<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('pages/home.html.twig',[
        ]);
    }
    
    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentionLegale(): Response
    {
        return $this->render('pages/mentions-legales.html.twig',[         
        ]);
    }
}
