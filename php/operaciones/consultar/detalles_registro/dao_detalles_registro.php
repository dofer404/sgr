<?php

class dao_detalles_registro
{
  static function get_datossinfiltro($where='')
  {
    if ($where) {
      $where_armado = "WHERE $where";
    } else {
      $where_armado = '';
    }

    $sql = "SELECT r.id_registro, te.nombre ||': '|| e.nombre ||' - '|| wf.nombre tipoevento_y_wf, r.nombre, r.get_usuario, r.fecha_fin
            FROM sgr.registro r
            INNER JOIN sgr.workflow wf on wf.id_workflow = r.id_workflow
            INNER JOIN sgr.evento e ON e.id_evento = wf.id_evento
            INNER JOIN sgr.tipo_evento te ON e.id_tipoevento = te.id_tipoevento
            JOIN sgr.estado_actual_flujo ea ON r.id_registro = ea.id_registro AND ea.activo
            WHERE r.fecha_fin is null
            ORDER BY tipoevento_y_wf ASC
            limit 10";

    $resultado = consultar_fuente($sql);
    return $resultado;
  }

  static function get_datos($where='')
  {
    if ($where) {
      $where_armado = "WHERE $where";
    } else {
      $where_armado = '';
    }

    $sql = "SELECT r.id_registro, te.nombre ||': '|| e.nombre ||' - '|| wf.nombre tipoevento_y_wf, r.nombre, r.get_usuario, to_char(r.fecha_fin::TIMESTAMP, 'DD / MM / YYYY HH24:MI:SS') fecha_fin
            FROM sgr.registro r
            INNER JOIN sgr.workflow wf on wf.id_workflow = r.id_workflow
            INNER JOIN sgr.evento e ON e.id_evento = wf.id_evento
            INNER JOIN sgr.tipo_evento te ON e.id_tipoevento = te.id_tipoevento
            JOIN sgr.estado_actual_flujo ea ON r.id_registro = ea.id_registro AND ea.activo
            $where_armado
            ORDER BY tipoevento_y_wf ASC";

    $resultado = consultar_fuente($sql);
    return $resultado;
  }

  static function cargar_form($seleccion)
  {
    $consulta = $seleccion['id_registro'];
    $sql = "SELECT r.id_registro||': '||w.nombre||' - '||r.nombre registro, s.nombre||' - '||d.nombre sucursal
            FROM sgr.registro r
            JOIN sgr.workflow w ON r.id_workflow = w.id_workflow
            JOIN sgr.dpto d ON w.id_dpto = d.id_dpto
            JOIN sgr.sucursal s ON d.id_sucursal = s.id_sucursal
            WHERE r.id_registro = $consulta";
    $resultado = consultar_fuente($sql);
    return $resultado[0];
  }

  static function cargar_ml($seleccion)
  {
    $consulta = $seleccion['id_registro'];
    $sql = "SELECT id_estado_actual, e.nombre, ea.observacion, coalesce(p.legajo, '0')||': '||p.apellido||', '||p.nombre apynom, to_char(fecha::TIMESTAMP, 'DD/MM/YYYY HH24:MI:SS') fecha
            FROM sgr.estado_actual_flujo ea
            JOIN sgr.estado e ON ea.id_estado = e.id_estado
            JOIN sgr.persona p ON ea.id_persona = p.id_persona
            WHERE id_registro = $consulta
            ORDER BY fecha ASC";
    $resultado = consultar_fuente($sql);
    return $resultado;
  }
}
?>
