<?php

namespace Fbeen\SettingsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Fbeen\SettingsBundle\Model\Settings;

/**
 * Description of SettingsHelper
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
class SettingsHelper
{
    private $container;
    private $settings;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->initialize();
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
    
    public function initialize()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        
        $settings = $em->getRepository('FbeenSettingsBundle:Setting')->findAll();

        $this->settings = new Settings();
        $this->settings->setSettings(new ArrayCollection($settings));
    }
    
    public function getSettings()
    {
        return $this->settings;
    }
    
    public function getSetting($identifier)
    {
        foreach($this->settings->getSettings() as $setting)
        {
            if($setting->getIdentifier() == $identifier)
            {
                return $setting->getValue();
            }
        }
        
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Setting with identifier '" . $identifier . "' not found.");
    }
}
