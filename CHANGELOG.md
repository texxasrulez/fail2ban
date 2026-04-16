# Changelog

All notable changes to `fail2ban` should be documented in this file.

## [Unreleased]

- Ongoing development builds use `fail2ban::PLUGIN_VERSION` with a `+dev` suffix until the next release is cut.

## [1.0.0] - 2026-04-11

- Formalized the plugin's self-metadata through `fail2ban::PLUGIN_VERSION` and `fail2ban::info()`.
- Aligned self-versioning with a cleaner release workflow while keeping existing plugin behavior intact.
