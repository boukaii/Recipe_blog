<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\home\CountryRecipeRepository;
use App\Entity\home\CountryCategory;

class CountryRecipeController extends AbstractController
{
    #[Route('/recipe/{id}', name: 'app_countryRecipe')]
    public function index(CountryCategory $countryCategory, CountryRecipeRepository $countryRecipeRepository): Response
    {
        $countryRecipes = $countryRecipeRepository->findBy(['countryCategory' => $countryCategory]);

        return $this->render('home/CountryRecipe.html.twig', [
            'controller_name' => 'RecipeController',
            'countryRecipes' => $countryRecipes,
        ]);
    }
}
