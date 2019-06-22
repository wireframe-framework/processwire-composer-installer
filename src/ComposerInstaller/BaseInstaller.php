<?php

namespace wireframe\ComposerInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

/**
 * BaseInstaller class
 *
 * This is a base class for ProcessWire CMS/CMF module and site profile
 * installers.
 *
 * @author Teppo Koivula <teppo@wireframe-framework.com>
 * @license Mozilla Public License v2.0 http://mozilla.org/MPL/2.0/
 */
class BaseInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return parent::getInstallPath($package);
    }
    
    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return parent::supports($packageType);
    }

    /**
     * Get the base path for current installer
     *
     * Default base path is provided as an argument. This can be overridden by
     * specifying pw-[type]-path extra argument in composer.json, where "type"
     * is either "module" or "site-profile".
     *
     * @param string $defaultBasePath Default base path.
     * @return string Base path.
     */
    protected function getBasePath($defaultBasePath) {
        // if we're already in the site directory, remove "site/" from the beginning
        // of the default base path to avoid creating nested /site/site/ directories
        if (substr($defaultBasePath, 0, 5) === 'site/' && preg_match('/^site(?:-[a-z0-9]+)*$/', basename(getcwd()))) {
            $defaultBasePath = substr($defaultBasePath, 5);
        }

        // get the extra configuration of the top-level package
        $extra = [];
        if ($rootPackage = $this->composer->getPackage()) {
            $extra = $rootPackage->getExtra();
        }

        // use base path from configuration, otherwise fall back to default
        $class = basename(str_replace('\\', '/', static::class));
        $type = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', substr($class, 0, strrpos($class, 'Installer'))));
        $basePath = $extra['pw-' . $type . '-path'] ?? $defaultBasePath;

        // if base path is set, make sure that it has a trailing slash
        $basePath = trim($basePath, '/');
        if (strlen($basePath)) {
            $basePath .= '/';
        }

        return $basePath;
    }

    /**
     * Get the directory name from package name
     *
     * Default directory name can be overridden by specifying extra argument
     * "installer-name" in the composer.json of the package in question.
     *
     * @param PackageInterface $package
     * @return string Module or site profile directory name.
     */
    protected function getName(PackageInterface $package) {
        // determine the directory name from its package name
        $name = explode('/', $package->getPrettyName())[1];
        
        // allow overriding module directory name via composer.json
        $extra = $package->getExtra();
        if (!empty($extra['installer-name'])) {
            $name = $extra['installer-name'];
        }

        return $name;
    }

    /**
     * Get the full path with base part and package directory name
     *
     * @param PackageInterface $package
     * @param string $defaultBasePath Default base path.
     * @return string Path.
     */
    protected function getFullPath(PackageInterface $package, $defaultBasePath) {
        $basePath = $this->getBasePath($defaultBasePath);
        $name = $this->getName($package);
        return $basePath . $name;
    }
}
