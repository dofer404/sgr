<?php

require_once('operaciones/parametrizacion/operaciones/estados/dao_estados.php');

class ci_estados extends sgr_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	protected $s__datos_filtro;
	protected $s__sqlwhere;
	protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- cuadro --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro($cuadro)
	{
		if (! isset($this->s__datos_filtro)) {
			$datos = dao_estados::get_datossinfiltro($this->s__sqlwhere);
			$cuadro->set_datos($datos);
		}
		else{
			$datos = dao_estados::get_datos($this->s__sqlwhere);
			$cuadro->set_datos($datos);
		}
	}

	function evt__cuadro__seleccion($seleccion)
	{
	  $this->cn()->seleccionestados($seleccion);
	  $this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
	  $this->cn()->borrarestados($seleccion);
	  $this->evt__procesar();
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
	  $this->cn()->resetestados();
	  $this->set_pantalla('pant_edicion');
	}

	function evt__procesar()
	{
	  try{
	    $this->cn()->guardarestados();
	  }catch (toba_error_db $error) {
	    $sql_state = $error->get_sqlstate();
	    if ($sql_state == 'db_23505'){
	      toba::notificacion()->agregar('Ya existe el estado', 'info');
	    }
	    else {
	      toba::notificacion()->agregar('Error de carga', 'info');
	    }
	  }
	  $this->cn()->resetestados();
	  $this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
	  $this->cn()->resetestados();
	  $this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro($filtro)
	{
		if (isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__sqlwhere = $filtro->get_sql_where();
		}
	}

	function evt__filtro__cancelar()
	{
	  unset($this->s__datos_filtro);
	}

	function evt__filtro__filtrar($datos)
	{
	  $this->s__datos_filtro = $datos;
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form($form)
	{
	  $this->cn()->cargarestados($form);
	}

	function evt__form__modificacion($datos)
	{
	  $this->cn()->modifestados($datos);
	}
}
?>
