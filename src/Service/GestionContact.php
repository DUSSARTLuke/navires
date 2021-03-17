<?php
// src/service/gestionContact.php
namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Doctrine\Persistence\ManagerRegistry;
use \Mailjet\Resources;
//use \Mailjet\Client;
use App\Entity\Message;
use App\Entity\User;

/**
 * Description of GestionContact
 *
 * @author Benoît
 */
class GestionContact
{
private Environment $twig;
//documentation : https://swiftmailer.symfony.com/docs/sending.html
  function __construct(Environment $env)
  {
    $this->twig = $env;
  }

  public function envoiMailContact(Message $message)
  {
    $mj = new \Mailjet\Client('3a2cf065781f74b50b701d94b93d66d2', '869c3aa7be089c0e60134da8e7cbe3dd', true, ['version' => 'v3.1']);
    $body = [
      'Messages' => [
        [
          'From' => [
            'Email' => "lukedussart@hotmail.fr",
            'Name' => "Luke"
          ],
          'To' => [
            [
              'Email' => "lukedussart@hotmail.fr",
              'Name' => "Luke"
            ]
          ],
          'Subject' => "Contact pris avec DussartCorp Navals",
          'TextPart' => "My first Mailjet email",
          'HTMLPart' => $this->twig->render(
                          'mail/mail.html.twig',
                          ['message' => $message]
          ),
          'CustomID' => "AppGettingStartedTest"
        ]
      ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success() && var_dump($response->getData());

  }

  
  // public static function envoiMailConfirmation(User $user)
  // {
  //   $mj = new \Mailjet\Client('3a2cf065781f74b50b701d94b93d66d2', '869c3aa7be089c0e60134da8e7cbe3dd', true, ['version' => 'v3.1']);
  //   $body = [
  //     'Messages' => [
  //       [
  //         'From' => [
  //           'Email' => "lukedussart@hotmail.fr",
  //           'Name' => "Luke"
  //         ],
  //         'To' => [
  //           [
  //             'Email' => $user->getEmail(),
  //             'Name' => $user->getNom()
  //           ]
  //         ],
  //         'Subject' => "Greetings from Mailjet.",
  //         'TextPart' => "My first Mailjet email",
  //         'HTMLPart' => "<h3> Vous venez de vous inscrire sur DussartNavalCorps</h3>",
  //         'CustomID' => "AppGettingStartedTest"
  //       ]
  //     ]
  //   ];
  //   $response = $mj->post(Resources::$Email, ['body' => $body]);
  //   $response->success() && var_dump($response->getData());

  // }


  // public static function EnregistrerMessage(Message $message): void
  // {
  //   $em = $this->doctrine->getManager();
  //   $em->persist($message);
  //   $em->flush();
  // }
}

/*$email = (new \Swift_Message('Demande de renseignement'))
      ->setFrom([$message->getMail() => 'Nouvelle demande'])
      ->setTo('lukedussart@hotmail.fr');
    $email->setBody(
      $this->environnementTwig->render(
        'mail/mail.html.twig',
        ['message' => $message]
      ),
      'text/html'
    );
    
    $email->attach(\Swift_Attachment::fromPath('documents/document.pdf'));
    $this->mail->send($email);
     */
  