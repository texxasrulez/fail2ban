# Roundcube Fail2Ban Plugin

![Downloads](https://img.shields.io/github/downloads/texxasrulez/fail2ban/total?style=plastic&logo=github&logoColor=white&label=Downloads&labelColor=aqua&color=blue)
[![Packagist Downloads](https://img.shields.io/packagist/dt/texxasrulez/fail2ban?style=plastic&logo=packagist&logoColor=white&label=Downloads&labelColor=blue&color=gold)](https://packagist.org/packages/texxasrulez/fail2ban)
[![Packagist Version](https://img.shields.io/packagist/v/texxasrulez/fail2ban?style=plastic&logo=packagist&logoColor=white&label=Version&labelColor=blue&color=limegreen)](https://packagist.org/packages/texxasrulez/fail2ban)
[![Github License](https://img.shields.io/github/license/texxasrulez/fail2ban?style=plastic&logo=github&label=License&labelColor=blue&color=coral)](https://github.com/texxasrulez/fail2ban/LICENSE)
[![GitHub Stars](https://img.shields.io/github/stars/texxasrulez/fail2ban?style=plastic&logo=github&label=Stars&labelColor=blue&color=deepskyblue)](https://github.com/texxasrulez/fail2ban/stargazers)
[![GitHub Issues](https://img.shields.io/github/issues/texxasrulez/fail2ban?style=plastic&logo=github&label=Issues&labelColor=blue&color=aqua)](https://github.com/texxasrulez/fail2ban/issues)
[![GitHub Contributors](https://img.shields.io/github/contributors/texxasrulez/fail2ban?style=plastic&logo=github&logoColor=white&label=Contributors&labelColor=blue&color=orchid)](https://github.com/texxasrulez/fail2ban/graphs/contributors)
[![GitHub Forks](https://img.shields.io/github/forks/texxasrulez/fail2ban?style=plastic&logo=github&logoColor=white&label=Forks&labelColor=blue&color=darkorange)](https://github.com/texxasrulez/fail2ban/forks)
[![Donate Paypal](https://img.shields.io/badge/Paypal-Money_Please!-blue.svg?style=plastic&labelColor=blue&color=forestgreen&logo=paypal)](https://www.paypal.me/texxasrulez)

This plugin writes failed Roundcube login attempts to the `userlogins` log so Fail2Ban can match and block abusive IP addresses.

## Version

Current version: 1.5

## Requirements

- Roundcube 1.3 or newer
- Fail2Ban installed and configured separately

## Installation

1. Place this plugin directory in `roundcube/plugins/fail2ban`.
2. Add `fail2ban` to `$config['plugins']` in your Roundcube config.
3. If Roundcube is behind a reverse proxy, copy `config.inc.php.dist` to `config.inc.php` and set the trusted proxy IPs.

## Reverse Proxy Support

By default the plugin logs `REMOTE_ADDR`. This avoids trusting spoofed forwarding headers from direct clients.

If Roundcube is behind a trusted reverse proxy, configure the proxy IPs and optional header order:

```php
$config['fail2ban_trusted_proxies'] = array('127.0.0.1', '10.0.0.10');
$config['fail2ban_ip_headers'] = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP');
```

Forwarded headers are only used when `REMOTE_ADDR` matches one of the trusted proxies.

## Fail2Ban Example

Example jail:

```ini
[roundcube]
enabled  = true
port     = http,https
filter   = roundcube
action   = iptables-multiport[name=roundcube, port="http,https"]
logpath  = /var/www/html/roundcube/logs/userlogins
```

Example filter:

```ini
[Definition]
failregex = FAILED login for .* from <HOST>
ignoreregex =
```

## Notes

- Logged usernames are sanitized before being written to the log.
- Forwarded IP headers are normalized to a single valid IP before logging.

## License

GPL-3.0
