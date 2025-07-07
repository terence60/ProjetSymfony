<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;

#[Route('/produit')]
final class ProductcontrollerController extends AbstractController
{
    #[Route('/afficher', name:'app_product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        /*
            Lorsqu'une entity est créée, son repository est généré également
            entity = table
            repository = requête SELECT
        */
         $products = $productRepository->findAll();

        //dd($products);

        /*
            Dans tous les repository, il existe 4 méthodes par défaut :
            - findAll() : return []
            - findBy() : return []
            - find() : return Objet Product or NULL
            - findOneBy() : return Objet Product or NULL

            ProductRepository : SELECT ........ FROM product ......
            1- findAll() : SELECT * FROM product


            3- find(int $id) : SELECT * FROM product WHERE id = $id
        */
      return $this->render('productcontroller/index.html.twig', [
        'products' => $products
       ]);
    }

    #[Route('/ajouter', name:'app_product_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /*
            La méthode new() dépend de 2 objets, sans ces 2 derniers la route pour ajouter un produit ne peut pas fonctionner,
            on définit les dépendances dans les parenthèses de la méthode

            syntaxe : Class $objet, Class2 $objet2

        */
        // Création d'une instance/objet de la class (Entity) Product
        $product = new Product();
        dump($product);

        /*
            La méthode createForm() provenant de la class AbstractController
            permet de créer un formulaire 
            1- argument : nom de la class dans laquelle se trouve le builder
            2- argument : objet issu de l'entity sur laquelle le formulaire a été créée

            Cette méthode retourne un objet issu de la class FormInterface
        */
        $form = $this->createForm(ProductForm::class, $product);

        // Traitement du formulaire
        $form->handleRequest($request);

        /*
            Si le formulaire a été soumis et validé
        */
        if ($form->isSubmitted() && $form->isValid()) {
            dump($product);

            // EntityManagerInterface est la class qui permet d'exécuter les 3 requètes :
            // INSERT INTO
            // UPDATE
            // DELETE


            // INSERTION EN BASE DE DONNÉES
            $entityManager->persist($product);
            $entityManager->flush();

            //dd($product);

            // notification
            $this->addFlash('success','le produit' .$product->getTitle().'à bien était ajouté');

            // redirection
            /*
                La méthode redirectToRoute() permet de faire des redirections internes
                1e argument (obligatoire) - type : string ==> Nom de la route (attribut name) 
                2e argument (facultatif)  - type : array  ==> tableau des paramètres
            */
            return $this->redirectToRoute('app_product_index');
        }


        return $this->render('productcontroller/new.html.twig', [
           'formProduct' => $form->createView() 
        ]);
    }
    #[Route('/fiche/{id}',name :'app_product_show')]
    public function show(Product $product) : Response
    {
          /*
            Il existe 2 types de route : avec et sans paramètres

            Les paramètres permettent de véhiculer des données d'une route à une autre

            On distingue 2 types de paramètres :
                - ceux qui permettent de récupérer un objet de la base de données
                - les autres, juste des valeurs (une variable)

            On peut définir le nom du paramètre comme on le souhaite sauf si ce dernier est à injecter dans un objet issu d'une entity, il faut que le paramètre porte le même nom que la propriété de l'objet 
            l'ORM de Symfony (Doctrine) s'occupe de récupérer tout l'objet en BDD (pas besoin de faire une requête)

            Depuis Symfony 7, si le paramètre n'est pas la clé primaire (id) la syntaxe est :
            {property:entity} 
            rappel pour la clé primaire : {id}
        */
        dump($product);
        return $this->render('productcontroller/show.html.twig' , [
            'product' => $product,

        ]);
         
    }
    #[Route('/edit' ,name: 'app_product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $entityManager) : Response
     {
        /*
            Les routes "ajouter" et "modifier" sont identiques sauf que dans un cas on génère un nouvel objet $product et dans l'autre on récupère un objet $product de la base de données
        */
        $form = $this->createForm(ProductForm::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();


            return $this->redirectToRoute('app_product_index');
            //return $this->redirectToRoute('app_product_show', ['id' => $product->getId()]);
        }

        return $this->render('productcontroller/edit.html.twig', [
            'product' => $product,
            'formProduct' => $form
        ]);
    }

   #[Route('/supprimer/{id}', name:'app_product_delete')]
    public function delete(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();
        $this->addFlash('success', 'Le produit "' . $product->getTitle() . '" a bien été supprimé');
        return $this->redirectToRoute('app_product_index');
    }

}
