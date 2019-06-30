<?php

namespace ContactListBundle\Form;


use ContactListBundle\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class, ['label' => 'name', 'trim' => true])
            ->add('surname', TextType::class, ['label' => 'surname', 'trim' => true])
            ->add('description', TextType::class, ['label' => 'description', 'trim' => true])
            ->add('address', EntityType::class, ['class' => 'ContactListBundle\Entity\Address'])
            ->add('email', EntityType::class, ['class' => 'ContactListBundle\Entity\Email'])
            ->add('phone', EntityType::class, ['class' => 'ContactListBundle\Entity\Phone'])
            ->add('groups', EntityType::class, ['class' => 'ContactListBundle\Entity\Groups', 'choice_label' => 'name'])
            ->add('save', SubmitType::class, ['label' => 'Save Person']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Person::class]
        );
    }
    
    
}