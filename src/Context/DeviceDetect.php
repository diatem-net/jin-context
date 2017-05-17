<?php

/**
 * Jin Framework
 * Diatem
 */

namespace Jin2\Context;

use Detection\MobileDetect;

/**
 * Classe permettant la détection de la plate-forme
 */
class DeviceDetect
{

  /**
   * Objet stockant les données de la plate-forme détectée
   *
   * @var object
   */
  static protected $detectCode;

  /**
   * Retourne si la plate-forme est une tablette
   *
   * @return boolean  true si la plate-forme est une tablette
   */
  public static function isTablet()
  {
    if (is_null(self::$detectCode)) {
      static::detectDevice();
    }
    return self::$detectCode['tablet'];
  }

  /**
   * Retourne si la plate-forme est un mobile
   *
   * @return boolean  true si la plate-forme est un mobile
   */
  public static function isMobile()
  {
    if (is_null(self::$detectCode)) {
      static::detectDevice();
    }
    return self::$detectCode['mobile'];
  }

  /**
   * Retourne si la plate-forme est un ordinateur de bureau
   *
   * @return boolean  true si la plate-forme est un ordinateur de bureau
   */
  public static function isDesktop()
  {
    if (is_null(self::$detectCode)) {
      static::detectDevice();
    }
    return self::$detectCode['desktop'];
  }

  /**
   * Retourne une chaîne d'identification de la plate forme utilisée
   *
   * @return string  Chaîne d'identification
   */
  public static function getDevice()
  {
    if (is_null(self::$detectCode)) {
      static::detectDevice();
    }
    return self::$detectCode['device'];
  }

  /**
   * Permet l'identification de la plate-forme
   */
  protected static function detectDevice()
  {
    $detect = new MobileDetect();
    self::$detectCode = array();
    self::$detectCode['tablet'] = $detect->isTablet();
    self::$detectCode['mobile'] = $detect->isMobile() && !$detect->isTablet();
    self::$detectCode['desktop'] = !self::$detectCode['tablet'] && !self::$detectCode['mobile'];
    self::$detectCode['device'] = 'desktop';
    foreach ($detect->getRules() as $name => $regex) {
      if ($detect->{'is' . $name}()) {
        self::$detectCode['device'] = $name;
        break;
      }
    }
  }

}
