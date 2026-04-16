<?php
/**
 * RoundCube Fail2Ban Plugin
 *
 * @version 1.5
 * @author Matt Rude [m@mattrude.com]
 * @url https://github.com/texxasrulez/fail2ban
 * @license GPLv3
 */
class fail2ban extends rcube_plugin
{
    const PLUGIN_VERSION = '1.0.0';
    const PLUGIN_INFO = array(
        'name' => 'fail2ban',
        'vendor' => 'Gene Hawkins [texxasrulez@yahoo.com]',
        'version' => self::PLUGIN_VERSION,
        'license' => 'GPL-3.0',
        'uri' => 'https://github.com/texxasrulez/fail2ban',
    );

    public static function info(): array
    {
        return self::PLUGIN_INFO;
    }

  function init()
  {
    $this->load_config();
    $this->add_hook('login_failed', array($this, 'log'));
  }

  function log($args)
  {
    $remote_addr = $this->get_remote_addr();
    $username = $this->sanitize_log_value($args['user']);

    rcmail::write_log('userlogins', 'FAILED login for ' . $username . ' from ' . $remote_addr);
  }

  private function get_remote_addr()
  {
    $remote_addr = isset($_SERVER['REMOTE_ADDR']) ? trim($_SERVER['REMOTE_ADDR']) : '';
    $config = rcmail::get_instance()->config;
    $trusted_proxies = (array) $config->get('fail2ban_trusted_proxies', array());
    $ip_headers = (array) $config->get('fail2ban_ip_headers', array('HTTP_X_FORWARDED_FOR'));

    if ($this->is_valid_ip($remote_addr)) {
      if (!in_array($remote_addr, $trusted_proxies, true)) {
        return $remote_addr;
      }
    } else {
      $remote_addr = '';
    }

    foreach ($ip_headers as $header) {
      if (empty($_SERVER[$header])) {
        continue;
      }

      foreach (explode(',', $_SERVER[$header]) as $forwarded_ip) {
        $forwarded_ip = trim($forwarded_ip);

        if ($this->is_valid_ip($forwarded_ip)) {
          return $forwarded_ip;
        }
      }
    }

    return $remote_addr !== '' ? $remote_addr : 'unknown';
  }

  private function is_valid_ip($ip)
  {
    return filter_var($ip, FILTER_VALIDATE_IP) !== false;
  }

  private function sanitize_log_value($value)
  {
    $value = preg_replace('/[[:cntrl:]]+/', ' ', (string) $value);
    $value = trim(preg_replace('/\s+/', ' ', $value));

    return $value !== '' ? $value : 'unknown';
  }
}
