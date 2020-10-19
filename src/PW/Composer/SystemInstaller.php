<?php

namespace PW\Composer;

/**
 * Compatibility layer for the PW\Composer\SystemInstaller class from hari/pw-module
 *
 * wireframe-framework/processwire-composer-installer and hari/pw-module are not fully compatible,
 * which means that when wireframe-framework/processwire-composer-installer is enabled, we need to
 * disable hari/pw-module.
 */
class SystemInstaller extends \wireframe\ComposerInstaller\BaseInstaller {}
