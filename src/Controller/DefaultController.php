<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(KernelInterface $kernel): Response
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(['command' => 'app:create-data']);
        $output = new NullOutput();
        $application->run($input, $output);

        return new Response(
            'Success: Ads Data Has Been Inserted',
            201
        );
    }
}
