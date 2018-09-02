<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

class YeelightController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function yeelight(Request $request): Response
    {
        $brightness = $request->get('brightness');
        $temperature = $request->get('temperature');
        $rgb = $request->get('rgb');
        if ($brightness !== null) {
            $process1 = new Process('yeecli --bulb led1 brightness ' . $brightness);
            $process2 = new Process('yeecli --bulb led2 brightness ' . $brightness);
            $process1->run();
            $process2->run();
        }

        if ($temperature !== null) {
            $process1 = new Process('yeecli --bulb led1 temperature ' . $temperature);
            $process2 = new Process('yeecli --bulb led2 temperature ' . $temperature);
            $process1->run();
            $process2->run();
        }

        if ($rgb !== null) {
            $process1 = new Process('yeecli --bulb led1 rgb ' . $rgb);
            $process2 = new Process('yeecli --bulb led2 rgb ' . $rgb);
            $process1->run();
            $process2->run();
        }

        return $this->render('yeelight.html.twig');
    }

    /**
     * @Route("/toggle", name="yeelight-toggle")
     */
    public function yeelightStop(): RedirectResponse
    {
        $process1 = new Process('yeecli --bulb led1 toggle');
        $process2 = new Process('yeecli --bulb led2 toggle');
        $process1->run();
        $process2->run();

        return $this->redirectToRoute('yeelight');
    }

    /**
     * @Route("/alert")
     *
     * @return Response
     */
    public function alert(): Response
    {
        $process1 = new Process('yeecli --bulb led1 preset alarm');
        $process2 = new Process('yeecli --bulb led2 preset alarm');
        $process1->run();
        $process2->run();

        return new Response('ok');
    }
}
