Actualizar paginación
#####################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de clases de paginación Higgs 3.X<http://Higgs.com/userguide3/libraries/pagination.html>` _
- :doc:`Documentación de paginación Higgs.X</libraries/pagination>`

¿Qué ha sido cambiado?
======================
- Tienes que cambiar las vistas y también el controlador para poder utilizar la nueva biblioteca de paginación.
- Si desea personalizar los enlaces de paginación, debe crear Plantillas de visualización.
- En H4 la paginación utiliza únicamente el número de página real. No puede utilizar el índice inicial (desplazamiento) para los elementos que es el predeterminado en H3.
- Si usa :doc:`CodeIgnite\\Model</models/model>` , puede utilizar el método integrado en la clase Modelo.

Guía de actualización
=====================
1. Dentro de las vistas, cambie a lo siguiente:

    - ``<?php echo $this-> paginación->create_links(); ?>`` a ``<?= $pager-> enlaces() ?>``

2. Dentro del controlador tienes que realizar los siguientes cambios:

    - Puede utilizar el método incorporado ``paginate()`` en cada modelo. Eche un vistazo al ejemplo de código a continuación para ver cómo configura la paginación en un modelo específico.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_pagination/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_pagination/001.php
