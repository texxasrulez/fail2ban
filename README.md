# Fail2ban

## Versioning
- `fail2ban` now keeps its canonical version in `fail2ban::PLUGIN_VERSION` inside `fail2ban.php`.
- `fail2ban::info()` exposes the plugin metadata array used for self-identification.
- Development builds should use a `+dev` suffix such as `1.5+dev`.
- Release builds should use a clean tagged version such as `1.5`.

For a release bump:
1. Update `fail2ban::PLUGIN_VERSION` in `fail2ban.php` or run `sh scripts/bump-version.sh 1.5`.
2. Update `CHANGELOG.md`.
3. Create the matching release tag after verification.

