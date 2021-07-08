<?php

namespace App\Controller;

use App\Repository\PlatformRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlatformController extends AbstractController
{
    /**
     * Get all platforms
     * 
     * @Route("/platforms", name="platforms_browse", methods="GET")
     */
    public function browse(PlatformRepository $platformRepository): Response
    {
        $platforms = $platformRepository->findAll();

        return $this->json($platforms, 200, [], ['groups' => 'platforms_browse']);
    }
}
