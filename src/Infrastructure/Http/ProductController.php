<?php
namespace App\Infrastructure\Http;

use App\Application\UseCases\AddCollectionRequest;
use App\Application\UseCases\AddCollectionUseCase;
use App\Application\UseCases\CreateProductRequest;
use App\Application\UseCases\CreateProductUseCase;
use App\Application\UseCases\GetCollectionRequest;
use App\Application\UseCases\GetCollectionUseCase;
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
use function PHPUnit\Framework\throwException;

class ProductController extends AbstractController
{
    private $createProductUseCase;

    private $getProductUseCase;

    private $addCategoryUseCase;

    private $getCollectionUseCase;
    public function __construct(CreateProductUseCase $createProductUseCase, GetProductUseCase $getProductUseCase, AddCollectionUseCase $addCollectionUseCase, GetCollectionUseCase $getCollectionUseCase)
    {
        $this->createProductUseCase = $createProductUseCase;
        $this->getProductUseCase = $getProductUseCase;
        $this->addCategoryUseCase = $addCollectionUseCase;
        $this->getCollectionUseCase = $getCollectionUseCase;
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
    #[Route('/product/{product_id}', methods: ['GET'])]
    public function getProduct(Request $request, $product_id): Response
    {
        try {
            $product_request = new GetProductRequest($product_id);
            $product_response = $this->getProductUseCase->getProduct($product_request);

            return new Response(json_encode($product_response), status: Response::HTTP_OK);
        } catch (ProductNotFoundException) {
            return new Response(status: Response::HTTP_NOT_FOUND);
        }
    }
    #[Route('/product/{id}/collection', methods: ['POST'])]
    public function addCollection(Request $request, $id): Response
    {
        $collection_name = $request->request->get('name');
        $add_collection_request = new AddCollectionRequest($id, $collection_name);
        $response = $this->addCategoryUseCase->addCollection($add_collection_request);

        return new Response(json_encode($response), Response::HTTP_CREATED);
    }

    #[Route('/product/{product_id}/collection/{collection_id}', methods: ['GET'])]
    public function getCollection(Request $request, $product_id, $collection_id): Response
    {
        try {
            $collection_request = new GetCollectionRequest($product_id, $collection_id);
            $collection_response = $this->getCollectionUseCase->getCollection($collection_request);

            return new Response(json_encode($collection_response), status: Response::HTTP_OK);
        } catch (ProductNotFoundException) {
            return new Response(status: Response::HTTP_NOT_FOUND);
        }
    }
}