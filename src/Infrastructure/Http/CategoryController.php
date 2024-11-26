<?php
namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CategoryController
{
    #[Route('/category')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response();

    }
}