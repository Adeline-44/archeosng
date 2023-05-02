<?php

namespace App\Form;

use App\Entity\Employee;
use App\Form\EventSubscriber\CalculMonthBaseSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class EmployeeTypeCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weekBase', TextType::class, [
                'label' => 'Base du stagiaire de catégorie C',
                'attr'=> [
                    'class' => '',
                    'size' => 4,
                    'onblur' => 'calculer()'
                ],
                'constraints' => [
                    new Positive(['message' => 'La valeur saisie doit être positive']),
                    new NotNull(['message' => 'Valeur obligatoire'])
                ]
            ])
            ->add('monthBase', NumberType::class, [
                'required' => false,
                'label' => 'soit',
                'disabled' => true,
                'attr' =>[
                    'class' => '',
                    'size' => 4


                ]
            ])

            /*->add('submit', SubmitType::class,
                [
                    'label' =>'OK',
                    'attr' => ['class' => 'btn btn-primary', 'onClick' =>"calculer()"]
                ]);*/
            ;

        ;

/*
        $formModifier = function (FormInterface $form, $weekBase = 35) {
            $monthBase = round($weekBase * 52/12, 2);
            $form->add('monthBase', TextType::class, [
                'required' => 'false',
                'attr' => [
                    'value' => $monthBase
                ]
            ]);
        };

        $builder->get('weekBase')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $weekBase = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $weekBase);
            }
        );*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
