<?php
class Padronizacao{
  public static function converterMainMin($v):string{
    return ucwords(strtolower($v));
  }
  public static function antiXSS($v):string{
   return htmlspecialchars($v);
 }
}
