<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PortType;
use App\Entity\Port;
use App\Repository\PortRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/port", name="port_")
 */
class PortController extends AbstractController {

  /**
   * 
   * @Route("/voirtous", name="voirtous")
   * @param PortRepository $repo
   * @return type
   */
  public function voirtous(PortRepository $repo) {
    $ports = $repo->findAll();

    return $this->render('port/voirtous.html.twig', [
        'ports' => $ports, 'type' => false
    ]);
  }

  /**
   * 
   * @Route("/creer", name="creer")
   * @param Request $request
   * @param EntityManagerInterface $manager
   * @return Response
   */
  public function creer(Request $request, EntityManagerInterface $manager): Response {
    $port = new Port();
    $form = $this->createForm(PortType::class, $port);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $manager->persist($port);
      $manager->flush();
      return $this->redirectToRoute('home');
    }
    return $this->render('port/edit.html.twig',
        ['form' => $form->createView(),
    ]);
  }

}
