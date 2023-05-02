<?php

namespace App\Form;

use App\Entity\WorkingPeriod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkingPeriodTypeC extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date de début de la période : ',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => true,
                'input' => 'datetime_immutable',
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'form-control']
            ])
            ->add('endDate', DateType::class,
                [
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => 'Date de fin de la période : ',
                    // prevents rendering it as type="date", to avoid HTML5 date pickers
                    'html5' => true,
                    'input' => 'datetime_immutable',
                    // adds a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control']
                ])

            ->add('hours', NumberType::class, [
                'required' => true,
                'label' => 'Nombre total d\'heures effectuées durant cette période ',
                'attr' => ['class' => 'form-control']

            ])

            ->add('type', ChoiceType::class, [
                'choices' => [
                    'public' => '1',
                    'privé' => '2'
                ],
                'placeholder' => '-- Choisir --',
                'label' => 'Type de service effectué durant cette période',
                'attr' => ['class' =>'form-control']
            ])
        ;

        $builder->add('submit', SubmitType::class,
            [
                'label' =>'Ajouter la période',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkingPeriod::class,
        ]);
    }
}
