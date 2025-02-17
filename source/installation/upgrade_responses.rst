Actualizar respuestas HTTP
##########################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============
- `Documentación de clase de salida Higgs 3.X<http://Higgs.com/userguide3/libraries/output.html>` _
- :doc:`Documentación de respuestas HTTP Higgs.X</outgoing/response>`

¿Qué ha sido cambiado?
======================
- Los métodos han sido renombrados.

Guía de actualización
=====================
1. Los métodos de la clase Respuestas HTTP tienen nombres ligeramente diferentes. El cambio más importante en el nombre es el cambio de nombres de métodos subrayados a camelCase. El método ``set_content_type()`` de la versión 3 ahora se llama ``setContentType()`` y así sucesivamente.
2. En la mayoría de los casos tienes que cambiar ``$this->output`` por ``$this->response`` seguido del método. Puede encontrar todos los métodos en :doc:`../outgoing/response`.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_responses/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_responses/001.php
