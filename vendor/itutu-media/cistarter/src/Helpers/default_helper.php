<?php

use CodeIgniter\I18n\Time;

if (!function_exists('encryptUrl')) {
  function encryptUrl($string)
  {
    $encrypter = \Config\Services::encrypter();
    $output = strtr(base64_encode($encrypter->encrypt($string)), '+/=', '-_~');
    return $output;
  }
}

if (!function_exists('decryptUrl')) {
  function decryptUrl($string)
  {
    $encrypter = \Config\Services::encrypter();
    $output = $encrypter->decrypt(base64_decode(strtr($string, '-_~', '+/=')));
    return $output;
  }
}

if (!function_exists('setConfig')) {
  function setConfig($id, $data, $update = false)
  {
    $mConfig = new \IM\CI\Models\App\M_configuration();
    if ($update)
      $mConfig->update($id, $data);
    else
      $mConfig->insert($data);
  }
}

if (!function_exists('getConfig')) {
  function getConfig($name = NULL, $array = FALSE)
  {
    $mConfig = new \IM\CI\Models\App\M_configuration();
    if ($name)
      $config = $mConfig->where('name', $name)->first();
    else
      $config = $mConfig->findAll();

    if ($config) {
      if ($array)
        return $config;
      else
        return $config['value'];
    } else {
      return '-';
    }
  }
}

if (!function_exists('cetak')) {
  function cetak($string)
  {
    echo htmlentities($string, ENT_QUOTES, 'UTF-8');
  }
}

if (!function_exists('isMethod')) {
  function isMethod($method = 'post')
  {
    $request = \Config\Services::request();
    if ($request->getMethod() == $method)
      return true;
    return false;
  }
}

if (!function_exists('isAjax')) {
  function isAjax()
  {
    $request = \Config\Services::request();
    if (!$request->isAjax())
      return false;
    return true;
  }
}

if (!function_exists('adminBreadcrumb')) {
  function adminBreadcrumb(array $segments = [])
  {
    $breadcrumb = $uri = '';
    if (count($segments) > 1) {
      $breadcrumb .= '
      <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">';
      foreach ($segments as $title => $url) {
        $uri .= $url . '/';
        if (end($segments) == $url) {
          $title = '<a href="#">' . $title . '</a>';
        } else {
          $title = '<a href="' . site_url($uri) . '" class="text-muted">' . $title . '</a>';
        }
        $breadcrumb .= '
          <li class="breadcrumb-item">
            ' . $title . '
          </li>';
      }
      $breadcrumb .= '</ul>';
    }
    return $breadcrumb;
  }
}

if (!function_exists('toRomawi')) {
  function toRomawi($number)
  {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
      foreach ($map as $roman => $int) {
        if ($number >= $int) {
          $number -= $int;
          $returnValue .= $roman;
          break;
        }
      }
    }
    return $returnValue;
  }
}

if (!function_exists('tanggal')) {
  // H = hour
  // m = minute
  // s = second
  // d = day
  // M = month
  // y = year
  // e = week day
  // O = zone
  function tanggal($timestamp = null, $format = 'HH:mm:ss dd MMMM yyyy')
  {
    if (!is_numeric($timestamp))
      $date = $timestamp;

    if ($timestamp != null && is_numeric($timestamp))
      $date = date('Y-m-d H:i:s', $timestamp);

    $time = Time::parse($date);
    return $time->toLocalizedString($format);
  }
}

if (!function_exists('changeUserDirName')) {
  function changeUserDirName($oldName, $newName)
  {
    $folderPath = ROOTPATH . 'public/uploads/';
    $oldDirName = $folderPath . $oldName;
    $newDirName = $folderPath . $newName;
    if (file_exists($oldDirName) && is_dir($oldDirName))
      rename($oldDirName, $newDirName);
  }
}
