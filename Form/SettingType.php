<?php

namespace Fbeen\SettingsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Fbeen\SettingsBundle\Service\SettingsHelper;

class SettingType extends AbstractType
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
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $setting = $event->getData();
            $form = $event->getForm();
            
            $type = \Symfony\Component\Form\Extension\Core\Type\TextType::class;
            $fieldOptions = array(
                    'label' => false,
                    'required' => $setting->getRequired()
            );

            if($setting->getType() == 'integer') {
                $type = \Symfony\Component\Form\Extension\Core\Type\IntegerType::class;
            } else if($setting->getType() == 'decimal') {
                $type = \Symfony\Component\Form\Extension\Core\Type\NumberType::class;
            } else if($setting->getType() == 'boolean') {
                $setting->setValue(filter_var($setting->getValue(), FILTER_VALIDATE_BOOLEAN));
                $type = \Symfony\Component\Form\Extension\Core\Type\CheckboxType::class;
            } else if($setting->getType() == 'email') {
                $type = \Symfony\Component\Form\Extension\Core\Type\EmailType::class;
                $fieldOptions['constraints'] = array(
                    new \Symfony\Component\Validator\Constraints\Email()
                );
            }

            $form->add('value', $type, $fieldOptions);
        });
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
