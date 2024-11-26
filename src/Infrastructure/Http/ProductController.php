<?php
namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ProductController
{
    #[Route('/product')]
    public function productt(): Response
    {
        $number = random_int(0, 100);

        return new Response();

    }
}