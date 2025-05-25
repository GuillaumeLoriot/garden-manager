<?php

namespace App\Controller;

use App\Entity\Plant;
use App\Service\Paginator;
use App\Repository\PlantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlantController extends AbstractController
{

    #[Route('/plants', name: 'app_plants_list')]
    public function list(PlantRepository $plantRepository, Request $request, Paginator $paginator): Response
    {
        $query = $plantRepository->findBy([], ['name' => 'ASC']);

        $plants = $paginator->paginate($query, $request);

        return $this->render('plant/list.html.twig', [
            'plants' => $plants
        ]);
    }

    #[Route('/plants/{id}', name: 'app_plants_item')]
    public function item(Plant $plant): Response
    {
        return $this->render('plant/item.html.twig', ['plant' => $plant]);
    }

}
