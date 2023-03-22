<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('poste', TextType::class,
                [
                    'required'=>true,
                    'label'=>'Poste',
                    'attr'=> [
                        'placeholder' => "ex : Adjoint administratif territorial de 1ère classe",
                        'class' => 'form-control'
                    ]
                ])
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    '-Choisir-' => '0',
                    'Catégorie A' => '1',
                    'Catégorie B' => '2',
                    'Catégorie C' => '3'
                ]
            ]);

            // Si la catégorie = 1 (A), on affiche le cadre emploi
        //Le formmodifier c'est l'action qui sera exécutée en fonction de l'eventlistener en dessous
        $formModifierOne = function (FormInterface $form, $categorie = null) {
            if($categorie == 1) {
                $form->add('cadreEmploi', ChoiceType::class, [
                    'label' => 'Cadre d\'emplois',
                    'attr' => ['class' =>'form-control'],
                    'choices' => [
                        '-Cadre d\'emploi-' => '0',
                        'Attachés' => '2',
                        'Attachés de conservation du patrimoine' => '6',
                        'Bibliothécaires' => '5',
                        'Conservateurs de bibliothèques' => '4',
                        'Conservateurs du patrimoine' => '3',
                        'Ingénieurs' => '1'
                    ]
                ]);
            }
        };



        // On place l'eventListener sur le cadreEmploi
        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($formModifierOne) {
                $categorie = $event->getData()->getCategorie();
                $formModifierOne($event->getForm(), $categorie);

            });
        //on ajoute le post submit pour que la valeur sélectionnée soit prise en compte à la validation du form
        $builder->get('categorie')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifierOne) {
                $categorie = $event->getForm()->getData();
                $formModifierOne($event->getForm()->getParent(), $categorie);
            }
        );


            $builder->add('cadreEmploi', HiddenType::class, [
                'attr' => ['class' =>'form-control'
                ],
                'label' =>''
            ])

            ->add('militaire', ChoiceType::class, [
                'label' =>'Service militaire',
                'required' => true,
                'choices'=>[
                    '- Choisir -' =>'0',
                    'oui'=>'1',
                    'non'=>'0'
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('militaireMonths', HiddenType::class, [
                'attr' => ['class' =>'form-control'
                ],
                'label' =>''
            ])

            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Madame' => '2',
                    'Mademoiselle' => '1',
                    'Monsieur' => '3'
                ]
            ])
            ->add('lastName', TextType::class, [ 'label' => 'Nom'])
            ->add('firstName', TextType::class, [ 'label' => 'Prénom'])
            ->add('adr1', TextType::class, ['label' => 'Adresse', 'required' => false])
            ->add('adr2', TextType::class, ['label' => 'Complément d\'adresse', 'required' => false])
            ->add('cp', TextType::class, ['label' => 'Code Postal', 'required' => false])
            ->add('city', TextType::class, ['label' => 'Ville', 'required' => false]);

        //Le formmodifier c'est l'action qui sera exécutée en fonction de l'eventlistener en dessous
        $formModifier = function (FormInterface $form, $militaire = null) {
            if($militaire == 1) {
                $form->add('militaireMonths', TextType::class, [
                    'label' => 'Nombre de mois',
                    'attr' => ['class' =>'form-control']
                ]);
            }
        };



        // On place l'eventListener sur le militaire
        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($formModifier) {
                $militaire = $event->getData()->isMilitaire();
                $formModifier($event->getForm(), $militaire);

            });
        //on ajoute le post submit pour que la valeur sélectionnée soit prise en compte à la validation du form
        $builder->get('militaire')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier) {
                $militaire = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $militaire);
            }
        );

            $builder->add('submit', SubmitType::class,
                [
                    'label' =>'Valider',
                    'attr' => ['class' => 'btn btn-primary']
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
