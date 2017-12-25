<?php

namespace Fbeen\SettingsBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Settings
 *
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
class Settings
{
    private $settings;
    
    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }
            
    /**
     * Add setting
     *
     * @param \Fbeen\SettingsBundle\Entity\Setting $setting
     *
     * @return Settings
     */
    public function addSetting(\Fbeen\SettingsBundle\Entity\Setting $setting)
    {
        $this->settings[] = $setting;

        return $this;
    }

    /**
     * Remove setting
     *
     * @param \Fbeen\SettingsBundle\Entity\Setting $setting
     */
    public function removeSetting(\Fbeen\SettingsBundle\Entity\Setting $setting)
    {
        $this->settings->removeElement($setting);
    }

    /**
     * Set settings
     *
     * @param \Doctrine\Common\Collections\Collection
     * 
     * @return Settings
     */
    public function setSettings(ArrayCollection $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettings()
    {
        return $this->settings;
    }

}
