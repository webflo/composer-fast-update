#!/usr/bin/env php
<?php

require_once '/Users/fweber/bin/composer-cli/vendor/autoload.php';

$args = array_reverse($argv);
$version = array_shift($args);
$package_name = array_shift($args);

print 'Update: ' . $package_name . ' - ' . $version . PHP_EOL;

if (empty($package_name) || empty($version)) {
  return;
}

$filepath = __DIR__ . '/../composer.lock';
$composer_lock = json_decode(file_get_contents($filepath), TRUE);
$write = FALSE;

if (isset($composer_lock['packages'])) {
  foreach ($composer_lock['packages'] as &$package) {
    if ($package['name'] == $package_name) {
      $git_url = $package['source']['url'];
      $output = shell_exec('git ls-remote ' . $git_url . ' ' . $version);
      $hash = substr($output, 0, 40);
      print $hash . PHP_EOL;
      $package['source']['reference'] = $hash;
      $package['time'] = date('Y-m-d H:i:s');
      $write = TRUE;
    }
  }
}

if ($write) {
  file_put_contents($filepath, json_encode($composer_lock, 448 & 128));
  $file = new \Composer\Json\JsonFile($filepath);
  $file->write($composer_lock);
}

