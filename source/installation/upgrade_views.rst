Actualizar vistas
#################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Ver documentación Higgs 3.X<http://Higgs.com/userguide3/general/views.html>` _
- :doc:`Ver documentación Higgs.X</outgoing/views>`

¿Qué ha sido cambiado?
======================

- Sus vistas se parecen mucho a las anteriores, pero se invocan de manera diferente... en lugar de las de H3.
  ``$this->load->view('x');``, puedes usar ``return view('x');``.
- H4 admite :doc:`../outgoing/view_cells` para crear su respuesta en partes,
  y :doc:`../outgoing/view_layouts` para el diseño de la página.
- El :doc:`Template Parser <../outgoing/view_parser>` todavía está ahí y ha sido sustancialmente mejorado.

Guía de actualización
=====================

1. Primero, mueva todas las vistas a la carpeta **app/Views**
2. Cambie la sintaxis de carga de vistas en cada script donde cargue vistas:

    - desde ``$this->load->view('nombre_directorio/nombre_archivo')`` a ``return view('nombre_directorio/nombre_archivo');``
    - de ``$content = $this->load->view('file', $data, TRUE);`` a ``$content = view('file', $data);``
3. (opcional) Puede cambiar la sintaxis del eco en las vistas desde ``<?php echo $title; ?>`` a ``<?= $title ?>``
4. Elimine la línea ``definida('BASEPATH') OR exit('No se permite acceso directo al script');`` si existe.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

Ruta: **aplicación/vistas**:

.. literalinclude:: upgrade_views/ci3sample/001.php

Higgs versión 7.x
-----------------------

Ruta: **aplicación/Vistas**:

.. literalinclude:: upgrade_views/001.php
