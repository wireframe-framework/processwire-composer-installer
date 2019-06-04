<?php

namespace wireframe\ComposerInstaller;

use Composer\Repository\InstalledRepositoryInterface;
use Composer\Package\PackageInterface;
use Composer\Util\Filesystem;

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
     * @var string Base path for site profiles
     */
    const BASE_PATH = '';

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $packageType === 'pw-site-profile';
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        // check if there's a nested site- prefixed directory, in which case we
        // must assume that it's the real site profile directory and move it up
        // one level
        $path = $this->getInstallPath($package);
        $site = $this->getNestedSiteDirectoryName($path);
        if ($site) {
            $filesystem = new Filesystem();
            $filesystem->rename($path, 'temp-' . $path);
            $filesystem->rename('temp-' . $path . $site, $this->getBasePath(static::BASE_PATH) . $site);
            $filesystem->remove('temp-' . $path);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return $this->getFullPath($package, static::BASE_PATH);
    }

    /**
     * Get nested site directory path, or null if none found
     *
     * @param string $path
     * @return string|null
     */
    public function getNestedSiteDirectoryName($path) {
        $site = null;
        $files = new \DirectoryIterator($path);
        foreach ($files as $file) {
            if ($file->isDot() || !$file->isDir()) continue;
            $filename = $file->getFilename();
            if (strpos($filename, 'site-') === 0) {
                $site = $filename;
                break;
            }
        }
        return $site;
    }
}
