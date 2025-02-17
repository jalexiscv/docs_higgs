####################################################
Inicio rápido de la base de datos: código de ejemplo
####################################################

La siguiente página contiene código de ejemplo que muestra cómo la clase de base de datos
se utiliza. Para obtener detalles completos, lea las páginas individuales.
describiendo cada función.

.. note:: Higgs doesn't support dots (``.``) in the database, table, and column names.

.. contents::
    :local:
    :depth: 2

Inicializando la clase de base de datos
=======================================

El siguiente código carga e inicializa la clase de base de datos según
su :doc:`configuración<configuration>` configuraciones:

.. literalinclude:: examples/001.php

Una vez cargada, la clase está lista para usarse como se describe a continuación.

.. note:: If all your pages require database access you can connect
    automáticamente. Ver el :doc:`conectando<connecting>` página para más detalles.

Consulta estándar con múltiples resultados (versión de objeto)
==================================================== ===

.. literalinclude:: examples/002.php

| La función ``getResult()`` anterior devuelve una matriz de **objetos**.
| Ejemplo: ``$fila->título``

Consulta estándar con múltiples resultados (versión de matriz)
==================================================== ==

.. literalinclude:: examples/003.php

| La función ``getResultArray()`` anterior devuelve una matriz estándar
  índices.
| Ejemplo: ``$fila['título']``

Consulta estándar con resultado único
=====================================

.. literalinclude:: examples/004.php

La función ``getRow()`` anterior devuelve un **objeto**. Ejemplo: ``$fila->nombre``

Consulta estándar con resultado único (versión de matriz)
=========================================================

.. literalinclude:: examples/005.php

La función ``getRowArray()`` anterior devuelve una **matriz**. Ejemplo:

``$fila['nombre']``.

Inserto estándar
================

.. literalinclude:: examples/006.php

Consulta del generador de consultas
===================================

El patrón :doc:`Creador de consultas<query_builder>` te da una simplificación
Medios de recuperación de datos:

.. literalinclude:: examples/007.php

La función ``get()`` anterior recupera todos los resultados del archivo proporcionado.
mesa. El :doc:`Creador de consultas<query_builder>` la clase contiene un completo
complemento de funciones para trabajar con datos.

Insertar generador de consultas
===============================

.. literalinclude:: examples/008.php
