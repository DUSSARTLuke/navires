<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\NavireRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * @Route("/search", name="search_")
 */
class SearchController extends AbstractController
{

  public function searchBar()
  {
    $form = $this->createFormBuilder()
      ->setAction($this->generateUrl("search_handlesearch"))
      ->add('cherche', TextType::class)
      ->add('choix', ChoiceType::class, array(
        'choices' => array(
          'IMO' => 'imo',
          'MMSI' => 'mmsi'), 'multiple' => false,
        'expanded' => true))
      ->add('Rechercher', SubmitType::class)
      ->getForm()
    ;
    return $this->render('elements/searchbar.html.twig', [
        'formSearch' => $form->createView()
    ]);
  }

  /**
   * 
   * @Route("/handlesearch", name="handlesearch")
   * @param Request $request
   * @param NavireRepository $repo
   * @return Response
   */
  public function handleSearh(Request $request, NavireRepository $repo): Response
  {
    $valeur = $request->request->get('form')['cherche'];

    if ($request->request->get('form')['choix'] == 'imo') {
      $id = $repo->getIdby('imo', $valeur);
    } else {
      $id = intval($repo->getIdby('mmsi', $valeur));
    }
    return $this->redirectToRoute('navire_modifier', ['id' => $id]);
  }
}
