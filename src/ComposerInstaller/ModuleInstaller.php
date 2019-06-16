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
     * @var string Base path for modules
     */
    const BASE_PATH = 'site/modules';

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
        return $this->getFullPath($package, static::BASE_PATH);
    }

    /**
     * Get the directory name from package name
     *
     * Default directory name can be overridden by specifying extra argument
     * "installer-name" in the composer.json of the package in question.
     *
     * @param PackageInterface $package
     * @return string Module directory name.
     */
    protected function getName(PackageInterface $package) {
        // fetch initial directory name
        $name = parent::getName($package);

        // make sure that the directory name is in Pascal Case
        $name = $this->pascalCase($name);

        return $name;
    }

    /**
     * Convert string to Pascal Case
     *
     * Typically used for ProcessWire module directory names, which are loosely
     * expected to follow a PascalCase type naming convention.
     *
     * @param string $string
     * @return string String in PascalCase
     */
    protected function pascalCase($string) {
        $replace_chars = [
            '_',
            '-',
            '/',
            ' '
        ];
        return str_replace($replace_chars, '', ucwords($string, implode($replace_chars)));
    }
}
