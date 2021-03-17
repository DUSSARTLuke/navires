<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MessageType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;
use App\Service\GestionContact;

/**
 * @Route("/message", name="message_")
 */
class MessageController extends AbstractController
{

  /**
   * @Route("/contact", name="contact")
   */
  public function formContact(Request $request, GestionContact $gestionContact)
  {
    $message = new Message();
    $form = $this->createForm(MessageType::class, $message);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {


      $message = $form->getData();

      $gestionContact->envoiMailContact($message);

      $this->addFlash('notification', "Votre message a bien été envoyé");
      return $this->redirectToRoute("message_contact");
    }
    if( $form->isSubmitted() && !($form->isValid())){
      $this->addFlash('warning', "Votre message n'a pas bien été envoyé, votre message est trop court");
    }
    return $this->render('message/contact.html.twig', [
        'form' => $form->createView(),
    ]);
  }
}
