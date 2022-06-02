<?php

namespace wireframe\ComposerInstaller;

use Composer\Composer;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;

/**
 * The Plugin class
 *
 * This class registers our custom installers.
 *
 * @author Teppo Koivula <teppo@wireframe-framework.com>
 * @license Mozilla Public License v2.0 http://mozilla.org/MPL/2.0/
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * Register custom installers for ProcessWire modules and site profiles.
     *
     * @param Composer $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installationManager = $composer->getInstallationManager();
        $installationManager->addInstaller(new ModuleInstaller($io, $composer));
        $installationManager->addInstaller(new SiteProfileInstaller($io, $composer));
    }

    /**
     * Register pre package install event listener
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PackageEvents::PRE_PACKAGE_INSTALL => [
                array('prePackageInstall', 0)
            ],
            PackageEvents::PRE_PACKAGE_UPDATE => [
                array('prePackageInstall', 0)
            ],
        ];
    }

    /**
     * Pre package install event listener
     *
     * wireframe-framework/processwire-composer-installer and hari/pw-module are not fully compatible,
     * which means that when wireframe-framework/processwire-composer-installer is enabled, we need to
     * disable the hari/pw-module SystemInstaller composer-installer.
     *
     * @param PackageEvent $event
     */
    public static function prePackageInstall(PackageEvent $event)
    {
        $operation = $event->getOperation();
        $package = $operation instanceof UpdateOperation ? $operation->getTargetPackage() : $operation->getPackage();
        if ($package->getType() !== 'pw-module') return;
        $installationManager = $event->getComposer()->getInstallationManager();
        $moduleInstaller = $installationManager->getInstaller('pw-module');
        if (strpos(get_class($moduleInstaller), 'PW\Composer\SystemInstaller') === 0) {
            $installationManager->removeInstaller($moduleInstaller);
        }
    }

   /**
    * Remove any hooks from Composer
    *
    * This will be called when a plugin is deactivated before being uninstalled, but also before it
    * gets upgraded to a new version so the old one can be deactivated and the new one activated.
    *
    * @param Composer $composer
    * @param IOInterface $io
    */
    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

   /**
    * Prepare the plugin to be uninstalled
    *
    * This will be called after deactivate.
    *
    * @param Composer    $composer
    * @param IOInterface $io
    */
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

}
