<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LightSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brightness', TextType::class, ['required' => false])
            ->add('temperature', TextType::class, ['required' => false])
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }
}
