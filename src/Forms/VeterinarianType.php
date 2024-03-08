<?php

namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use function Sodium\add;

class VeterinarianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => 'Nome',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nome'],
                'required' => true
            ])
            ->add('crmv', TextType::class, [
                'label' => 'Código do Veterinário',
                'attr' => ['class' => 'form-control', 'placeholder' => 'CRMV'],
            ])
        ;
    }
}