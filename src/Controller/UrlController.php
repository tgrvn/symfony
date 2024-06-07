<?php

namespace App\Controller;

use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/s', name: 'short_')]
class UrlController extends AbstractController
{
    #[Route('/encode/{url}', name: 'encode', requirements: ['url' => '.*'])]
    public function encode(string $url, IUrlEncoder $encoder): Response
    {
        $code = $encoder->encode($url);
        
        return new Response($code);
    }

    #[Route('/decode/{code}', name: 'decode', requirements: ['code' => '\w{10}'])]
    public function decode(string $code, IUrlDecoder $decoder): Response
    {
        $url = $decoder->decode($code);

        return new Response($url);
    }
}
