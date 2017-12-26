<?php

namespace Fbeen\SettingsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Fbeen\SettingsBundle\Form\SettingType;

class SettingContainerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('settings', CollectionType::class, array(
                'label' => false,
                'entry_type' => SettingType::class,
                'entry_options' => array('label' => false)
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fbeen\SettingsBundle\Model\SettingContainer',
            'dev_mode' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fbeen_settingsbundle_settingcontainer';
    }


}
