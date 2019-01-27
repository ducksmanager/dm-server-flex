<?php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route(methods={"GET"}, path="/hello/{name}")
     * @param string          $name
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index($name, LoggerInterface $logger): Response {
        $logger->info("Saying hello to $name!");
        return new JsonResponse(["message" => "Hello $name"]);
    }
}
