<?php

namespace App\Controller; // dossier source

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// final  = class qui ne veut pas etre heriter
final class HomeController extends AbstractController // Extends = heriter
{
    // dans l'attribut route on y trouve la configuration 
    // 1er argument (sans terme) : la route (ce qu'on retrouve dans l'url)
    // serveur + route 
    // exemple :
    // en local http://127.0.0.1:8000/home
    // en ligne www.nomDeDomaine.fr/home

    // 2éme argument 

    // PAS DE DOUBLE QUOTE

   // la méthode render() qui provient de la class AbstractController permet de rendre une vue,
   // la route retourne une vue c'est à dire un fichier html.twig 
   // la méthode render() a 2 arguments :
   // 1e (obligatoire) type : string : le nom du fichier html.twig 
   // pour info la méthode render() se positionne à la racine du dossier 'templates'
   // 2éme argument type : array : tableau des données à véhiculer les templates
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $firstNameController = 'terence';

        // debug : dump visible dans symfony profiler
        // die ou dd : le code n'est pas exécuté

        dump($firstNameController);
        

        return $this->render('home/index.html.twig', [
            // k => v
            // k sera le terme récupéré en twig 
            // v sera le terme récupéré en dans la méthode controller
            'firstNametwig' => $firstNameController
        ]);
    }
    #[Route ('/catalogue', name: 'app_catalog')]
    public function catalog(): Response
    {
     return $this->render('home/catalog.html.twig',[

     ]);
    }
     #[Route('/erreur', name: 'app_erreur')]
     public function erreur(): Response
     {
    return $this->render('home/erreur.html.twig', [
     ]);
     }
     
    

}
