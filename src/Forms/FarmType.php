<?php

namespace App\Forms;

use App\Entity\Veterinarian;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FarmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => 'Nome:',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nome'],
                'required' => true
            ])
            ->add('tamanho', NumberType::class, [
                'label' => 'Tamanho:',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Tamanho em Hecteres'],
                'required' => false
            ])
            ->add('responsavel', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Responsável'],
                'label' => 'Responsável pela Fazenda:'
            ])
            ->add('veterinarios', EntityType::class, [
                'class' => Veterinarian::class,
                'choice_label' => 'nome',
                'multiple' => true,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Selecione um veterinario'],
                'required' => false
            ])
        ;
    }
}