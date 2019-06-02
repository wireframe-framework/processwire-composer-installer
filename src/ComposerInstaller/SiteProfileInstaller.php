<?php

namespace wireframe\ComposerInstaller;

use Composer\Package\PackageInterface;

/**
 * SiteProfileInstaller class
 *
 * This class implements a custom Composer installer for ProcessWire CMS/CMF
 * site profiles.
 *
 * @author Teppo Koivula <teppo@wireframe-framework.com>
 * @license Mozilla Public License v2.0 http://mozilla.org/MPL/2.0/
 */
class SiteProfileInstaller extends BaseInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return $this->getFullPath($package, '');
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType === 'pw-site-profile';
    }
}
