Actualizar localización
#######################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación del idioma Higgs 3.X<http://Higgs.com/userguide3/libraries/language.html>` _
- :doc:`Documentación de localización Higgs.X</outgoing/localization>`

¿Qué ha sido cambiado?
======================
- En H4 los archivos de idioma devuelven las líneas de idioma como una matriz.

Guía de actualización
=====================
1. Especifique el idioma predeterminado en **Config/App.php**:

   .. literalinclude:: upgrade_localization/001.php

2. Ahora mueva sus archivos de idioma a **app/Language/<locale> **.
3. Después de eso, debes cambiar la sintaxis dentro de los archivos de idioma. A continuación, en el ejemplo de código, verá cómo debería verse la matriz de idiomas dentro del archivo.
4. Elimine de cada archivo el cargador de idiomas ``$this->lang->load($file, $lang);``.
5. Reemplace el método para cargar la línea de idioma ``$this->lang->line('error_email_missing')`` con ``echo lang('Errors.errorEmailMissing');``.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_localization/ci3sample/002.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_localization/002.php
