<?php
namespace App\Form;

use App\Entity\Navire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\AisShipType;

class NavireType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('imo', TextType::class)
      ->add('nom', TextType::class)
      ->add('mmsi', TextType::class)
      ->add('indicatifAppel', TextType::class)
      ->add('longueur')
      ->add('largeur')
      ->add('tirant_eau')
      ->add('leType', EntityType::class, [
        'class' => AisShipType::class,
        'choice_label' => 'libelle',
        'expanded' => false,
        'multiple' => false,
      ])
      ->add('eta', DateTimeType::class, [
        'widget' => 'single_text'
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Navire::class,
    ]);
  }
}
