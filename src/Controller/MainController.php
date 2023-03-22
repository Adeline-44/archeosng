<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe MainController qui lance la session (jeton de session) et
 * redirige automatiquement vers app_nouveau_calcul (page d'un nouveau calcul)
 */
class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $session->start();
       //$id = $session->getId();
        return $this->redirectToRoute('app_nouveau_calcul');

    }
}
