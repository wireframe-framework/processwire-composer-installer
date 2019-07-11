# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.2] - 2019-07-11

### Added
- Added instructions to README for customizing the default installer paths for modules and site profiles.

## [1.0.1] - 2019-06-30

### Added
- Added hari/pw-module as a dependency to force Composer to install it before this package.

## [1.0.0] - 2019-06-29

### Added
- More in-depth introduction and instructions for developers and module / site profile authors to README.

## [0.1.0] - 2019-06-22

### Changed
- Identify current directory as a site directory if it appears to be site profile directory waiting to be installed.

## [0.0.5] - 2019-06-16

### Changed
- Convert installed module directories automatically to Pascal Case.
- Modify base path when installing from the site directory to avoid nested site/site/ directories.

## [0.0.4] - 2019-06-10

### Fixed
- Fix an issue where 'site-' prefix was unnecessarily added to module directories.

## [0.0.3] - 2019-06-07

### Added
- Class constant BASE_PATH for ModuleInstaller and SiteProfileInstaller.
- If the site directory doesn't have 'site-' prefix, add it automatically.
- Detect if the site directory is nested within repository and move it to root.

## [0.0.2] - 2019-06-03

### Fixed
- Fix an issue where a typo in ModuleInstaller prevented it from working properly.
- Fix an issue with missing basePath being treated as an absolute path.

## [0.0.1] - 2019-06-03

### Added
- Added required classes (Plugin, BaseInstaller, ModuleInstaller, SiteProfileInstaller).
- Added markdown files to describe the project (LICENSE, README.md, CHANGELOG.md.)
- Added the composer.json file.
