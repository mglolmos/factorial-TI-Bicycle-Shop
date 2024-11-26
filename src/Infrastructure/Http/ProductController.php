<?php
namespace App\Infrastructure\Http;

use App\Application\UseCases\CreateProductRequest;
use App\Application\UseCases\CreateProductUseCase;
use App\Application\UseCases\GetProductRequest;
use App\Application\UseCases\GetProductUseCase;
use App\Domain\ProductNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarDumper\VarDumper;
use Predis\Client;

class ProductController extends AbstractController
{
    private $createProductUseCase;

    private $getProductUseCase;
    public function __construct(CreateProductUseCase $createProductUseCase, GetProductUseCase $getProductUseCase)
    {
        $this->createProductUseCase = $createProductUseCase;
        $this->getProductUseCase = $getProductUseCase;
    }

    #[Route('/product', methods: ['POST'])]
    public function createProduct(Request $request): Response
    {
        $product_id = $request->request->get('product_id');
        $name = $request->request->get('name');

        $product_request = new CreateProductRequest($product_id, $name);

        $this->createProductUseCase->createProduct($product_request);

        return new Response(status: Response::HTTP_CREATED);
    }
    #[Route('/product', methods: ['GET'])]
    public function getProduct(Request $request): Response
    {
        try {
            $product_id = $request->query->get("product_id");

            $product_request = new GetProductRequest($product_id);
            $product_response = $this->getProductUseCase->getProduct($product_request);

            return new Response(json_encode($product_response), status: Response::HTTP_OK);
        } catch (ProductNotFoundException) {
            return new Response(status: Response::HTTP_NOT_FOUND);
        }
    }
}