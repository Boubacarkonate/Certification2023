<?php

namespace App\Controller;

use App\Entity\Forfait;
use App\Service\CartService;
use App\Repository\ForfaitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/*

Clé = Valeur
[clé] = valeur

[
    [clé]=>[valeur]
]
/cart/add/7
/cart/add/8
/cart/add/8


    [7]=>1
    [8]=>2




*/

#[Route('/cart')]
class CartController extends AbstractController
{
    // page d'ajout de forfait
    #[Route('/add/{id}', name: 'app_cart_add')]
    public function index
    ($id,
    CartService $cartService
    ):  Response
    {      
        $cartService->add($id);
        // redirection vers la page des forfaits
         return $this->redirectToRoute("app_cart_show",[], Response::HTTP_SEE_OTHER);

    }

    // page pour visualiser notre panier
    #[Route('/show', name: 'app_cart_show')]
    public function show(
      CartService $cartService
        ): Response
    {
        
        return $this->render('cart/index.html.twig', [
            'panier' => $cartService->show(),
            'totalcomplet'=> $cartService->getTotalAll()
        ]);
    }

    // page pour vider notre panier
    #[Route('/clear', name: 'app_cart_clear')]
    public function clear(
        CartService $cartService
    ): Response
    {
        $cartService->clear();
        
        // redirection vers la page des forfaits
        return $this->redirectToRoute("app_forfait_index",[], Response::HTTP_SEE_OTHER);

    }

       // page pour vider notre panier
       #[Route('/remove/{id}', name: 'app_cart_remove')]
       public function remove_all(
            $id,
           CartService $cartService
       ): Response
       {
            // supprimer la clé du tableau (le forfait)
           $cartService->remove_all($id);
           
           // redirection vers la page des forfaits
           return $this->redirectToRoute("app_cart_show",[], Response::HTTP_SEE_OTHER);
   
       }


// page pour vider notre panier
#[Route('/removequantite/{id}', name: 'app_cart_removequantite')]
public function removequantite(
     $id,
    CartService $cartService
): Response
{
     // supprimer la clé du tableau (le forfait)
    $cartService->remove($id);
    
    // redirection vers la page des forfaits
    return $this->redirectToRoute("app_cart_show",[], Response::HTTP_SEE_OTHER);

}

}