<?php

namespace App\Forms\Filters;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class VeterinarianFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control-sm form-control', 'placeholder' => 'Nome ou CRMV'],
                'label' => 'Nome ou CRMV'
            ])
        ;
    }
}