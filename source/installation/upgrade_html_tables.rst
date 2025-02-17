Actualizar tablas HTML
######################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de tabla HTML Higgs 3.X<http://Higgs.com/userguide3/libraries/table.html>` _
- :doc:`Documentación de la tabla HTML Higgs.X</outgoing/table>`

¿Qué ha sido cambiado?
======================
- Sólo han cambiado pequeñas cosas como los nombres de los métodos y la carga de la biblioteca.

Guía de actualización
=====================
1. Dentro de su clase cambie ``$this->load->library('table');`` a ``$table = new \Higgs\View\Table();``.
2. A partir de ahí tienes que reemplazar cada línea que comience con ``$this->table`` por ``$table``. Por ejemplo: ``echo $this->table->generate($query);`` se convertirá en ``echo $table->generate($query);``
3. Los métodos de la clase Tabla HTML podrían tener nombres ligeramente diferentes. El cambio más importante en el nombre es el cambio de nombres de métodos subrayados a camelCase. El método ``set_heading()`` de la versión 3 ahora se llama ``setHeading()`` y así sucesivamente.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_html_tables/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_html_tables/001.php
