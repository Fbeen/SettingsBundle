<?php

namespace Fbeen\SettingsBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Fbeen\SettingsBundle\Model\SettingContainer;

/**
 * Description of SettingsHelper
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
class SettingsHelper
{
    private $em;
    private $settings;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->settings = $em->getRepository('FbeenSettingsBundle:Setting')->findAll();
    }
    
    public function getTypes()
    {
        return array(
            'string' => 'string',
            'email' => 'email',
            'boolean' => 'boolean',
            'integer' => 'integer',
            'decimal' => 'decimal',
            'email' => 'email'
        );
    }
    
    public function getSettingContainer()
    {
        $settingContainer = new SettingContainer();
        $settingContainer->setSettings(new ArrayCollection($this->settings));

        return $settingContainer;
    }
    
    public function updateSetting($identifier, $value)
    {
        foreach($this->settings as $setting) {
            if($setting->getIdentifier() == $identifier) {
                $setting->setValue($value);
                $this->em->flush();
                
                return true;
            }
        }
        
        throw new NotFoundHttpException("Setting with identifier '" . $identifier . "' not found.");        
    }
    
    public function getSetting($identifier)
    {
        foreach($this->settings as $setting)
        {
            if($setting->getIdentifier() == $identifier)
            {
                return $setting->getValue();
            }
        }
        
        throw new NotFoundHttpException("Setting with identifier '" . $identifier . "' not found.");
    }
}
