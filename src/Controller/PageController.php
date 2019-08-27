<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class PageController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function home()
    {
        return $this->render('pages/home.html.twig', [
            'message' => Helper::getValidationMessage(),
        ]);
    }
}