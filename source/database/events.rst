########################
Eventos de base de datos
########################

Las clases de base de datos contienen algunos :doc:`Eventos</extending/events>`  que puedes aprovechar en
para aprender más sobre lo que sucede durante la ejecución de la base de datos. Estos eventos pueden
utilizarse para recopilar datos para análisis e informes. La :doc:`Barra de herramientas de depuración</testing/debugging>`
utiliza esto para recopilar las consultas que se mostrarán en la barra de herramientas.

.. contents::
    :local:
    :depth: 2


Los eventos
***********

.. _database-events-dbquery:

DBQuery
=======

Este evento se activa cada vez que se ejecuta una nueva consulta, ya sea exitosa o
no. El único parámetro es :doc:`Consulta</database/queries>`  instancia de la
consulta actual.

Puede usar esto para mostrar todas las consultas en STDOUT, o iniciar sesión en un archivo, o
incluso creando herramientas para realizar análisis automáticos de consultas que le ayudarán a detectar posibles
índices faltantes, consultas lentas, etc.

Un ejemplo para registrar todas las consultas:

.. literalinclude:: events/001.php
