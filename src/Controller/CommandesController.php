<?php

namespace App\Controller;


use App\Entity\Facture;
use App\Entity\Commandes;
use App\Entity\Forfait;
use App\Service\CartService;
use App\Repository\FactureRepository;
use App\Repository\ForfaitRepository;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandesController extends AbstractController
{
    #[Route('commandes', name: 'app_commandes_success')]
    public function sucess(FactureRepository $factureRepository, RequestStack $session, ForfaitRepository $forfaitRepository, CommandesRepository $commandesRepository, CartService $cartService):Response
    {


        
        // 1. On va stocké une ligne dans la table facture
        // on créé un objet facture issue de l'entité facture
        $facture=new Facture();
        // on va lui affecté un user en lui mettant l'user en cours
        $facture->setUserId($this->getUser());
        // on va lui affecté la propriété correspondant à la date en cours
        // avec un datatime
        $facture->setDateAt(new \DateTimeImmutable());


        // on utilise le repo de la facture pour enregistrer
        // les repository des entity de servent qu'a lire (méthode find)
        // il y a une personnalisation du repo qui appelle l'entity manager
        // c'est la classe d'écriture de symfony
        $factureRepository->save($facture, true);




        // 2. on va stocké le panier dans la table commande
    /*    $panier=$session->getSession()->get("panier");

        // boucler sur chaque ligne du panier
        foreach ($panier as $key => $value  ){ 
            
            $commande = new Commande();
            $commande->setUsers($this->getUser());
            $commande->setProduits($produitRepository->find($key));
            $commande->setQuantite($value);
            $commandeRepository->save($commande, true);

        }*/
        $panier=$session->getSession()->get("panier");

        foreach($panier as $key => $value){

            // création d'un objet commande
            $commandes=new Commandes();
          
            $commandes ->setCreatedAt(new \DateTimeImmutable());

            if ($key == 1) {
                $commandes -> setExpireAt(new \DateTimeImmutable('+1 month')); 
            }
            elseif ($key == 2) {
                $commandes -> setExpireAt(new \DateTimeImmutable('+6 month'));
            }
            elseif ($key == 3) {
                $commandes -> setExpireAt(new \DateTimeImmutable('+12 month'));
            }
            
                        //voir comment créer 3 date de fin d'abonnement
            // clone $commandes->setExpireAt(new \DateTimeImmutable('+6 month'));
            // clone $commandes->setExpireAt(new \DateTimeImmutable('+12 month'));
            $commandes->setQuantity($value);
           
            // affectation de la propriété produit
            // grace au repo du produit
            $commandes->setForfaitId($forfaitRepository->find($key));       
            // affectation de la propriété facture issue du 
            // de la facture créé au dessus
            $commandes->setFactureId($facture);
           
            $commandesRepository->save($commandes,true);
        }

        

        // on vide le panier
        $cartService->clear();
 
        return $this->render(
            "commandes/success.html.twig"
        );
    } 


    #[Route('/profile/commandes/cancel', name: 'app_commandes_cancel')]
    public function cancel(){
        dd('le paiement est KO ! ');
    } 
}