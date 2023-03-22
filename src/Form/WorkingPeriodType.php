<?php

namespace App\Form;

use App\Entity\Profession;
use App\Entity\WorkingPeriod;
use App\Repository\ProfessionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceValue;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkingPeriodType extends AbstractType
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
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'public' => '1',
                    'privé' => '2'
                ],
                'placeholder' => '-- Choisir --',
                'label' => 'Type de service effectué durant cette période',
                'attr' => ['class' =>'form-control']
            ])
            ->add('cat', HiddenType::class, [
                'attr' => ['class' =>'form-control'
                    ]
            ])
            ->add('prof', HiddenType::class, [
                'attr' => ['class' =>'form-control'
                ]
            ]);

            $formModifier = function (FormInterface $form, $type = null) {
                if($type == 1) {
                    $form->add('cat', ChoiceType::class, [
                        'choices' => [
                            'Catégorie A' => 'A',
                            'Catégorie B' => 'B',
                            'Catégorie C' => 'C'
                        ],
                        'label' => 'Niveau du poste occupé durant cette période',
                        'attr' => ['class' =>'form-control']
                    ]);
                }
                else if ($type == 2){
                    $form->add('prof', EntityType::class, [
                        'class' => Profession::class,
                        'choice_label' => 'intitule'

                    ]);
                }
            };

            // On place l'eventListener sur le type
            $builder->addEventListener(FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use($formModifier) {
               // dump($event->getData());
                $type = $event->getData()->getType();
                $formModifier($event->getForm(), $type);

              });
            //on ajoute le post submit pour que la valeur sélectionnée soit prise en compte à la validation du form
            $builder->get('type')->addEventListener(
                FormEvents::POST_SUBMIT,
                function(FormEvent $event) use ($formModifier) {
                    $type = $event->getForm()->getData();
                    $formModifier($event->getForm()->getParent(), $type);
                }
            );

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
