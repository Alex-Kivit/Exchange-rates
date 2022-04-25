<?php

namespace App\Form\ExchangeRates;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExchangeRatesType extends AbstractType
{
    private $minDate = '1999-01-04';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $builder->getData();

        $builder
            ->add('date', DateType::class, [
                'label' => 'form.date',
                'widget' => 'single_text',
                'attr' => [
                    'min' => $this->minDate,
                    'max' => date("Y-m-d")
                ] 
            ])
        ;

        $builder->add('save', SubmitType::class, [
            'label' => 'form.search',
            'attr' => [
                'class' => 'btn-lg btn-primary'
            ]
        ]);
    }

}
