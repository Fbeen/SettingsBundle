<?php

namespace Fbeen\SettingsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Fbeen\SettingsBundle\Service\SettingsHelper;

class DevSettingType extends AbstractType
{
    private $helper;

    public function __construct(SettingsHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', null, array(
                'label' => false
            ))
            ->add('type', ChoiceType::class, array(
                'label' => false,
                'choices' => $this->helper->getTypes()
            ))
            ->add('identifier', null, array(
                'label' => false
            ))
            ->add('required', null, array(
                'label' => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fbeen\SettingsBundle\Entity\Setting'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fbeen_settingsbundle_setting';
    }


}
