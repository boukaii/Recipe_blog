<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\home\ContinentCategoryRepository;
use App\Repository\home\CountryCategoryRepository;


class HomeController extends AbstractController
{

    #[Route('', name: 'app_home')]
    public function index(ContinentCategoryRepository $ContinentCategoryRepository, CountryCategoryRepository $CountryCategoryRepository): Response
    {
        $continentCategories = $ContinentCategoryRepository->findAll();
        $countryCategories = $CountryCategoryRepository->findAll();

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'continentCategories' => $continentCategories,
            'countryCategories' => $countryCategories,
        ]);
    }
}