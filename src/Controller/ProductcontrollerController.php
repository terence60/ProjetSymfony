<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductForm;
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
    #[Route('/produit/ajouter', name: 'app_product_new')]
    public function new(): Response
    {

        // Création d'un objet de la class (Entity) Product
        $product = new Product();
        dump($product);

        // la méthode createForm() provenant de la class AbstractController permet de créer un formulaire 
        // 1er argument : nom de la classe dans laquelle se trouve le builder 
        // 2éme argument : objet issu de l'entity sur laquelle le formulaire à été crée 
        // cette méthode retourne un objet issu de la class FormInterface
        $form = $this->createForm(ProductForm::class, $product);
        return $this->render ('productcontroller/new.html.twig',[
            'formProduct' => $form->createView()
        ]);
    }
}
