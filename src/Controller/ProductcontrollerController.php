<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductcontrollerController extends AbstractController
{
    #[Route('/produit/afficher', name: 'app_product_index')]
    public function index(): Response
    {
        return $this->render('productcontroller/index.html.twig', [
            
        ]);
    }
}
