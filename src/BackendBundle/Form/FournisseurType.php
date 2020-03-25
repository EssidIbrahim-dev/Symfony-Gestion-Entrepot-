<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;


class FournisseurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,array('attr' => array('class' => 'form-control'),'constraints' => array(
                new NotBlank(),
                new Length(array('min' =>4)),
                new Length(array('max' => 20)),
            )))

            ->add('lastname',TextType::class,array('attr' => array('class' => 'form-control'),'constraints' => array(
                new NotBlank(),
                new Length(array('min' =>4)),
                new Length(array('max' => 20)),
            )))

            ->add('phoneNumber',TextType::class,array('attr' => array('class' => 'form-control'),'constraints' => array(
                new NotBlank(),
                new Length(array('min' =>8)),
                new Length(array('max' => 11)),
            )))

            ->add('address',TextType::class,array('attr' => array('class' => 'form-control'),'constraints' => array(
                new NotBlank(),
                new Length(array('min' =>4)),
                new Length(array('max' => 20)),
            )))

            ->add('email',EmailType::class,array('attr' => array('class' => 'form-control'), 'constraints' => array(
                new Email())))



        ;
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Fournisseur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_fournisseur';
    }


}
