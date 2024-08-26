<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class HPIQuestionnaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('age', IntegerType::class, [
                'label' => 'Quel âge avez-vous ?',
                'required' => true,
            ])
            ->add('feeling_different', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'label' => 'Vous sentez-vous différent(e) des autres / en décalage avec les autres ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('different_way', ChoiceType::class, [
                'choices' => [
                    'Socialement' => 'social',
                    'Intellectuellement' => 'intellectual',
                    'Émotionnellement' => 'emotional',
                ],
                'label' => 'De quelle façon ?',
                'expanded' => true,
                'multiple' => true,
                'required' => true,
            ])
            ->add('always_felt_this_way', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                    'Je ne sais pas' => 'not_sure',
                ],
                'label' => 'Est-ce que ça a toujours été le cas ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('sensitivity', ChoiceType::class, [
                'choices' => [
                    'Très sensible' => 'very_sensitive',
                    'Extrêmement sensible' => 'extremely_sensitive',
                    'Modérément sensible' => 'moderately_sensitive',
                    'Peu sensible' => 'less_sensitive',
                ],
                'label' => 'Vous décririez-vous comme une personne sensible ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('strong_emotions', ChoiceType::class, [
                'choices' => [
                    'Souvent' => 'often',
                    'Parfois' => 'sometimes',
                    'Rarement' => 'rarely',
                ],
                'label' => 'Certaines situations vous font-elles ressentir des émotions fortes ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('injustice_sensitivity', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'label' => 'En particulier, êtes-vous sensible aux injustices ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('empathy', ChoiceType::class, [
                'choices' => [
                    'Toujours' => 'always',
                    'Souvent' => 'often',
                    'Parfois' => 'sometimes',
                    'Rarement' => 'rarely',
                ],
                'label' => 'Êtes-vous empathique ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('perfectionism', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'label' => 'Vous décririez-vous comme une personne perfectionniste ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('curiosity', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'label' => 'Vous décririez-vous comme une personne curieuse ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('boredom', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'label' => 'Vous ennuyez-vous facilement ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('thought_process', ChoiceType::class, [
                'choices' => [
                    'Oui, beaucoup' => 'yes_a_lot',
                    'Oui, parfois' => 'yes_sometimes',
                    'Non' => 'no',
                ],
                'label' => 'Avez-vous l\'impression de réfléchir beaucoup ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('thought_pattern', ChoiceType::class, [
                'choices' => [
                    'Oui, souvent' => 'yes_often',
                    'Oui, parfois' => 'yes_sometimes',
                    'Non' => 'no',
                ],
                'label' => 'Est-ce que vos pensées partent un peu dans tous les sens ?',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre',
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
