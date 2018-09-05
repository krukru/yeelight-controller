<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LightSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brightness', NumberType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 5,
                ],
            ])
            ->add('temperature', NumberType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1700,
                    'max' => 6500,
                    'step' => 100,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }
}
