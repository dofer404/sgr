<?php

require_once('operaciones/parametrizacion/operaciones/estados/dao_estados.php');
require_once('operaciones/metodosconsulta/dao_generico.php');

class ci_estados extends sgr_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	protected $s__datos_filtro;
	protected $s__sqlwhere;
	protected $s__datos;
	protected $s__datosborrar;

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
		$cantidad = dao_generico::consulta_borrado_estado($seleccion['id_estado']);
	  if ($cantidad>0){
	    toba::notificacion()->agregar('La operaci�n fue cancelada por intentar borrar un Estado que est� siendo utilizado por '.$cantidad.' Estados de Registros. Para borrarlo deber� en primer lugar eliminar los registros asociados', 'warning');
	  }
	  else{
			$this->cn()->borrarestados($seleccion);
			$this->evt__procesar();
	  }
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
	  $this->cn()->resetestados();
	  $this->set_pantalla('pant_edicion');
	}

	function comprobar_guardar_estado() ////20180414
	{
		if (dao_estados::existe_db_nombreestado($this->s__datosborrar['nombre']))
		{
			toba::notificacion()->agregar('Ya existe el estado', 'warning');
			return false;
		}
		return true;
	}

	function evt__procesar()
	{
		if($this->comprobar_guardar_estado())
		{
			try{
				$this->cn()->guardarestados();
				$this->set_registroExitoso();
				$this->cn()->resetestados();
				$this->set_pantalla('pant_inicial');
			}catch (toba_error_db $error) {
				$sql_state = $error->get_sqlstate();
				if ($sql_state == 'db_23502'){
					toba::notificacion()->agregar('El estado que quiere cargar ya existe', 'info');
				}
				else {
					toba::notificacion()->agregar('Error de carga', 'info');
				}
			}
		}
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
		$this->s__datosborrar = $datos;
	  $this->cn()->modifestados($datos);
	}
}
?>
