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
        
        $settings = $this->get('fbeen_settings.settings_helper')->getSettings();

        $form = $this->createForm('Fbeen\SettingsBundle\Form\SettingsType', $settings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fbeen_settings_edit');
        }

        return $this->render('FbeenSettingsBundle:Settings:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Modify settings for developers
     */
    public function developerAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        
        $settings = $this->get('fbeen_settings.settings_helper')->getSettings();

        $originalSettings = new ArrayCollection();
        foreach ($settings->getSettings() as $setting) {
            $originalSettings->add($setting);
        }

        $form = $this->createForm('Fbeen\SettingsBundle\Form\DevSettingsType', $settings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            /*
             * Delete Setting entities from the database that are missing in the collection
             */
            foreach($originalSettings as $originalSetting) {
                if (false === $settings->getSettings()->contains($originalSetting)) {
                    $em->remove($originalSetting);
                }
            }

            /*
             * Persist new generated Setting entities
             */
            foreach($settings->getSettings() as $setting) {
                if($setting->getId() < 1) {
                    $em->persist($setting);
                }
            }
            $em->flush();

            return $this->redirectToRoute('_fbeen_settings_developer');
        }

        return $this->render('FbeenSettingsBundle:Settings:developer.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
