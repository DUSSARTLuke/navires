<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaysRepository;
use App\Form\PaysType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/pays", name="pays_")
 */
class PaysController extends AbstractController {

  
  /**
   * 
   * @Route("/details/{id}", name="detailsPays")
   * @param PaysRepository $repo
   * @param int $id
   * @return type
   */
  public function voirPays(Request $request, EntityManagerInterface $manager, PaysRepository $repo, int $id){
    $pays = $repo->find($id);
    $form = $this->createForm(PaysType::class, $pays);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $manager->persist($pays);
      $manager->flush();
      return $this->redirectToRoute('home');
    }
    return $this->render('pays/voirdetails.html.twig',
      ['form' => $form->createView(),
        ]);
  }
  
  /**
   * 
   * @Route("/voirtous", name="voirtous")
   * @param PaysRepository $repo
   * @return type
   */
  public function voirtous(PaysRepository $repo) {
    $pays = $repo->findAll();

    return $this->render('pays/voirtous.html.twig',
        ['pays' => $pays]);
  }

  
}
