<?php

namespace App\Controller;

use App\Entity\Family;
use App\Helpers\Paginator;
use App\Repository\FamilyRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FamilyController extends AbstractController
{
           #[Route('/families', name: 'app_families_list')]
    public function list(FamilyRepository $familyRepository,  Request $request, Paginator $paginator): Response
    {
        $query = $familyRepository->findBy([], ['name' => 'ASC']);

        $families = $paginator->paginate($query, $request);

        return $this->render('family/list.html.twig', [
            'families' => $families
        ]);
    }

    #[Route('/families/{id}', name: 'app_families_item')]
    public function item(Family $family): Response
    {
        return $this->render('family/item.html.twig', ['family' => $family]);
    }

}
