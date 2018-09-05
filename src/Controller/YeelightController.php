<?php

namespace App\Controller;

use App\Entity\ColorSettings;
use App\Entity\LightSettings;
use App\Form\ColorSettingsType;
use App\Form\LightSettingsType;
use App\Yeelight\YeelightClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

class YeelightController extends AbstractController
{
    /**
     * @var YeelightClientInterface
     */
    private $client;

    public function __construct(YeelightClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/", name="yeelight-index")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function yeelight(Request $request): Response
    {
        $status = $this->client->getStatus('led1');

        $lightSettings = new LightSettings();
        $lightSettings->brightness = $status->bright;
        $lightSettings->temperature = $status->ct;

        $colorSettings = new ColorSettings();
        $lightForm = $this->createForm(LightSettingsType::class, $lightSettings);
        $colorForm = $this->createForm(ColorSettingsType::class, $colorSettings);

        $lightForm->handleRequest($request);
        $colorForm->handleRequest($request);

        if ($lightForm->isSubmitted() && $lightForm->isValid()) {
            /** @var LightSettings $lightSettings */
            $lightSettings = $lightForm->getData();

            if ($lightSettings->brightness !== null) {
                $this->setBulb('brightness', $lightSettings->brightness);
            }

            if ($lightSettings->temperature !== null) {
                $this->setBulb('temperature', $lightSettings->temperature);
            }

            return $this->redirectToRoute('yeelight-index');
        }

        if ($colorForm->isSubmitted() && $colorForm->isValid()) {
            /** @var ColorSettings $colorSettings */
            $colorSettings = $colorForm->getData();

            $this->setBulb('rgb', substr($colorSettings->rgb, 1));
        }

        return $this->render('yeelight.html.twig', [
            'lightForm' => $lightForm->createView(),
            'colorForm' => $colorForm->createView(),
        ]);
    }

    /**
     * @Route("/toggle", name="yeelight-toggle")
     */
    public function yeelightStop(): RedirectResponse
    {
        $this->setBulb('toggle');

        return $this->redirectToRoute('yeelight-index');
    }

    /**
     * @Route("/reset", name="yeelight-reset")
     */
    public function yeelightReset(): RedirectResponse
    {
        $this->setBulb('temperature', '88');
        $this->setBulb('temperature', '2500');

        return $this->redirectToRoute('yeelight-index');
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

    private function setBulb(string $param, $value = null): void
    {
        $process1 = new Process(sprintf(
            'yeecli --bulb led1 %s %s', $param, $value
        ));
        $process2 = new Process(sprintf(
            'yeecli --bulb led2 %s %s', $param, $value
        ));
        $process1->run();
        $process2->run();
    }
}
