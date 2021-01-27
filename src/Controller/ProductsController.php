<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductsRepository;
use App\Entity\Products;

class ProductsController extends AbstractController
{


/**
     * @Route("/products/", name="get_all_products", methods={"GET"})
     */
    
    public function getAll(): JsonResponse
    {
        $products = $this->getDoctrine()->getRepository('App\Entity\Products')->findAll();
        $data = [];
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_MANAGER')) {
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'productName' => $product->getProductName(),
                'description' => $product->getDescription(),
                'status' => $product->getStatus(),
                'companyName' => $product->getCompanyName(),
                'category' => $product->getCategoryType()->__toString(),
                'imageUrl' => $product->getImage()
            ];
        }
    }
    else
    {
       echo "you are not authorized user, login first";

    }

        return new JsonResponse($data, Response::HTTP_OK);
    }






}



















?>