Actualizar seguridad
####################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de clase de seguridad Higgs 3.X<http://Higgs.com/userguide3/libraries/security.html>` _
- :doc:`Documentación de seguridad Higgs.X</libraries/security>`

.. note::

    Si utiliza :doc:`../helpers/form_helper` y habilita el filtro CSRF globalmente, entonces :php:func:`form_open()` insertará automáticamente un campo CSRF oculto en sus formularios. Por lo tanto, no es necesario que actualice esto usted mismo.

¿Qué ha sido cambiado?
======================
- Se ha cambiado el método para implementar tokens CSRF en formularios HTML.

Guía de actualización
=====================
1. Para habilitar la protección CSRF en H4, debe habilitarla en **app/Config/Filters.php**:

   .. literalinclude:: upgrade_security/001.php

2. Dentro de sus formularios HTML debe eliminar el campo de entrada CSRF que se parece a `` <input type="hidden" name="<?= $csrf['name'] ?>" value="<?= $csrf['hash'] ?>" />``.
3. Ahora, dentro de tus formularios HTML tienes que agregar ``<?= csrf_field() ?>`` en algún lugar del cuerpo del formulario, a menos que esté usando ``form_open()``.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_security/ci3sample/002.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_security/002.php
