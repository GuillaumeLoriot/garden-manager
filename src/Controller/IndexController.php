<?php

namespace App\Controller;


use App\Form\SearchCriteriaType;
use App\Service\Paginator;
use App\Repository\PlantRepository;
use App\SearchBar\SearchCriteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlantRepository $plantRepository, Request $request, Paginator $paginator): Response
    {

        $criteria = new SearchCriteria();
        $searchForm = $this->createForm(SearchCriteriaType::class, $criteria, [
            'method' => 'GET',
        ]);
        $searchForm->handleRequest($request);

        
        $foundPlants = null;
        
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $query = $plantRepository->findBySearchBar($criteria);
            $foundPlants = $paginator->paginate($query, $request);   
        }
        // ce else if est uniquement la pour s'adapter à la manière dont paginator travail. Lorsque la recherhe est
        //  faite la première fois, le form est submited donc ça passe bien dans la condition mais lorsque je clique sur
        // la page 2 du paginator, j'en ai compris que le paginator rechargait la page, mais comme à ce moment le form 
        // n'est plus submited, je navais plus aucun resultats affichés. Pour pallier à ça j'ai ajouté le elsif qui
        // verifie si il y a un parametre "page" et si c'est le cas je fais la même chose qu'au submited.
        // je suis conscient qu'un utilisateur pourait changer à la main dans l'url mais ce n'est pas très grave car rien
        // ne vas en bdd; ce n'est qu'une recherche simple. Avec cette solution la pagination fonctionne même s'il reste
        // dans le profiler une erreur 422. Je vais continuer a avancé sur le reste du projet mais n'aurais peu être pas le temps 
        // de régler ça avant le rendu..
        elseif($request->query->has('page')){
            $query = $plantRepository->findBySearchBar($criteria);
            $foundPlants = $paginator->paginate($query, $request);
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
