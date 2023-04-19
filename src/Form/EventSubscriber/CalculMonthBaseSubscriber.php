<?php

namespace App\Form\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CalculMonthBaseSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents() : array
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event): void
    {
        $data = $event->getData();
        $weekBase = $data->getWeekBase();
        dd($data);
        $form = $event->getForm();


        if($weekBase ==35) {
            $defaultMonthBase = 151.67;
            $form->add('monthBase', TextType::class, [
                'label' => 'soit',
                'attr'=> [
                    'class' => '',
                    'size' => 4,
                    'value' => $defaultMonthBase
                ]
            ]);
        }
        if($weekBase !=35) {
            $defaultMonthBase = round($weekBase *52/12,2);
            $form->add('monthBase', TextType::class, [
                    'label' => 'soit',
                    'attr'=> [
                        'class' => '',
                        'size' => 4,
                        'value' => $defaultMonthBase
                    ]
                ]);
        }
    }
}