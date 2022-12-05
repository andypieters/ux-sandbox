<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/search/{keyword}', name: 'app_search')]
    public function search(string $keyword = null)
    {
        return $this->render('home/search.html.twig', ['keyword' => $keyword]);
    }
}
