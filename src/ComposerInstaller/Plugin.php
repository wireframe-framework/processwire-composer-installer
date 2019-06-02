<?php

namespace wireframe\ComposerInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * The Plugin class
 *
 * This class registers our custom installers.
 *
 * @author Teppo Koivula <teppo@wireframe-framework.com>
 * @license Mozilla Public License v2.0 http://mozilla.org/MPL/2.0/
 */
class Plugin implements PluginInterface
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
}
