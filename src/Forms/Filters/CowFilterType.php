<?php

namespace App\Forms\Filters;

use App\Entity\Farm;
use App\Enum\StatusClattle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CowFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', IntegerType::class,[
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Código'],
                'label' => 'Código:'
            ])
            ->add('milk',NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Qtde. maior ou igual'],
                'label' => 'Leite semanal produzido:'
            ])
            ->add('portion', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Qtde. maior ou igual'],
                'label' => 'Ração semanal ingerida:'
            ])
            ->add('weight', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Qtde. maior ou igual'],
                'label' => 'Peso:'
             ])
            ->add('live', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Todos' => null,
                    'Bovinos Vivos' => StatusClattle::VIVO,
                    'Bovinos Abatidos' => StatusClattle::MORTO,
                    'Bovinos para Abate' => StatusClattle::ABATE
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Situação',
                'choice_label' => function ($value, $key, $index) {
                    return $key;
                },
                'data' => StatusClattle::VIVO,
            ])
            ->add('birth', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
                'attr' => ['class' => 'form-control dates js-datepicker'],
                'label' => 'Data de Nascimento'
            ])
            ->add('farms', EntityType::class, [
                'class' => Farm::class,
                'choice_label' => 'nome',
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'label' => 'Fazendas'
            ])
        ;
    }
}