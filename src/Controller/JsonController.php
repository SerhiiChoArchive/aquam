<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class JsonController extends AbstractController
{
    /**
     * @Route("/price-list", methods={"GET"})
     */
    public function priceList()
    {
        $json = @file_get_contents(get_cache_file_path('price-list'));
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }
}