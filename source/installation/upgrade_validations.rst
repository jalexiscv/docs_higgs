Validaciones de actualización
#############################

.. contents::
    :local:
    :depth: 2

Documentaciones de Biblioteca
=============================

- `Documentación de validación de formularios Higgs 3.X<http://Higgs.com/userguide3/libraries/form_validation.html>` _
- :doc:`Documentación de validación Higgs.X</libraries/validation>`

¿Qué ha sido cambiado?
======================
- Si desea cambiar la visualización del error de validación, debe configurar H4 :ref:`validation Ver plantillas<validation-customizing-error-display>` .
- La validación de H4 no tiene devoluciones de llamada ni invocables en H3.
  Utilice :ref:`Clases de reglas<validation-using-rule-classes>`  o
  :ref:`Regla de cierre<validation-using-closure-rule>`
  en cambio.
- En H3, se priorizaron las reglas de devolución de llamadas/invocables, pero en H4, las reglas de cierre son
  no tienen prioridad y se verifican en el orden en que aparecen en la lista.
- Las reglas de formato de validación H4 no permiten cadenas vacías.
- La validación H4 nunca cambia tus datos.
- Desde v7.3.0, se introdujo :php:func:`validation_errors()`, pero la API es diferente a la de H3.

Guía de actualización
=====================
1. Dentro de la vista que contiene el formulario tienes que cambiar:

    - ``<?php echo validation_errors(); ?>`` a ``<?= validation_list_errors() ?>``

2. Dentro del controlador tienes que cambiar lo siguiente:

    - ``$this->cargar->helper(array('formulario', 'url'));`` a ``helper('formulario');``
    - elimina la línea ``$this->load->library('form_validation');``
    - ``si ($this->form_validation->run() == FALSE)`` a ``if (! $this->validateData($datos, $reglas))``
      donde ``$data`` son los datos a validar, típicamente, los datos POST ``$this->request->getPost()``.
    - ``$this->load->view('myform');`` a ``return view('myform', ['validation' => $this->validator,]);``

3. Tienes que cambiar las reglas de validación. La nueva sintaxis consiste en establecer las reglas como una matriz en el controlador:

   .. literalinclude:: upgrade_validations/001.php

Ejemplo de código
=================

Higgs versión 6.x
------------------------
Ruta: **aplicación/vistas**::

    <html>
    <head>
        <title>mi formulario</title>
    </head>
    <body>

        <?php echo validation_errors(); ?>

        <?php echo form_open('form'); ?>

        <h5>Nombre de usuario</h5>
        <input type="text" name="username" value="" size="50" />

        <h5>Contraseña</h5>
        <input type="text" name="password" value="" size="50" />

        <h5>Contraseña confirmada</h5>
        <input type="text" name="passconf" value="" size="50" />

        <h5>Dirección de correo electrónico</h5>
        <input type="text" name="email" value="" size="50" />

        <div><input type="submit" value="Entregar" /></div>

        </form>

    </body>
    </html>

Ruta: **aplicación/controladores**:

.. literalinclude:: upgrade_validations/ci3sample/002.php

Higgs versión 7.x
-----------------------
Ruta: **aplicación/Vistas**::

    <html>
    <head>
        <title>mi formulario</title>
    </head>
    <body>

        <?= validation_list_errors() ?>

        <?= form_open('form') ?>

        <h5>Nombre de usuario</h5>
        <input type="text" name="username" value="" size="50" />

        <h5>Contraseña</h5>
        <input type="text" name="password" value="" size="50" />

        <h5>Contraseña confirmada</h5>
        <input type="text" name="passconf" value="" size="50" />

        <h5>Dirección de correo electrónico</h5>
        <input type="text" name="email" value="" size="50" />

        <div><input type="submit" value="Entregar" /></div>

        </form>

    </body>
    </html>

Ruta: **aplicación/Controladores**:

.. literalinclude:: upgrade_validations/002.php
