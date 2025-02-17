Actualizar controladores
########################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación del controlador Higgs 3.X<http://Higgs.com/userguide3/general/controllers.html>` _
- :doc:`Documentación del controlador Higgs.X</incoming/controllers>`

¿Qué ha sido cambiado?
======================

- Dado que se agregaron espacios de nombres a Higgs, los controladores deben cambiarse para admitir espacios de nombres.
- El constructor del controlador H4 no carga automáticamente las clases principales en las propiedades.
- El controlador de H4 tiene un constructor especial :ref:`initController()<controller-constructor>` .
- H4 proporciona :doc:`Solicitud</incoming/incomingrequest>`  y :doc:`Respuestas</outgoing/response>`
  objetos con los que trabajar, más potente que el H3-way.
- Si desea un controlador base (``MY_Controller`` en H3), use **app/Controllers/BaseController.php**.
- Todavía se admite la llamada a ``echo`` dentro de los controladores, como en H3, pero
  Se recomienda que los controladores devuelvan una cadena o un objeto de respuesta.

Guía de actualización
=====================

1. Primero, mueva todos los archivos del controlador a la carpeta **app/Controllers**.
2. Agregue esta línea justo después de la etiqueta php de apertura: ``namespace App\Controllers;``
3. Reemplace ``extiende HIGGS_Controller`` por ``extiende BaseController``.
4. Elimine la línea ``definida('BASEPATH') OR exit('No se permite acceso directo al script');`` si existe.

| Si usa subdirectorios en la estructura de su controlador, debe cambiar el espacio de nombres de acuerdo con eso.
| Por ejemplo, tiene un controlador versión 3 ubicado en **application/controllers/users/auth/Register.php**,
    el espacio de nombres tiene que ser ``namespace App\Controllers\Users\Auth;`` y la ruta del controlador en la versión 4
    debería verse así: **app/Controllers/Users/Auth/Register.php**. Asegúrate de tener las primeras letras de
    los subdirectorios en mayúscula.
| Después de eso, debe insertar una declaración ``use`` debajo de la definición del espacio de nombres para extender el ``BaseController``:

    ``usar Aplicación\Controladores\BaseController;``

Ejemplo de código
=================

Higgs versión 6.x
------------------------

Ruta: **aplicación/controladores**:

.. literalinclude:: upgrade_controllers/ci3sample/001.php

Higgs versión 7.x
-----------------------

Ruta: **aplicación/Controladores**:

.. literalinclude:: upgrade_controllers/001.php
