<?php

class cn_operaciones extends sgr_cn
{

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_tipoevento -----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargartipoevento($form)
  {
    if ($this->dep('dr_tipoevento')->tabla('dt_tipoevento')->hay_cursor()) {
    $datos = $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->get();
    $form->set_datos($datos);
    }
  }

  function guardartipoevento()
  {
    $this->dep('dr_tipoevento')->sincronizar();
    $this->dep('dr_tipoevento')->resetear();
  }

  function resettipoevento()
  {
    $this->dep('dr_tipoevento')->resetear();
  }

  function modiftipoevento($datos)
  {
    $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->set($datos);
  }

  function selecciontipoevento($seleccion)
  {
    if($this->dep('dr_tipoevento')->cargar($seleccion)){
      $id_fila = $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->set_cursor($id_fila);
    }
  }

  function borrartipoevento($seleccion)
  {
    $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->cargar($seleccion);
    $id_fila = $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->set_cursor($id_fila);
    $this->dep('dr_tipoevento')->tabla('dt_tipoevento')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_eventos --------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargareventos($form)
  {
    if ($this->dep('dr_eventos')->tabla('dt_eventos')->hay_cursor()) {
    $datos = $this->dep('dr_eventos')->tabla('dt_eventos')->get();
    $form->set_datos($datos);
    }
  }

  function guardareventos()
  {
    $this->dep('dr_eventos')->sincronizar();
    $this->dep('dr_eventos')->resetear();
  }

  function reseteventos()
  {
    $this->dep('dr_eventos')->resetear();
  }

  function modifeventos($datos)
  {
    $this->dep('dr_eventos')->tabla('dt_eventos')->set($datos);
  }

  function seleccioneventos($seleccion)
  {
    if($this->dep('dr_eventos')->cargar($seleccion)){
      $id_fila = $this->dep('dr_eventos')->tabla('dt_eventos')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_eventos')->tabla('dt_eventos')->set_cursor($id_fila);
    }
  }

  function borrareventos($seleccion)
  {
    $this->dep('dr_eventos')->tabla('dt_eventos')->cargar($seleccion);
    $id_fila = $this->dep('dr_eventos')->tabla('dt_eventos')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_eventos')->tabla('dt_eventos')->set_cursor($id_fila);
    $this->dep('dr_eventos')->tabla('dt_eventos')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_estados --------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarestados($form)
  {
    if ($this->dep('dr_estados')->tabla('dt_estados')->hay_cursor()) {
    $datos = $this->dep('dr_estados')->tabla('dt_estados')->get();
    $form->set_datos($datos);
    }
  }

  function guardarestados()
  {
    $this->dep('dr_estados')->sincronizar();
    $this->dep('dr_estados')->resetear();
  }

  function resetestados()
  {
    $this->dep('dr_estados')->resetear();
  }

  function modifestados($datos)
  {
    $this->dep('dr_estados')->tabla('dt_estados')->set($datos);
  }

  function seleccionestados($seleccion)
  {
    if($this->dep('dr_estados')->cargar($seleccion)){
      $id_fila = $this->dep('dr_estados')->tabla('dt_estados')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_estados')->tabla('dt_estados')->set_cursor($id_fila);
    }
  }

  function borrarestados($seleccion)
  {
    $this->dep('dr_estados')->tabla('dt_estados')->cargar($seleccion);
    $id_fila = $this->dep('dr_estados')->tabla('dt_estados')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_estados')->tabla('dt_estados')->set_cursor($id_fila);
    $this->dep('dr_estados')->tabla('dt_estados')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_flujosevento ---------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargar_dr_flujoseventos($seleccion=null)
    {
        if (!$this->dep('dr_flujoseventos')->esta_cargada()) {
            if (isset($seleccion)) {
                $this->dep('dr_flujoseventos')->cargar($seleccion);
            } else {
                $this->dep('dr_flujoseventos')->cargar($seleccion);
            }
        }
    }

  function borrar_dt_flujoseventos($seleccion)
  {
    if ($this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->esta_cargada()) {
      $id_memoria = $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->get_id_fila_condicion($seleccion);
      $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->eliminar_fila($id_memoria[0]);
    }
  }

  function get_flujoseventos()
  {
    if ($this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->hay_cursor())
    {
      return $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->get();
    }
  }

  function set_cursorflujoseventos($seleccion)
  {
    $id = $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->get_id_fila_condicion($seleccion);
    $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->set_cursor($id[0]);
  }

  function guardar_dr_flujoseventos()
  {
    $this->dep('dr_flujoseventos')->sincronizar();
    //--$this->dep('dr_flujoseventos')->resetear();
  }

  function resetear_dr_flujoseventos()
  {
    $this->dep('dr_flujoseventos')->resetear();
  }

  function set_dt_flujoseventos($datos)
  {
    $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->set($datos);
  }

  function seleccionflujoseventos($seleccion)
  {
    if($this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->cargar($seleccion)){
      $id_fila = $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_flujoseventos')->tabla('dt_flujoseventos')->set_cursor($id_fila);
    }
  }

  //-----------------------------------------------------------------------------------
  //---- ABM form_ml_flujos-----------------------------------------------
  //-----------------------------------------------------------------------------------

  function getflujos()
  {
    return $this->ordenarxorden($this->dep('dr_flujoseventos')->tabla('dt_flujos')->get_filas());
  }

  function ordenarxorden(array $array) {
      $array_size = count($array);
      for($i = 0; $i < $array_size; $i ++) {
          for($j = 0; $j < $array_size; $j ++) {
              if ($array[$i]['orden'] < $array[$j]['orden']) {
                  $tem = $array[$i];
                  $array[$i] = $array[$j];
                  $array[$j] = $tem;
              }
          }
      }
      return $array;
  }

  function procesarflujos($datos)
  {
    $this->dep('dr_flujoseventos')->tabla('dt_flujos')->procesar_filas($datos);
  }


  //-----------------------------------------------------------------------------------
  //---- ABM sgr_requisitos -----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarrequisitos($form)
  {
    if ($this->dep('dr_requisitos')->tabla('dt_requisitos')->hay_cursor()) {
    $datos = $this->dep('dr_requisitos')->tabla('dt_requisitos')->get();
    $form->set_datos($datos);
    }
  }

  function guardarrequisitos()
  {
    $this->dep('dr_requisitos')->sincronizar();
    $this->dep('dr_requisitos')->resetear();
  }

  function resetrequisitos()
  {
    $this->dep('dr_requisitos')->resetear();
  }

  function modifrequisitos($datos)
  {
    $this->dep('dr_requisitos')->tabla('dt_requisitos')->set($datos);
  }

  function seleccionrequisitos($seleccion)
  {
    if($this->dep('dr_requisitos')->cargar($seleccion)){
      $id_fila = $this->dep('dr_requisitos')->tabla('dt_requisitos')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_requisitos')->tabla('dt_requisitos')->set_cursor($id_fila);
    }
  }

  function borrarrequisitos($seleccion)
  {
    $this->dep('dr_requisitos')->tabla('dt_requisitos')->cargar($seleccion);
    $id_fila = $this->dep('dr_requisitos')->tabla('dt_requisitos')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_requisitos')->tabla('dt_requisitos')->set_cursor($id_fila);
    $this->dep('dr_requisitos')->tabla('dt_requisitos')->eliminar_fila($id_fila);
  }



}

?>
