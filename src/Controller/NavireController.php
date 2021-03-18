<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Navire;
use App\Form\NavireType;
use App\Repository\NavireRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/navire", name="navire_")
 */
class NavireController extends AbstractController
{

  public function index(): Response
  {
    return $this->render('navire/index.html.twig', [
        'controller_name' => 'NavireController',
    ]);
  }

  /**
   * 
   * @Route("/creer", name="creer")
   * @param Request $request
   * @param EntityManagerInterface $manager
   * @return Response
   */
  public function creer(Request $request, EntityManagerInterface $manager, NavireRepository $repo): Response
  {
    
    $navire = new Navire();
    $form = $this->createForm(NavireType::class, $navire);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      
      $manager->persist($navire);
      $manager->flush();
      return $this->redirectToRoute('home');
    }
    return $this->render('navire/creer.html.twig',
        ['form' => $form->createView()]);
  }

  /**
   * 
   * @Route("/modifier/{id}", name="modifier")
   * @param Request $request
   * @param EntityManagerInterface $manager
   * @return Response
   */
  public function modifier(Request $request, EntityManagerInterface $manager, int $id, NavireRepository $repo): Response
  {
    
    $navire = $repo->find($id);
    $form = $this->createForm(NavireType::class, $navire);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $manager->persist($navire);
      $manager->flush();
      return $this->redirectToRoute('home');
    }
    return $this->render('navire/modification.html.twig',
        ['form' => $form->createView(), 'imo' => $navire->getImo(), 'mmsi' => $navire->getMmsi()
    ]);
  }

  /**
   * @Route("voirtous", name="voirtous")
   * 
   * @return Response
   */
  public function voirTous(NavireRepository $repo): Response
  {
    $navires = $repo->findAll();

    return $this->render('navire/voirtous.html.twig', ['navires' => $navires]);
  }
}
