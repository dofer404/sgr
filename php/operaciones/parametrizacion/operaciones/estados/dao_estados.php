<?php

class dao_estados
{
  static function get_datossinfiltro($where='')
  {
    return self::get_datos('', true); ////20180414
  }

  static function get_datos($where='', $limit=false)
  {
    if ($where) {
      $where_armado = "$where";
    } else {
      $where_armado = 'true';
    }
    $limite=($limit ? 'limit 10':'');
    $sql = "SELECT *
            FROM sgr.estado
            WHERE inicio <> true
            AND ($where_armado)
            ORDER BY nombre ASC
            $limite";
    $resultado = consultar_fuente($sql);
    return $resultado;
  }

  static function existe_db_nombreestado($nombreestado) ////20180414
  {
    $nombreestado = quote($nombreestado);
    $sql = "SELECT COUNT(*) cantidad
            FROM sgr.estado
            WHERE nombre = $nombreestado";
    $resultado = consultar_fuente($sql);
    return $resultado[0]['cantidad']>0;
  }

}
?>
