<?php

namespace App\Forms\Filters;

use App\Entity\Veterinarian;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FarmFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control-sm form-control','placeholder' => 'Nome' ],
                'label' => 'Nome'
            ])
            ->add('tamanho', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control-sm form-control','placeholder' => 'Tamanho em Hectares' ],
                'label' => 'Tamanho'
            ])
            ->add('responsavel', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control-sm form-control','placeholder' => 'Responsável pela fazenda' ],
                'label' => 'Responsável'
            ])
            ->add('veterinarios', EntityType::class, [
                'class' => Veterinarian::class,
                'choice_label' => 'nome',
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'form-control-sm form-control','placeholder' => 'Nome' ],
                'label' => 'Veterinarios'
            ])
        ;
    }
}