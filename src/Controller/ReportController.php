<?php

namespace App\Controller;

use App\Repository\CowRepository;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/Report')]
class ReportController extends AbstractController
{
    #[Template('Report/report.html.twig')]
    #[Route('/', name: 'report')]
    public function abattoirReportCount(CowRepository $repository)
    {
        $abattoirCount = $repository->getAbattoirReport();
        $totalMilk = $repository->sumOfMilkProduced();
        $necessaryFeed = $repository->amountOfFeedNeeded();
        $totalCows = $repository->countHighConsumptionOfYoungCattle();
        return [
            'abattoirCount' => $abattoirCount,
            'totalMilk' => $totalMilk,
            'necessaryFeed' => $necessaryFeed,
            'totalCows' => $totalCows
        ];
    }
}