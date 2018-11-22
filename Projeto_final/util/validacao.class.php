<?php

class Validacao{
  public static function validarNomes($v){
      $exp = "/^[a-zA-ZÁ-ú ]{2,30}$/";
      return preg_match($exp,$v);
  }
  public static function validarIdade($v){
    $exp="/^[0-9]{1,3}$/";
    return preg_match($exp,$v);
  }
  public static function validarNumeros($v){
    $exp="/^\d*[0-9](\.\d*[0-9])?$/";
    return preg_match($exp,$v);
  }
  public static function validarCnpj($v){
    $exp="/^[0-9]{14}|[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9]{4}-[0-9]{2}$/";
    return preg_match($exp,$v);
  }
  public static function validarEndereco($v){
    $exp="/^[A-z0-9À-ú ]{2,30}$/";
    return preg_match($exp,$v);
  }
  public static function validarTelefone($v){
    $exp="/^[0-9 ]{2,3}[0-9]{4,5}[-?][0-9]{4}$/";
    return preg_match($exp,$v);
  }
  public static function validarCpf($v){
    $exp="/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/";
    return preg_match($exp,$v);
  }
}
