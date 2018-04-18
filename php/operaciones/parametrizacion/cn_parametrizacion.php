<?php

require_once('operaciones/ayuda/acerca/dao_acerca.php');

class cn_parametrizacion extends sgr_cn
{
  //-----------------------------------------------------------------------------------
  //---- Acerca_de --------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargar_acercade($form)
  {
    $datos['nombre'] = '<body><p align="center"><strong><big>'.dao_acerca::consulta_texto()['nombre'].'</big></strong></p></body>';
    $datos['version'] = '<p align="center">Versi�n '.dao_acerca::consulta_texto()['version'].'</p>';
    $datos['desarrollador'] = '<p align="center">Desarrollado por '.dao_acerca::consulta_texto()['desarrollador'].'</p>';

    $fp_imagen1 = dao_acerca::consulta_logo();

    if (isset($fp_imagen1)) {
      $temp_nombre1 = 'logo_mediano';
      $temp_archivo1 = toba::proyecto()->get_www_temp($temp_nombre1);
      $temp_imagen1 = fopen($temp_archivo1['path'], 'w');
      stream_copy_to_stream($fp_imagen1, $temp_imagen1);
      fclose($temp_imagen1);
      $tamanio_imagen1 = round(filesize($temp_archivo1['path']) / 1024);
      $datos['logo'] = "<center><img src = '{$temp_archivo1['url']}' alt=\"Imagen\" WIDTH=150 HEIGHT=150 ></center>";
    }
    $form->set_datos($datos);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_desarrollador ----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargardesarrollador($form)
  {
    if ($this->dep('dr_desarrollador')->tabla('dt_sgr')->hay_cursor()) {
    $datos = $this->dep('dr_desarrollador')->tabla('dt_sgr')->get();

    $fp_imagen1 = $this->dep('dr_desarrollador')->tabla('dt_sgr')->get_blob('logo_grande');
    $fp_imagen2 = $this->dep('dr_desarrollador')->tabla('dt_sgr')->get_blob('logo_chico');

    if (isset($fp_imagen1)) {
      $temp_nombre1 = 'logo_grande' . $datos['id_sgr'];
      $temp_archivo1 = toba::proyecto()->get_www_temp($temp_nombre1);
      $temp_imagen1 = fopen($temp_archivo1['path'], 'w');
      stream_copy_to_stream($fp_imagen1, $temp_imagen1);
      fclose($temp_imagen1);
      $tamanio_imagen1 = round(filesize($temp_archivo1['path']) / 1024);
      $datos['prevgrande'] = "<img src = '{$temp_archivo1['url']}' alt=\"Imagen\" WIDTH=200 HEIGHT=150 >";
      $datos['logo_grande'] = 'Tamaño foto actual: '.$tamanio_imagen1.' KB';
    } else {
      $datos['logo_grande'] = null;
    }

    if (isset($fp_imagen2)) {
      $temp_nombre2 = 'logo_chico' . $datos['id_sgr'];
      $temp_archivo2 = toba::proyecto()->get_www_temp($temp_nombre2);
      $temp_imagen2 = fopen($temp_archivo2['path'], 'w');
      stream_copy_to_stream($fp_imagen2, $temp_imagen2);
      fclose($temp_imagen2);
      $tamanio_imagen2 = round(filesize($temp_archivo2['path']) / 1024);
      $datos['prevchica'] = "<img src = '{$temp_archivo2['url']}' alt=\"Imagen\" WIDTH=120 HEIGHT=100 >";
      $datos['logo_chico'] = 'Tamaño foto actual: '.$tamanio_imagen2.' KB';
    } else {
      $datos['logo_chico'] = null;
    }
    $form->set_datos($datos);
    }
  }

  function guardardesarrollador()
  {
    $this->dep('dr_desarrollador')->sincronizar();
    $this->dep('dr_desarrollador')->resetear();
  }

  function resetdesarrollador()
  {
    $this->dep('dr_desarrollador')->resetear();
  }

  function modifdesarrollador($datos)
  {
    $this->dep('dr_desarrollador')->tabla('dt_sgr')->set($datos);
    if (is_array($datos['logo_grande'])) {
      $temp_archivo1 = $datos['logo_grande']['tmp_name'];
      $fp = fopen($temp_archivo1, 'rb');
      $this->dep('dr_desarrollador')->tabla('dt_sgr')->set_blob('logo_grande', $fp);
    }
    if (is_array($datos['logo_chico'])) {
      $temp_archivo2 = $datos['logo_chico']['tmp_name'];
      $fp = fopen($temp_archivo2, 'rb');
      $this->dep('dr_desarrollador')->tabla('dt_sgr')->set_blob('logo_chico', $fp);
    }
  }

  function selecciondesarrollador($seleccion)
  {
    if($this->dep('dr_desarrollador')->cargar($seleccion)){
      $id_fila = $this->dep('dr_desarrollador')->tabla('dt_sgr')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_desarrollador')->tabla('dt_sgr')->set_cursor($id_fila);
    }
  }

  function borrardesarrollador($seleccion)
  {
    $this->dep('dr_desarrollador')->tabla('dt_sgr')->cargar($seleccion);
    $id_fila = $this->dep('dr_desarrollador')->tabla('dt_sgr')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_desarrollador')->tabla('dt_sgr')->set_cursor($id_fila);
    $this->dep('dr_desarrollador')->tabla('dt_sgr')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_propietario ----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function get_servicios()
  {
    return $datos;
  }

  function cargarpropietario($form)
  {
    if ($this->dep('dr_propietario')->tabla('dt_propietario')->hay_cursor()) {
    $datos = $this->dep('dr_propietario')->tabla('dt_propietario')->get();

    $fp_imagen1 = $this->dep('dr_propietario')->tabla('dt_propietario')->get_blob('logo_grande');
    $fp_imagen2 = $this->dep('dr_propietario')->tabla('dt_propietario')->get_blob('logo_chico');

    if (isset($fp_imagen1)) {
      $temp_nombre1 = 'logo_grande' . $datos['id_propietario'];
      $temp_archivo1 = toba::proyecto()->get_www_temp($temp_nombre1);
      $temp_imagen1 = fopen($temp_archivo1['path'], 'w');
      stream_copy_to_stream($fp_imagen1, $temp_imagen1);
      fclose($temp_imagen1);
      $tamanio_imagen1 = round(filesize($temp_archivo1['path']) / 1024);
      $datos['prevgrande'] = "<img src = '{$temp_archivo1['url']}' alt=\"Imagen\" WIDTH=400 HEIGHT=150 >";
      $datos['logo_grande'] = 'Tama�o foto actual: '.$tamanio_imagen1.' KB';
    } else {
      $datos['logo_grande'] = null;
    }

    if (isset($fp_imagen2)) {
      $temp_nombre2 = 'logo_chico' . $datos['id_propietario'];
      $temp_archivo2 = toba::proyecto()->get_www_temp($temp_nombre2);
      $temp_imagen2 = fopen($temp_archivo2['path'], 'w');
      stream_copy_to_stream($fp_imagen2, $temp_imagen2);
      fclose($temp_imagen2);
      $tamanio_imagen2 = round(filesize($temp_archivo2['path']) / 1024);
      $datos['prevchica'] = "<img src = '{$temp_archivo2['url']}' alt=\"Imagen\" WIDTH=180 HEIGHT=150 >";
      $datos['logo_chico'] = 'Tama�o foto actual: '.$tamanio_imagen2.' KB';
    } else {
      $datos['logo_chico'] = null;
    }
    $form->set_datos($datos);
    }
  }

  function guardarpropietario()
  {
    $this->dep('dr_propietario')->sincronizar();
    $this->dep('dr_propietario')->resetear();
  }

  function resetpropietario()
  {
    $this->dep('dr_propietario')->resetear();
  }

  function modifpropietario($datos)
  {
    $this->dep('dr_propietario')->tabla('dt_propietario')->set($datos);
    if (is_array($datos['logo_grande'])) {
      $temp_archivo1 = $datos['logo_grande']['tmp_name'];
      $fp = fopen($temp_archivo1, 'rb');
      $this->dep('dr_propietario')->tabla('dt_propietario')->set_blob('logo_grande', $fp);
    }
    if (is_array($datos['logo_chico'])) {
      $temp_archivo2 = $datos['logo_chico']['tmp_name'];
      $fp = fopen($temp_archivo2, 'rb');
      $this->dep('dr_propietario')->tabla('dt_propietario')->set_blob('logo_chico', $fp);
    }
    /*Copia del logo para los reportes pdf generados desde toba*/
    if (isset($datos['logo_grande']))
    {
      $extension = pathinfo($datos['logo_grande']['name'], PATHINFO_EXTENSION);
      if (in_array($extension, ['exe','pdf','doc','xls','bin','iso'])) {
          throw new toba_error_usuario('Error: Intent� cargar un archivo de extensi�n "'.$extension.'". Seleccione un archivo con formato de imagen (jpg,bmp,tif).');
      }
      $arc_logopdforig = toba::proyecto()->get_www_temp('../img/logo_pdf.jpg')['path'];
      // Stream hacia el archivo temporal
      $stream_logopdforig = fopen($arc_logopdforig, 'w');
      // Stream desde archivo subido
      $stream_archivosubido = fopen(/*Archivo subido*/$datos['logo_grande']['tmp_name'], 'rb');
      stream_copy_to_stream($stream_archivosubido, $stream_logopdforig);
      fclose($stream_logopdforig);
      fclose($stream_archivosubido);
      $this->convertImage($arc_logopdforig, $arc_logopdforig, 90, $extension);
      //$tamanio = round(filesize($arc_logopdforig['path']) / 1024);
    }
  }

  function convertImage($originalImage, $outputImage, $quality, $ext)
  {
    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        return 0;

    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
  }

  function seleccionpropietario($seleccion)
  {
    if($this->dep('dr_propietario')->cargar($seleccion)){
      $id_fila = $this->dep('dr_propietario')->tabla('dt_propietario')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_propietario')->tabla('dt_propietario')->set_cursor($id_fila);
    }
  }

  function borrarpropietario($seleccion)
  {
    $this->dep('dr_propietario')->tabla('dt_propietario')->cargar($seleccion);
    $id_fila = $this->dep('dr_propietario')->tabla('dt_propietario')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_propietario')->tabla('dt_propietario')->set_cursor($id_fila);
    $this->dep('dr_propietario')->tabla('dt_propietario')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_companiastelefonicas -------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarcompania($form)
  {
    if ($this->dep('dr_companias_telefonicas')->tabla('dt_compania')->hay_cursor()) {
    $datos = $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->get();
    $form->set_datos($datos);
    }
  }

  function guardarcompania()
  {
    $this->dep('dr_companias_telefonicas')->sincronizar();
    $this->dep('dr_companias_telefonicas')->resetear();
  }

  function resetcompania()
  {
    $this->dep('dr_companias_telefonicas')->resetear();
  }

  function modifcompania($datos)
  {
    $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->set($datos);
  }

  function seleccioncompania($seleccion)
  {
    if($this->dep('dr_companias_telefonicas')->tabla('dt_compania')->cargar($seleccion)){
      $id_fila = $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->set_cursor($id_fila);
    }
  }

  function borrarcompania($seleccion)
  {
    $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->cargar($seleccion);
    $id_fila = $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->set_cursor($id_fila);
    $this->dep('dr_companias_telefonicas')->tabla('dt_compania')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_tipocorreo -----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargartipocorreo($form)
  {
    if ($this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->hay_cursor()) {
      $datos = $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->get();
      $form->set_datos($datos);
    }
  }

  function guardartipocorreo()
  {
    $this->dep('dr_tipos_de_correo')->sincronizar();
    $this->dep('dr_tipos_de_correo')->resetear();
  }

  function resettipocorreo()
  {
    $this->dep('dr_tipos_de_correo')->resetear();
  }

  function modiftipocorreo($datos)
  {
    $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->set($datos);
  }

  function selecciontipocorreo($seleccion)
  {
    if($this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->cargar($seleccion)){
      $id_fila = $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->set_cursor($id_fila);
    }
  }

  function borrartipocorreo($seleccion)
  {
    $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->cargar($seleccion);
    $id_fila = $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->set_cursor($id_fila);
    $this->dep('dr_tipos_de_correo')->tabla('dt_tipocorreo')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_tipotel -----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargartipotel($form)
  {
    if ($this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->hay_cursor()) {
      $datos = $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->get();
      $form->set_datos($datos);
    }
  }

  function guardartipotel()
  {
    $this->dep('dr_tipos_de_telefono')->sincronizar();
    $this->dep('dr_tipos_de_telefono')->resetear();
  }

  function resettipotel()
  {
    $this->dep('dr_tipos_de_telefono')->resetear();
  }

  function modiftipotel($datos)
  {
    $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->set($datos);
  }

  function selecciontipotel($seleccion)
  {
    if($this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->cargar($seleccion)){
      $id_fila = $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->set_cursor($id_fila);
    }
  }

  function borrartipotel($seleccion)
  {
    $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->cargar($seleccion);
    $id_fila = $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->set_cursor($id_fila);
    $this->dep('dr_tipos_de_telefono')->tabla('dt_tipotel')->eliminar_fila($id_fila);
  }


  //-----------------------------------------------------------------------------------
  //---- ABM sgr_estadocivil -----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarestadocivil($form)
  {
    if ($this->dep('dr_estado_civil')->tabla('dt_estadocivil')->hay_cursor()) {
      $datos = $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->get();
      $form->set_datos($datos);
    }
  }

  function guardarestadocivil()
  {
    $this->dep('dr_estado_civil')->sincronizar();
    $this->dep('dr_estado_civil')->resetear();
  }

  function resetestadocivil()
  {
    $this->dep('dr_estado_civil')->resetear();
  }

  function modifestadocivil($datos)
  {
    $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->set($datos);
  }

  function seleccionestadocivil($seleccion)
  {
    if($this->dep('dr_estado_civil')->tabla('dt_estadocivil')->cargar($seleccion)){
      $id_fila = $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->set_cursor($id_fila);
    }
  }

  function borrarestadocivil($seleccion)
  {
    $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->cargar($seleccion);
    $id_fila = $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->set_cursor($id_fila);
    $this->dep('dr_estado_civil')->tabla('dt_estadocivil')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_nacionalidad----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarnacionalidad($form)
  {
    if ($this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->hay_cursor()) {
      $datos = $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->get();
      $form->set_datos($datos);
    }
  }

  function guardarnacionalidad()
  {
    $this->dep('dr_nacionalidad')->sincronizar();
    $this->dep('dr_nacionalidad')->resetear();
  }

  function resetnacionalidad()
  {
    $this->dep('dr_nacionalidad')->resetear();
  }

  function modifnacionalidad($datos)
  {
    $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->set($datos);
  }

  function seleccionnacionalidad($seleccion)
  {
    if($this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->cargar($seleccion)){
      $id_fila = $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->set_cursor($id_fila);
    }
  }

  function borrarnacionalidad($seleccion)
  {
    $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->cargar($seleccion);
    $id_fila = $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->set_cursor($id_fila);
    $this->dep('dr_nacionalidad')->tabla('dt_nacionalidad')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_pais------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarpais($form)
  {
    if ($this->dep('dr_pais')->tabla('dt_pais')->hay_cursor()) {
      $datos = $this->dep('dr_pais')->tabla('dt_pais')->get();
      $form->set_datos($datos);
    }
  }

  function guardarpais()
  {
    $this->dep('dr_pais')->sincronizar();
    $this->dep('dr_pais')->resetear();
  }

  function resetpais()
  {
    $this->dep('dr_pais')->resetear();
  }

  function modifpais($datos)
  {
    $this->dep('dr_pais')->tabla('dt_pais')->set($datos);
  }

  function seleccionpais($seleccion)
  {
    if($this->dep('dr_pais')->tabla('dt_pais')->cargar($seleccion)){
      $id_fila = $this->dep('dr_pais')->tabla('dt_pais')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_pais')->tabla('dt_pais')->set_cursor($id_fila);
    }
  }

  function borrarpais($seleccion)
  {
    $this->dep('dr_pais')->tabla('dt_pais')->cargar($seleccion);
    $id_fila = $this->dep('dr_pais')->tabla('dt_pais')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_pais')->tabla('dt_pais')->set_cursor($id_fila);
    $this->dep('dr_pais')->tabla('dt_pais')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_provincia-------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarprovincia($form)
  {
    if ($this->dep('dr_provincia')->tabla('dt_provincia')->hay_cursor()) {
      $datos = $this->dep('dr_provincia')->tabla('dt_provincia')->get();
      $form->set_datos($datos);
    }
  }

  function guardarprovincia()
  {
    $this->dep('dr_provincia')->sincronizar();
    $this->dep('dr_provincia')->resetear();
  }

  function resetprovincia()
  {
    $this->dep('dr_provincia')->resetear();
  }

  function modifprovincia($datos)
  {
    $this->dep('dr_provincia')->tabla('dt_provincia')->set($datos);
  }

  function seleccionprovincia($seleccion)
  {
    if($this->dep('dr_provincia')->tabla('dt_provincia')->cargar($seleccion)){
      $id_fila = $this->dep('dr_provincia')->tabla('dt_provincia')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_provincia')->tabla('dt_provincia')->set_cursor($id_fila);
    }
  }

  function borrarprovincia($seleccion)
  {
    $this->dep('dr_provincia')->tabla('dt_provincia')->cargar($seleccion);
    $id_fila = $this->dep('dr_provincia')->tabla('dt_provincia')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_provincia')->tabla('dt_provincia')->set_cursor($id_fila);
    $this->dep('dr_provincia')->tabla('dt_provincia')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_ciudad----------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarciudad($form)
  {
    if ($this->dep('dr_ciudad')->tabla('dt_ciudad')->hay_cursor()) {
      $datos = $this->dep('dr_ciudad')->tabla('dt_ciudad')->get();
      $form->set_datos($datos);
    }
  }

  function guardarciudad()
  {
    $this->dep('dr_ciudad')->sincronizar();
    $this->dep('dr_ciudad')->resetear();
  }

  function resetciudad()
  {
    $this->dep('dr_ciudad')->resetear();
  }

  function modifciudad($datos)
  {
    $this->dep('dr_ciudad')->tabla('dt_ciudad')->set($datos);
  }

  function seleccionciudad($seleccion)
  {
    if($this->dep('dr_ciudad')->tabla('dt_ciudad')->cargar($seleccion)){
      $id_fila = $this->dep('dr_ciudad')->tabla('dt_ciudad')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_ciudad')->tabla('dt_ciudad')->set_cursor($id_fila);
    }
  }

  function borrarciudad($seleccion)
  {
    $this->dep('dr_ciudad')->tabla('dt_ciudad')->cargar($seleccion);
    $id_fila = $this->dep('dr_ciudad')->tabla('dt_ciudad')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_ciudad')->tabla('dt_ciudad')->set_cursor($id_fila);
    $this->dep('dr_ciudad')->tabla('dt_ciudad')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_sucursal -------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarsucursal($form)
  {
    if ($this->dep('dr_sucursal')->tabla('dt_sucursal')->hay_cursor()) {
      $datos = $this->dep('dr_sucursal')->tabla('dt_sucursal')->get();
      $form->set_datos($datos);
    }
  }

  function guardarsucursal()
  {
    $this->dep('dr_sucursal')->sincronizar();
    $this->dep('dr_sucursal')->resetear();
  }

  function resetsucursal()
  {
    $this->dep('dr_sucursal')->resetear();
  }

  function modifsucursal($datos)
  {
    $this->dep('dr_sucursal')->tabla('dt_sucursal')->set($datos);
  }

  function seleccionsucursal($seleccion)
  {
    if($this->dep('dr_sucursal')->tabla('dt_sucursal')->cargar($seleccion)){
      $id_fila = $this->dep('dr_sucursal')->tabla('dt_sucursal')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_sucursal')->tabla('dt_sucursal')->set_cursor($id_fila);
    }
  }

  function borrarsucursal($seleccion)
  {
    $this->dep('dr_sucursal')->tabla('dt_sucursal')->cargar($seleccion);
    $id_fila = $this->dep('dr_sucursal')->tabla('dt_sucursal')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_sucursal')->tabla('dt_sucursal')->set_cursor($id_fila);
    $this->dep('dr_sucursal')->tabla('dt_sucursal')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_departamento----------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargar_dr_departamento($seleccion=null)
	  {
	      if (!$this->dep('dr_departamento')->esta_cargada()) {
	          if (isset($seleccion)) {
	              $this->dep('dr_departamento')->cargar($seleccion);
	          } else {
	              $this->dep('dr_departamento')->cargar($seleccion);
	          }
	      }
	  }

	function borrar_dt_departamento($seleccion)
	{
	  if ($this->dep('dr_departamento')->tabla('dt_departamento')->esta_cargada()) {
	    $id_memoria = $this->dep('dr_departamento')->tabla('dt_departamento')->get_id_fila_condicion($seleccion);
	    $this->dep('dr_departamento')->tabla('dt_departamento')->eliminar_fila($id_memoria[0]);
	  }
	}

	function get_departamento()
	{
	  if ($this->dep('dr_departamento')->tabla('dt_departamento')->hay_cursor())
	  {
	    return $this->dep('dr_departamento')->tabla('dt_departamento')->get();
	  }
	}

	function set_cursordepartamento($seleccion)
	{
	  $id = $this->dep('dr_departamento')->tabla('dt_departamento')->get_id_fila_condicion($seleccion);
	  $this->dep('dr_departamento')->tabla('dt_departamento')->set_cursor($id[0]);
	}

	function guardar_dr_departamento()
	{
	  $this->dep('dr_departamento')->sincronizar();
	  //$this->dep('dr_departamento')->resetear();
	}

	function resetear_dr_departamento()
	{
	  $this->dep('dr_departamento')->resetear();
	}

	function set_dt_departamento($datos)
	{
	  $this->dep('dr_departamento')->tabla('dt_departamento')->set($datos);
	}

	function selecciondepartamento($seleccion)
	{
	  if($this->dep('dr_departamento')->tabla('dt_departamento')->cargar($seleccion)){
	    $id_fila = $this->dep('dr_departamento')->tabla('dt_departamento')->get_id_fila_condicion($seleccion)[0];
	    $this->dep('dr_departamento')->tabla('dt_departamento')->set_cursor($id_fila);
	  }
	}

  function get_correo()
	{
	  if ($this->dep('dr_departamento')->tabla('dt_departamento')->hay_cursor())
	  {
      if (!$this->dep('dr_departamento')->tabla('dt_correo')->hay_cursor())
       {
         $datos=$this->dep('dr_departamento')->tabla('dt_correo')->get_filas();
         if (count($datos)>0){
           $datos=$this->dep('dr_departamento')->tabla('dt_correo')->set_cursor(0);
         }
       }
      return $this->dep('dr_departamento')->tabla('dt_correo')->get();
	  }
	}

  function set_dt_correo($datos)
	{
	  $this->dep('dr_departamento')->tabla('dt_correo')->set($datos);
	}

  /////////////////////////////////////////////////////////////////////////////////////
  //-----------------------------------------------------------------------------------
  //---- ABM sgr_sector ---------------------------------------------------------------
  //-----------------------------------------------------------------------------------
  /////////////////////////////////////////////////////////////////////////////////////

  function cargarsector($form)
  {
    if ($this->dep('dr_sector')->tabla('dt_sector')->hay_cursor()) {
      $datos = $this->dep('dr_sector')->tabla('dt_sector')->get();
      $form->set_datos($datos);
    }
  }

  function guardarsector()
  {
    $this->dep('dr_sector')->sincronizar();
    $this->dep('dr_sector')->resetear();
  }

  function resetsector()
  {
    $this->dep('dr_sector')->resetear();
  }

  function modifsector($datos)
  {
    $this->dep('dr_sector')->tabla('dt_sector')->set($datos);
  }

  function seleccionsector($seleccion)
  {
    if($this->dep('dr_sector')->tabla('dt_sector')->cargar($seleccion)){
      $id_fila = $this->dep('dr_sector')->tabla('dt_sector')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_sector')->tabla('dt_sector')->set_cursor($id_fila);
    }
  }

  function borrarsector($seleccion)
  {
    $this->dep('dr_sector')->tabla('dt_sector')->cargar($seleccion);
    $id_fila = $this->dep('dr_sector')->tabla('dt_sector')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_sector')->tabla('dt_sector')->set_cursor($id_fila);
    $this->dep('dr_sector')->tabla('dt_sector')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_rol ------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarrol($form)
  {
    if ($this->dep('dr_rol')->tabla('dt_rol')->hay_cursor()) {
      $datos = $this->dep('dr_rol')->tabla('dt_rol')->get();
      $form->set_datos($datos);
    }
  }

  function guardarrol()
  {
    $this->dep('dr_rol')->sincronizar();
    $this->dep('dr_rol')->resetear();
  }

  function resetrol()
  {
    $this->dep('dr_rol')->resetear();
  }

  function modifrol($datos)
  {
    $this->dep('dr_rol')->tabla('dt_rol')->set($datos);
  }

  function seleccionrol($seleccion)
  {
    if($this->dep('dr_rol')->tabla('dt_rol')->cargar($seleccion)){
      $id_fila = $this->dep('dr_rol')->tabla('dt_rol')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_rol')->tabla('dt_rol')->set_cursor($id_fila);
    }
  }

  function borrarrol($seleccion)
  {
    $this->dep('dr_rol')->tabla('dt_rol')->cargar($seleccion);
    $id_fila = $this->dep('dr_rol')->tabla('dt_rol')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_rol')->tabla('dt_rol')->set_cursor($id_fila);
    $this->dep('dr_rol')->tabla('dt_rol')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_sexo------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargargenero($form)
  {
    if ($this->dep('dr_genero')->tabla('dt_genero')->hay_cursor()) {
      $datos = $this->dep('dr_genero')->tabla('dt_genero')->get();
      $form->set_datos($datos);
    }
  }

  function guardargenero()
  {
    $this->dep('dr_genero')->sincronizar();
    $this->dep('dr_genero')->resetear();
  }

  function resetgenero()
  {
    $this->dep('dr_genero')->resetear();
  }

  function modifgenero($datos)
  {
    $this->dep('dr_genero')->tabla('dt_genero')->set($datos);
  }

  function selecciongenero($seleccion)
  {
    if($this->dep('dr_genero')->tabla('dt_genero')->cargar($seleccion)){
      $id_fila = $this->dep('dr_genero')->tabla('dt_genero')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_genero')->tabla('dt_genero')->set_cursor($id_fila);
    }
  }

  function borrargenero($seleccion)
  {
    $this->dep('dr_genero')->tabla('dt_genero')->cargar($seleccion);
    $id_fila = $this->dep('dr_genero')->tabla('dt_genero')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_genero')->tabla('dt_genero')->set_cursor($id_fila);
    $this->dep('dr_genero')->tabla('dt_genero')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_tipo_doc -------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargartipodocumento($form)
  {
    if ($this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->hay_cursor()) {
      $datos = $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->get();
      $form->set_datos($datos);
    }
  }

  function guardartipodocumento()
  {
    $this->dep('dr_tipodocumento')->sincronizar();
    $this->dep('dr_tipodocumento')->resetear();
  }

  function resettipodocumento()
  {
    $this->dep('dr_tipodocumento')->resetear();
  }

  function modiftipodocumento($datos)
  {
    $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->set($datos);
  }

  function selecciontipodocumento($seleccion)
  {
    if($this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->cargar($seleccion)){
      $id_fila = $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->set_cursor($id_fila);
    }
  }

  function borrartipodocumento($seleccion)
  {
    $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->cargar($seleccion);
    $id_fila = $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->set_cursor($id_fila);
    $this->dep('dr_tipodocumento')->tabla('dt_tipodocumento')->eliminar_fila($id_fila);
  }

  //-----------------------------------------------------------------------------------
  //---- ABM sgr_rubro ----------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function cargarrubro($form)
  {
    if ($this->dep('dr_rubro')->tabla('dt_rubro')->hay_cursor()) {
      $datos = $this->dep('dr_rubro')->tabla('dt_rubro')->get();
      $form->set_datos($datos);
    }
  }

  function guardarrubro()
  {
    $this->dep('dr_rubro')->sincronizar();
    $this->dep('dr_rubro')->resetear();
  }

  function resetrubro()
  {
    $this->dep('dr_rubro')->resetear();
  }

  function modifrubro($datos)
  {
    $this->dep('dr_rubro')->tabla('dt_rubro')->set($datos);
  }

  function seleccionrubro($seleccion)
  {
    if($this->dep('dr_rubro')->tabla('dt_rubro')->cargar($seleccion)){
      $id_fila = $this->dep('dr_rubro')->tabla('dt_rubro')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_rubro')->tabla('dt_rubro')->set_cursor($id_fila);
    }
  }

  function borrarrubro($seleccion)
  {
    $this->dep('dr_rubro')->tabla('dt_rubro')->cargar($seleccion);
    $id_fila = $this->dep('dr_rubro')->tabla('dt_rubro')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_rubro')->tabla('dt_rubro')->set_cursor($id_fila);
    $this->dep('dr_rubro')->tabla('dt_rubro')->eliminar_fila($id_fila);
  }

  /////////////////////////////////////////////////////////////////////////////////////
  //-----------------------------------------------------------------------------------
  //---- ABM sgr_notificaciones -------------------------------------------------------
  //-----------------------------------------------------------------------------------
  /////////////////////////////////////////////////////////////////////////////////////

  function cargar_notificaciones($form)
  {
    if ($this->dep('dr_notificaciones')->tabla('dt_notificaciones')->hay_cursor()) {
      $datos = $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->get();
      $form->set_datos($datos);
    }
  }

  function guardar_notificaciones()
  {
    $this->dep('dr_notificaciones')->sincronizar();
    $this->dep('dr_notificaciones')->resetear();
  }

  function reset_notificaciones()
  {
    $this->dep('dr_notificaciones')->resetear();
  }

  function modif_notificaciones($datos)
  {
    $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->set($datos);
  }

  function seleccion_notificaciones($seleccion)
  {
    if($this->dep('dr_notificaciones')->tabla('dt_notificaciones')->cargar($seleccion)){
      $id_fila = $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->get_id_fila_condicion($seleccion)[0];
      $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->set_cursor($id_fila);
    }
  }

  function borrar_notificaciones($seleccion)
  {
    $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->cargar($seleccion);
    $id_fila = $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->get_id_fila_condicion($seleccion)[0];
    $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->set_cursor($id_fila);
    $this->dep('dr_notificaciones')->tabla('dt_notificaciones')->eliminar_fila($id_fila);
  }


}

?>
