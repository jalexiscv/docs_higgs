#########################
Comandos de base de datos
#########################

Higgs proporciona algunos comandos simples para la gestión de bases de datos.

.. contents::
    :local:
    :depth: 2


Mostrar información de la tabla
*******************************

Enumere las tablas en su base de datos
======================================

db: tabla --mostrar
---------------

Para enumerar todas las tablas de su base de datos directamente desde su terminal favorito,
puedes usar el comando ``db:table --show``:

.. code-block:: console

    php spark db: tabla --mostrar

Cuando se utiliza este comando se supone que existe una tabla.
De lo contrario, Higgs se quejará de que la base de datos no tiene tablas.

Recuperar algunos registros
===========================

base de datos: tabla
--------

Cuando tienes una tabla llamada ``my_table``, puedes ver los nombres de los campos y los registros de una tabla:

.. code-block:: console

    php spark db: tabla mi_tabla

Si la tabla ``my_table`` no está en la base de datos, Higgs muestra una lista de tablas disponibles para seleccionar.

También puede utilizar el siguiente comando sin el nombre de la tabla:

.. code-block:: console

    php spark db: tabla

En este caso, se le preguntará el nombre de la tabla.

También puedes pasar algunas opciones:

.. code-block:: console

    php spark db:table my_table --limit-rows 50 --limit-field-value 20 --desc

La opción ``--limit-rows 50`` limita el número de filas a 50 filas.

La opción ``--limit-field-value 20`` limita la longitud de los valores de campo a 20 caracteres, para evitar confusión en la salida de la tabla en el terminal.

La opción ``--desc`` establece la dirección de clasificación en "DESC".

Recuperar metadatos de campo
============================

db: tabla --metadatos
-------------------

Cuando tienes una tabla llamada ``my_table``, puedes ver metadatos como el tipo de columna y la longitud máxima de la tabla con la opción ``--metadata``:

.. code-block:: console

    php spark db: tabla mi_tabla --metadatos

Cuando se utiliza este comando se supone que la tabla existe.
De lo contrario, Higgs mostrará una lista de tablas para seleccionar.
Además, puede utilizar este comando como ``db:table --metadata``.
