<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ErrorController extends AbstractController
{
        #[Route('/error/403', name: 'app_error_403')]
    public function error403(): Response
    {
        return $this->render('error/error403.html.twig', []);
    }
}
