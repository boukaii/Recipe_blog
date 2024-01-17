<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Repository\CategoryRecipeRepository;

class HomeController extends AbstractController
{

    #[Route('', name: 'app_home')]
    public function categorie(CategorieRepository $CategorieRepository, CategoryRecipeRepository $CategoryRecipeRepository): Response
    {
        $categories = $CategorieRepository->findAll();
        $categoryRecipes = $CategoryRecipeRepository->findAll();

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
            'categoryRecipes' => $categoryRecipes,
        ]);
    }
}