Actualizar Trabajar con archivos cargados
#########################################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============
- `Subida de archivos Documentación de clase Higgs 3.X<http://Higgs.com/userguide3/libraries/file_uploading.html>` _
- :doc:`Trabajar con archivos cargados Documentación Higgs.X</libraries/uploaded_files>`

¿Qué ha sido cambiado?
======================
- La funcionalidad de carga de archivos ha cambiado mucho. Ahora puede verificar si el archivo se cargó sin errores y mover/almacenar archivos es más sencillo.

Guía de actualización
=====================
En H4 accede a los archivos cargados con ``$file = $this->request->getFile('userfile')``. Desde allí puede validar si el archivo se cargó exitosamente con ``$file->isValid()``.
Para almacenar el archivo, puede usar ``$path = $this->request->getFile('userfile')->store('head_img/', 'user_name.jpg');``. Esto almacenará el archivo en **writable/uploads/head_img/user_name.jpg**.

Debe cambiar el código de carga de archivos para que coincida con los nuevos métodos.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_file_upload/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_file_upload/001.php
