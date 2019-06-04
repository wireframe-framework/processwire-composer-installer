# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
