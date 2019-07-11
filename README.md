# ProcessWire Composer Installer

This project contains [Composer custom installers](https://getcomposer.org/doc/articles/custom-installers.md) for ProcessWire CMS/CMF modules and site profiles.

## What does it do and why do we need it?

By default Composer installs all packages into the /vendor/ directory. This is great for things that support this type of structure, but not so great for projects – such as ProcessWire – that expect things to be in specific location: modules in /site/modules/module-name/, and site profiles generally as the /site/ directory itself, /site-profile-name/ when the system hasn't been installed yet, or before installat/site-subsite-name/ in the case of native multisite support.

ProcessWire Composer Installer currently makes two "corrections" to packages that define it as a dependency in their composer.json files:

- **modules** are installed under `./site/modules/ModuleName/` (module name is read from composer.json and converted to PascalCase)
- **site profiles** are installed under `./site-profile-name/` (site profile name is read from composer.json and the site- prefix is added automatically if needed)

## Site-specific modules supports

One more thing to note is that modules can be installed either from the root directory of the ProcessWire installation, or from the `/site/` directory itself. Installer will automatically determine which location you're currently in, and adjust paths accordingly.

This way we can install modules on a per-site basis (in the case of multisite), or include Composer based module dependencies with a site profile (which would otherwise require manual modifications to the ProcessWire root directory composer.json file, or at least running `composer require` in the root directory for said dependencies.)

## Alternatively...

There's a very similar project you might've heard of, called `hari/pw-module`. While this project and Hari's ProcessWire module installer are similar, there are a few key differences:

- This project allows you to install both modules *and* site profiles
- This project allows you to install modules from the /site/ directory
- This project provides some additional features (and composer.json options) in terms of module and site profile naming, and also includes additional rules for auto-formatting module and site profile directory names

## Usage

### For developers installing modules or site profiles

- To add a new module from Packagist, run `composer require vendor-name/module-name` in either ProcessWire root directory, or your /site/ directory.
- To add a new site profile from Packagist, run `composer require vendor-name/site-profile-name` in the ProcessWire root directory.

*Note that in order for this work, the module or site profile in question has to have `wireframe-framework/processwire-composer-installer` as a dependency. See next section for instructions for module or site profile authors.*

#### Customizing installer paths

By default site profiles are installed under current working directory, and modules under site/modules/ (or modules/ in case you're already in a site directory). You can, though, override the default paths in the root composer.json of your project:

```
{
  "require": {
    ...
  },
  "extra": {
    "pw-module-path": "site/modules",
    "pw-site-profile-path": "",
  }
}
```

### For module or site profile authors

The usage of this project is rather simple. You just need to a) add `wireframe-framework/processwire-composer-installer` as a dependency to your project by manually modifying the composer.json file or by running `composer require wireframe-framework/processwire-composer-installer` in your module or site profile root directory, and b) define the type of your package (via composer.json) as `pw-module` (for modules) or `pw-site-profile` (for site profiles).

Here's a stripped-down sample composer.json for a module:

```
{
    "name": "vendor-name/module-name",
    "type": "pw-module",
    "require": {
        "wireframe-framework/processwire-composer-installer": "^1.0.0"
    }
}
```

And here's an equally stripped-down sample composer.json for a site profile:

```
{
    "name": "vendor-name/site-profile-name",
    "type": "pw-site-profile",
    "require": {
        "wireframe-framework/processwire-composer-installer": "^1.0.0"
    }
}
```

*In order for your modules to be easily installed, you should also add them to Packagist: https://packagist.org/.*

## Requirements

- PHP 5.5 or newer

### Why does this project require other installers via composer.json?

In case you're wondering why we currently have hari/pw-module as a requirement for this package,
there's actually a good reason for this, even though it is admittedly a bit of a hack:

* Composer doesn't let us define package install order, but it prioritizes Composer installers.
* If multiple installers compete for one package, the installer installed or loaded later wins.

By adding other installers (currently only hari/pw-module) as a dependency for this project we're
actually effectively forcing Composer to install it *before* this project, which in turn allows us
to override other installers when it comes to choosing an installer for pw-* packages.

## License

This project is licensed under the Mozilla Public License Version 2.0.