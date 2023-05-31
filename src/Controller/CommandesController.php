<?php

namespace App\Controller;


use Stripe\Stripe;
use App\Entity\Facture;
use App\Entity\Forfait;
use App\Entity\Commandes;
use App\Service\CartService;
use Stripe\Checkout\Session;
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


    #[Route('/profile/commandes', name: 'app_commandes')]
    public function index(
     //   CommandeRepository $commandeRepository,
        RequestStack $session,
        ForfaitRepository $produitRepository,

        CartService $cart,
        FactureRepository $factureRepository,

        CommandesRepository $commandesRepository


    ): Response
    {
        // stocké le user
        // this->getUser()
        // stocké le produit
        // via le param converter
        // et la quantité via la session
 
         // stocké le user
        // this->getUser()

        // recuperation du panier
    /*    $panier=$session->getSession()->get("panier");

        // boucler sur chaque ligne du panier
        foreach ($panier as $key => $value  ){ 
            
            $commande = new Commande();
            $commande->setUsers($this->getUser());
            $commande->setProduits($produitRepository->find($key));
            $commande->setQuantite($value);
            $commandeRepository->save($commande, true);

        }*/


        //1. Payer sur STRIPE
        // communiquer avec stripe

        // on a le montant du panier
        $montant=$cart->getTotalAll()*100;


        

        // clé secrete pour que stripe me reconnaisse
        $stripeSecretKey="sk_test_51MrG9hAWrBf8omvY6NBwlrsCEpB6NuCzSOywqWQstvkqdAIS8Vw8qht6yM4l76Fm2oie6xcOfHP82k6Rz4pdyNjP00hBs2ilj2";
        Stripe::setApiKey($stripeSecretKey);
  
        // on définit le protocol de connexion http ou https
        // avec les variable global PHP de sorte de pouvoir gérer
        // tout les environnements possible

        if (isset($_SERVER['HTTPS'])){
            $protocol="https://";
        } 
        $protocol="http://";
        // on définit le nom du serveur de connexion 
        // avec les variable global PHP de sorte de pouvoir gérer
        // tout les environnements possible
        $serveur=$_SERVER['SERVER_NAME'];
        $YOUR_DOMAIN=$protocol.$serveur;

        // on lance la communication avec stripe



        $checkout_session = Session::create([
            'line_items' => [[
              # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
              'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $montant,
                'product_data' => [
                  'name' => 'Paiement de votre panier'
                ],
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commandes',                       //si achat stripe est un suucès alors , la twig de la route /commandes s'affiche
            'cancel_url' => $YOUR_DOMAIN . '/profile/commandes/cancel',

        ]);
 
          
        //2. Savegarde en B.D.

        //3. Supprimer la session
  
        
        return $this->render('commandes/index.html.twig', [
            'controller_name' => 'CommandeController',
            'id_session'=>$checkout_session->id
        ]);
    }
}
