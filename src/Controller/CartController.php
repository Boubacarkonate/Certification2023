<?php

namespace App\Controller;

use App\Entity\Forfait;
use App\Repository\ForfaitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_index')]
    public function index(SessionInterface $session, ForfaitRepository $forfaitRepository): Response
    {
        $panier = $session->get("panier", []);

        //je fabrique les données
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $forfait = $forfaitRepository->find($id);
            $dataPanier[] = [                           //dataPanier[]=... Cela signifie que c'est un tableau vide que je pourrais remplir avec les variables demandées dans le =
                "forfait" => $forfait,
                "quantite" => $quantite
            ];
            $total += $forfait->getPrice() * $quantite;
        }

        return $this->render('cart/index.html.twig', [
            'dataPanier' => $dataPanier,
            'total' => $total
        ]);
    }
    #[Route('/add/{id}', name: 'app_cart_add')]
    public function add(Forfait $forfait, SessionInterface $session): Response
    {
        

    //    $session->set("panier", 3);      //le set necessite une variable et une valeur
        //  dd($session->get("panier"));          le get récupere la variable contenant sa valeur



        /// 1°) on récupère le panier actuel///
         $panier = $session->get("panier", []);   //soit le $panier récupère sa valeur, soit 1 tableau vide s'il n'existe pas
        $id = $forfait->getId();                    //j'enferme mon forfait qui sera récupéré(selectionné à l'achat) dans une variable que j'appelle

        // $panier=[           le tableau devra contenir [le $id => sa quantité/valeur ]
        //     '1' => 1,           
        //     '2' => 3
        // ]

        if (!empty($panier[$id]) ) {            //si $panier n'est pas vide alors
            $panier[$id]++;                     //ajout de 1 en 1 les valeurs
        } else {                                //sinon, s'il est vide,
            $panier[$id] =1;                    //crée le panier en l'initialisant à 1
        }
         

         /// 2°) on sauvegarde dans la session la quantité/valeur du $id ///
        $session->set("panier", $panier);

// dd($session);

            return $this->redirectToRoute('app_cart_index');
        // return $this->render('cart/index.html.twig', [
            
        // ]);
    }


}
