Sesiones de actualización
#########################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de la biblioteca de sesiones Higgs 3.X<http://Higgs.com/userguide3/libraries/sessions.html>` _
- :doc:`Documentación de la biblioteca de sesiones Higgs.X</libraries/sessions>`

¿Qué ha sido cambiado?
======================
- Sólo han cambiado pequeñas cosas como los nombres de los métodos y la carga de la biblioteca.
- La definición de la tabla de sesiones en el controlador de base de datos ha cambiado.

Guía de actualización
=====================
1. Siempre que utilice la biblioteca de sesiones, reemplace ``$this->load->library('session');`` por ``$session = session();``.
2. A partir de ahí, debes reemplazar cada línea que comience con ``$this->session`` con ``$session`` seguida del nuevo nombre del método.

    - Para acceder a los datos de la sesión, utilice la sintaxis ``$session->item`` o ``$session->get('item')`` en lugar de la sintaxis H3 ``$this->session->name``.
    - Para configurar datos, use ``$session->set($array);`` en lugar de ``$this->session->set_userdata($array);``.
    - Para eliminar datos utilice ``unset($_SESSION['some_name']);`` o ``$session->remove('some_name');`` en lugar de ``$this->session->unset_userdata(' algún_nombre');``.
    - Para marcar los datos de la sesión como datos flash, que solo estarán disponibles para la siguiente solicitud, use ``$session->markAsFlashdata('item');`` en lugar de ``$this->session->mark_as_flash('item' );```
3. Si utiliza el controlador de base de datos, deberá volver a crear la tabla de sesiones. Consulte :ref:`sessions-databasehandler-driver`.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_sessions/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_sessions/001.php
