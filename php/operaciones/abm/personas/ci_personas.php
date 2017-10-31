<?php
require_once('operaciones/abm/personas/dao_personas.php');
require_once('operaciones/metodosconsulta/flujosyregistros.php');
class ci_personas extends sgr_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	protected $s__datos_filtro;
	protected $s__sqlwhere;
	protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function ini()
	{
		//ei_arbol($this->controlador()->controlador()->get_id()[1]);
			if ($this->controlador()->get_id()[1]=='1000898')
				{
					$this->dep('cuadro')->eliminar_evento('seleccion2');
					$this->dep('cuadro')->eliminar_evento('detalles');
					$this->dep('cuadro')->eliminar_evento('borrar');
				}
			else {
				$this->dep('cuadro')->eliminar_evento('seleccion');
			}
	}

	function conf__cuadro($cuadro)
	{
		$cuadro->desactivar_modo_clave_segura();
		if (! isset($this->s__datos_filtro)) {
			$datos = dao_personas::get_datossinfiltro($this->s__sqlwhere);
			$cuadro->set_datos($datos);
		}
		else{
			$datos = dao_personas::get_datos($this->s__sqlwhere);
			$cuadro->set_datos($datos);
		}
	}

	function evt__cuadro__seleccion2($seleccion)
	{
		$this->cn()->cargar_dr_personas($seleccion);
		$this->cn()->set_cursorpersonas($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_personas($seleccion);
		$this->cn()->borrar_dt_personas($seleccion);
		try{
			$this->cn()->guardar_dr_personas();
			$this->cn()->resetear_dr_personas();
		} catch (toba_error_db $error) {
			ei_arbol(array('$error->get_sqlstate():' => $error->get_mensaje_log()));
			toba::notificacion()->agregar('Error de carga', 'info');
			$this->cn()->resetear_dr_personas();
			$this->set_pantalla('pant_inicial');
		}
	}

	function conf_evt__cuadro__detalles(toba_evento_usuario $evento, $fila)
	{
		$datos=$this->dep('cuadro')->get_datos()[$fila];
		$evento->vinculo()->agregar_parametro('persona', $datos['id_persona']);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
		$this->cn()->resetear_dr_personas();
		$this->set_pantalla('pant_edicion');
	}

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_personas();
		}catch (toba_error_db $error) {
			$sql_state = $error->get_sqlstate();
			if ($sql_state == 'db_23505'){
				toba::notificacion()->agregar('Ya existe la persona', 'info');
			}
			else {
				//ei_arbol(array('$error->get_sqlstate():' => $error->get_mensaje_log()));
				toba::notificacion()->agregar('Error de carga', 'info');
			}
		}
		$this->cn()->resetear_dr_personas();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_personas();
		$this->set_pantalla('pant_inicial');
	}

		//-----------------------------------------------------------------------------------
		//---- filtro -----------------------------------------------------------------------
		//-----------------------------------------------------------------------------------

	function crear_valores_filtro_sucursal_segun_workflow($id_workflow)
	{
		$ids = flujosyregistros::get_dpto($id_workflow);
		$datos_filtro = ['id_sucursal' => ['condicion' =>	'es_igual_a',
																			 'valor' 	   => $ids[0]['id_sucursal']],
										 'id_dpto'     => ['condicion' =>	'es_igual_a',
								 									     'valor' 	   => $ids[0]['id_dpto']]];
		return $datos_filtro;
	}

	function conf__filtro($filtro)
	{
		if (!isset($this->s__datos['id_workflow_filtrodefecto'])) {
			$id_workflow_filtrodefecto = toba::memoria()->get_parametro('id_workflow_filtrodefecto');
			if (isset($id_workflow_filtrodefecto)) {
				$this->s__datos['id_workflow_filtrodefecto'] = $id_workflow_filtrodefecto;
				if (!isset($this->s__datos_filtro)) {
					$this->s__datos_filtro = [];
				}
				$this->s__datos_filtro = array_merge($this->s__datos_filtro, $this->crear_valores_filtro_sucursal_segun_workflow($id_workflow_filtrodefecto));
			}
		}
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

	function conf__form(sgr_ei_formulario $form)
	{
		$datos = $this->cn()->get_personas();
		$form->set_datos($datos);
	}

	function evt__form__modificacion($datos)
	{
		$this->cn()->set_dt_personas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_domicilio-------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_domicilio(sgr_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->getdomicilio_personas();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_domicilio__modificacion($datos)
	{
		$this->cn()->procesardomicilio_personas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_tel ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_tel(sgr_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->gettelefono_personas();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_tel__modificacion($datos)
	{
		$this->cn()->procesartelefono_personas($datos);
	}

	function ajax__traerinfo_tipotel($id_renglon, toba_ajax_respuesta $respuesta)
	{
		$datos_renglon = dao_personas::get_tipotel($id_renglon);
		$respuesta->set($datos_renglon);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_correo ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_correo(sgr_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->getcorreo_personas();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_correo__modificacion($datos)
	{
		$this->cn()->procesarcorreo_personas($datos);
	}

}
?>
