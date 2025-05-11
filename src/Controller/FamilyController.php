<?php

namespace App\Controller;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FamilyController extends AbstractController
{
           #[Route('/families', name: 'app_families_list')]
    public function list(FamilyRepository $familyRepository): Response
    {
        $families = $familyRepository->findAll();

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
