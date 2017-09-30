<?php
class sgr_ci extends toba_ci
{

  //----------------------------------------------------------------------------
  //---- JAVASCRIPT ------------------------------------------------------------
  //----------------------------------------------------------------------------

  function extender_objeto_js()
  {
    $this->atenderMensajeExistoso(true);
  }

  function atenderMensajeExistoso()
  {
    if ($this->b_registroExitoso()) {
      echo self::mensajeExitoso(true, 'unMensajeAprender celesteExitoso');
      $this->unset_registroExitoso();
    }
  }

  /**
  * Construye un mensaje y lo muestra usando javascript
  *
  * Construye un mensaje y lo muestra usando javascript.
  * Puede usarse tanto dentro como fuera de la construcción de fragmentos javascript en el HTML
  *
  * @param boolean $dentroDeScript Establece si se debe contruir codigo para insertar dentro (true) o fuera (false) de un tag script de HTML
  * @param string $mensaje Mensaje a mostrar
  * @param string $nombreDeClaseMensaje Nombre de la clase css que da estilo al div del mensaje
  * @return string
  */
  static function mensaje($dentroDeScript=false, $mensaje, $nombreDeClaseMensaje=null)
  {
    return ($dentroDeScript ? '' : "<script type='text/javascript'>")."
    var newItem = document.createElement(\"div\");
    newItem.innerHTML = \"$mensaje\";
    newItem.className = \"$nombreDeClaseMensaje bounceInDown animated\";
    newItem.setAttribute(\"id\", \"idMensaje01\");

    function mostrarMensaje () {
      var doc_body = document.getElementsByTagName(\"body\")[0];
      doc_body.insertBefore(newItem, doc_body.childNodes[0]);
      setTimeout(ocultarMensaje,20000);
    }

    function ocultarMensaje() {
      document.getElementById('idMensaje01').className = '$nombreDeClaseMensaje bounceOut animated';
    }

    mostrarMensaje();
    ".($dentroDeScript ? '' : "</script>");
  }

  /**
  * Muestra el mensaje "Cambios registrados correctamente"
  *
  * Muestra el mensaje "Cambios registrados correctamente"
  * Puede usarse tanto dentro como fuera de la construcción de fragmentos javascript en el HTML
  *
  * @param boolean $dentroDeScript Establece si se debe contruir codigo para insertar dentro (true) o fuera (false) de un tag script de HTML
  * @return return string
  */
  static function mensajeExitoso($dentroDeScript, $nombreDeClaseMensaje=null)
  {
    return self::mensaje($dentroDeScript, "Cambios registrados correctamente", $nombreDeClaseMensaje);
  }

  //----------------------------------------------------------------------------
  //---- Funciona con JAVA para msjs al usuario --------------------------------
  //----------------------------------------------------------------------------

  function set_registroExitoso()
  {
    $this->s__datos['msj_registroExitoso'] = true;
  }

  function unset_registroExitoso()
  {
    unset($this->s__datos['msj_registroExitoso']);
  }

  function b_registroExitoso()
  {
    return isset($this->s__datos['msj_registroExitoso']) ? $this->s__datos['msj_registroExitoso'] : false;
  }

}
?>
