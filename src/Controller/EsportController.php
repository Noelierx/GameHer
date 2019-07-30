<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EsportController extends AbstractController
{
    /**
     * @Route("/esport", name="esport", methods={"GET"})
     */
    public function esport()
    {
        return $this->render('views/esport.html.twig');
    }
}
