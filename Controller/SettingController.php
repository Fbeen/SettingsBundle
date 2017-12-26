<?php

namespace Fbeen\SettingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Setting controller.
 */
class SettingController extends Controller
{
    /**
     * Edit setting-values for administrators
     */
    public function editAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $settingContainer = $this->get('fbeen_settings.settings_helper')->getSettingContainer();

        $form = $this->createForm('Fbeen\SettingsBundle\Form\SettingContainerType', $settingContainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fbeen_settings_edit');
        }

        return $this->render('@FbeenSettingsBundle/Resources/views/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Modify settings for developers
     */
    public function modifyAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        
        $settingContainer = $this->get('fbeen_settings.settings_helper')->getSettingContainer();

        $originalSettings = new ArrayCollection();
        foreach ($settingContainer->getSettings() as $setting) {
            $originalSettings->add($setting);
        }

        $form = $this->createForm('Fbeen\SettingsBundle\Form\DevSettingContainerType', $settingContainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            /*
             * Delete Setting entities from the database that are missing in the collection
             */
            foreach($originalSettings as $originalSetting) {
                if (false === $settingContainer->getSettings()->contains($originalSetting)) {
                    $em->remove($originalSetting);
                }
            }

            /*
             * Persist new generated Setting entities
             */
            foreach($settingContainer->getSettings() as $setting) {
                if($setting->getId() < 1) {
                    $em->persist($setting);
                }
            }
            $em->flush();

            return $this->redirectToRoute('_fbeen_settings_developer');
        }

        return $this->render('@FbeenSettingsBundle/Resources/views/modify.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
