<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Professionnel;

class RendezVousFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeure', DateTimeType::class, [
                'label' => 'Date et Heure du Rendez-vous',
                'widget' => 'single_text',
            ])
            ->add('professionnel', EntityType::class, [
                'class' => Professionnel::class,
                'choice_label' => function (Professionnel $professionnel) {
                    return $professionnel->getPrenom() . ' ' . $professionnel->getNom() . ' (' . $professionnel->getSpecialite() . ')';
                },
                'label' => 'Choisissez un professionnel',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
