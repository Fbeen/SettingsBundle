<?php

namespace Fbeen\SettingsBundle\Twig;

use Fbeen\SettingsBundle\Service\SettingsHelper;

class TwigExtension extends \Twig_Extension
{
    private $helper;

    public function __construct(SettingsHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('setting', array($this, 'getSetting')),
        );
    }

    public function getSetting($identifier)
    {
        return $this->helper->getSetting($identifier);
    }

    public function getName()
    {
        return 'fbeen_settings_twig_extension';
    }
}