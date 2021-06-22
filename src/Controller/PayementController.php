<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Payement;
use App\Form\PayementType;
use App\Repository\PayementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use DateTime;

/**
 * @Route("/payement")
 */
class PayementController extends AbstractController
{
    /**
     * @Route("/", name="payement_index", methods={"GET"})
     */
    public function index(PayementRepository $payementRepository): Response
    {
        return $this->render('payement/index.html.twig', [
            'payements' => $payementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="payement_new", methods={"GET","POST"})
     */
    public function new(Campaign $campaign, Request $request, PayementRepository $payementRepository): Response
    {
        $payement = new Payement();
        $form = $this->createForm(PayementType::class, $payement);
        $form->handleRequest($request);
        $montant=$request->request->get("montant");
        
        // dd($payement);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $payement->getParticipantId()->setCampaignId($campaign);

            Stripe::setApiKey('sk_test_51IuwAFEHR08MdWvwClmSXAvqn7j1Zl5W3hjQ856GZE2iz9o16Z5xu3jSDerQA0TJLoGHfkwN2IQwyMjvA6YKJN7P003HNA39NI');
            $paymentIntent = PaymentIntent::create([
                'amount' => $payement->getMontant()*100,
                'currency' => 'eur',
            ]);
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
            
            // //Recupération de campagne grace à son id en GET
            // $idCampaign = explode('=', $request-> getQueryString())[1]; 
            // $campaignRepository = $this->getDoctrine()->getRepository(Campaign::class);
            // $campaign = $campaignRepository->find($idCampaign);
            
            
            //set les parametres manquants
            
            $payement->setCreatedAt(new DateTime());
            $payement->setUpdatedAt(new DateTime());
            $payement->getParticipantId()->setCampaignId($campaign);
            
            //envoi a la bdd
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payement);
            $entityManager->flush();

            //redirection
            return $this->redirectToRoute('campaign_show', ['id' => $campaign->getId()]);
        }

        return $this->render('payement/new.html.twig', [
            'payement' => $payement,
            'form' => $form->createView(),
            'campaign' => $campaign,
            'montant' => $montant
        ]);
    }

    /**
     * @Route("/{id}", name="payement_show", methods={"GET"})
     */
    public function show(Payement $payement): Response
    {
        return $this->render('payement/show.html.twig', [
            'payement' => $payement,
        ]);
    }
    

    /**
     * @Route("/{id}/edit", name="payement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Payement $payement): Response
    {
        $form = $this->createForm(PayementType::class, $payement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payement_index');
        }

        return $this->render('payement/edit.html.twig', [
            'payement' => $payement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payement_delete", methods={"POST"})
     */
    public function delete(Request $request, Payement $payement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($payement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payement_index');
    }
}
