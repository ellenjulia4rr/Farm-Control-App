<?php

namespace App\Forms;

use App\Entity\Cow;
use App\Entity\Farm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class CowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Código do Animal'],
                'label' => 'Código'
            ])
            ->add('milk', NumberType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Leite produzido por semana'],
                'label' => 'Leite',
                'required' => false
            ])
            ->add('portion', NumberType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ração ingerida por semana'],
                'label' => 'Racao',
                'required' => true
            ])
            ->add('weight', NumberType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Peso do animal'],
                'label' => 'Peso',
                'required' => true
            ])
            ->add('birth', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Data de nascimento',
                'attr' => ['class' => 'form-control-sm form-control dates js-datepicker', 'placeholder' => 'Data de Nascimento'],
                'format' => 'dd/MM/yyyy'


            ])
            ->add('farm', EntityType::class, [
                'class' => Farm::class,
                'choice_label' => 'nome',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Fazenda'
            ])
        ;
    }
}