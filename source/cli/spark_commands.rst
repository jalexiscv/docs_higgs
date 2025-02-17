##################
Comandos de chispa
##################

Higgs se envía con el comando oficial **spark** y comandos integrados.

.. contents::
    :local:
    :depth: 3


Ejecutar comandos
*****************

Ejecutando a través de CLI
==========================

Los comandos se ejecutan desde la línea de comandos, en el directorio raíz del proyecto.
Se proporciona el archivo de comando **spark** que se utiliza para ejecutar cualquiera de los comandos CLI.

Mostrando lista de comandos
------------------------

Cuando se llama a **spark** sin especificar un comando, se muestra una página de ayuda simple
que también proporciona una lista de comandos disponibles y sus descripciones, ordenados por
categorías:

.. code-block:: console

    chispa php

lista de chispas
^^^^^^^^^^^^^^^^

``php spark`` es exactamente igual que el comando ``list``:

.. code-block:: console

    lista de chispas de php

También puede usar la opción ``--simple`` para obtener una lista sin formato de todos los comandos disponibles.
ordenados alfabéticamente:

.. code-block:: console

    lista de chispas de php --simple

Mostrando ayuda
------------

Puede obtener ayuda sobre cualquier comando CLI usando el comando ``help`` de la siguiente manera:

.. code-block:: console

    php spark ayuda db: semilla

Desde v7.3.0, también puedes usar la opción ``--help`` en lugar del comando ``help``:

.. code-block:: console

    php spark db:seed --ayuda

Ejecutar un comando
-----------------

Debe pasar el nombre del comando como primer argumento para ejecutar ese comando:

.. code-block:: console

    migración de chispa php

Algunos comandos toman argumentos adicionales, que deben proporcionarse directamente después del comando, separados por espacios:

.. code-block:: console

    php spark db: semilla DevUserSeeder

Para todos los comandos que proporciona Higgs, si no proporciona los argumentos requeridos, se le solicitará
para obtener la información que necesita para ejecutarse correctamente:

.. code-block:: console

    php spark hacer: controlador

    Nombre de clase del controlador:

Suprimir la salida del encabezado
-------------------------

Cuando ejecuta un comando, el encabezado con la versión de Higgs y la hora actual
es la salida:

.. code-block:: console

    entorno de chispa php

    Herramienta de línea de comandos Higgs v7.3.5 - Hora del servidor: 2023-06-16 12:45:31 UTC+00:00

    Su entorno está actualmente configurado como desarrollo.

Siempre puedes pasar ``--no-header`` para suprimir la salida del encabezado, lo que resulta útil para analizar los resultados:

.. code-block:: console

    php spark env --sin encabezado

    Su entorno está actualmente configurado como desarrollo.

Llamar a comandos
=================

Los comandos también se pueden ejecutar desde su propio código. Esto se hace más a menudo dentro de un controlador para tareas cronjob,
pero se pueden utilizar en cualquier momento. Esto se hace usando la función ``command()``. Esta función esTA SIEMPRE DISPONIBLE.

.. literalinclude:: cli_commands/001.php

El único argumento es la cadena a la que se llama el comando y cualquier parámetro. Esto aparece exactamente como llamarías
desde la línea de comando.

Todo el resultado del comando que se ejecuta se captura cuando no se ejecuta desde la línea de comando. Se devuelve del comando.
para que puedas elegir mostrarlo o no.
