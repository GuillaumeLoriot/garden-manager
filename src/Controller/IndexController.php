<?php

namespace App\Controller;


use App\Form\SearchCriteriaType;
use App\Repository\PlantRepository;
use App\SearchBar\SearchCriteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlantRepository $plantRepository, Request $request): Response
    {

        $criteria = new SearchCriteria();
        $searchForm = $this->createForm(SearchCriteriaType::class, $criteria, [
            'method' => 'GET',
        ]);
        $searchForm->handleRequest($request);

        $foundPlants = [];
        

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $foundPlants = $plantRepository->findBySearchBar($criteria);

        }


        return $this->render('index/home.html.twig', [
            'search_form' => $searchForm,
            'found_plants' => $foundPlants
        ]);
    }


    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {


        return $this->render('index/about.html.twig', []);
    }


}
