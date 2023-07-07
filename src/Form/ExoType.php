<?php

namespace App\Form;

use App\Entity\Exo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('niveau')
            ->add('nom')
            ->add('prenom')
            ->add('pathologie')
            ->add('quel_age')
            ->add('age_maladie')
            ->add('vivre_quatidien')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exo::class,
        ]);
    }
}
