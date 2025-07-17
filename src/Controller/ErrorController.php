<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ErrorController extends AbstractController
{

// j'ai mis en place ce controller juste pour tester la redirection vers des pages d'erreurs personalisées coté utilisateur
// mais je n'ai mis ça en place que sur quelques controllers dans la classe de controller UserController. Je devrais plutôt
// le faire en interceptant les templates d'erreur  déja mis en place par symfony; à voir plus tard si j'ai le temps.

        #[Route('/error/403', name: 'app_error_403')]
    public function error403(): Response
    {
        return $this->render('error/error403.html.twig', []);
    }
}
