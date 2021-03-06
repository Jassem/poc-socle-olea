<?php

namespace App\Form;

use App\Document\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description', TextareaType::class);
        $builder->add('status', ChoiceType::class, [
            'choices' => $this->getChoices()])
            ->add('client', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Client'
                ]
            ])
            ->add('style', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Style'
                ]
            ])
            ->add('numeroCommande', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Numero Commande'
                ]
            ])
            ->add('published');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Room::STATUS;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}