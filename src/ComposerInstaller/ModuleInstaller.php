<?php

namespace wireframe\ComposerInstaller;

use Composer\Package\PackageInterface;

/**
 * ModuleInstaller class
 *
 * This class implements a custom Composer installer for ProcessWire CMS/CMF
 * modules.
 *
 * @author Teppo Koivula <teppo@wireframe-framework.com>
 * @license Mozilla Public License v2.0 http://mozilla.org/MPL/2.0/
 */
class ModuleInstaller extends BaseInstaller
{
    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType === 'pw-module';
    }

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return $this->getFullPath($package, 'site/modules');
    }
}
