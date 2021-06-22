<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Repository\CampaignRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\PayementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CampaignRepository $campaignRepository, ParticipantsRepository $participantsRepository, PayementRepository $payementRepository): Response
    {
        $campaigns = $campaignRepository->findAll();
        
        $participants = $participantsRepository->FindBy(['campaign_id' => $campaigns]);

        $payments = $payementRepository->FindBy(['participant_id' => $participants]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'campaigns' => $campaigns,
            'participants' => $participants,
            'payments' => $payments,
            
        ]);
    }
}