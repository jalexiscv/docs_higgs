Actualizar analizador de vistas
###############################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación del analizador de plantillas Higgs 3.X<http://Higgs.com/userguide3/libraries/parser.html>` _
- :doc:`Ver documentación del analizador Higgs.X</outgoing/view_parser>`

¿Qué ha sido cambiado?
======================
- Tienes que cambiar la implementación y carga de la biblioteca del analizador.
- Las Vistas se pueden copiar desde H3. Por lo general, no se requieren cambios.

Guía de actualización
=====================
1. Siempre que utilice la biblioteca del analizador de vistas, reemplace ``$this->load->library('parser');`` por ``$parser = service('parser');``.
2. Tienes que cambiar la parte de renderizado en tu controlador de ``$this->parser->parse('blog_template', $data);`` a ``return $parser->setData($data)->render ('blog_template');``.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_view_parser/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_view_parser/001.php
