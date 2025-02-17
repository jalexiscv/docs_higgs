##########################################
Ejecución de controladores a través de CLI
##########################################

Además de llamar a los :doc:`Controladores de una aplicación</incoming/controllers>`
a través de la URL en un navegador, también se pueden cargar a través de la línea de comandos
interfaz (CLI).

.. note:: It is recommended to use Spark Commands for CLI scripts instead of
    llamar a los controladores a través de CLI.
    Consulte las páginas :doc:`spark_commands` y :doc:`cli_commands` para obtener información detallada.
    información.

.. contents::
    :local:
    :depth: 2


Probémoslo: ¡Hola mundo!
************************

Crear un controlador
====================

Creemos un controlador simple para que puedas verlo en acción. Usando tu
editor de texto, cree un archivo llamado Tools.php y coloque el siguiente código
en eso:

.. literalinclude:: cli_controllers/001.php

.. note:: If you use :ref:`auto-routing-improved`, change the method name to ``cliMessage()``.

Luego guarde el archivo en su directorio **app/Controllers/**.

Definir una ruta
================

Si utiliza el enrutamiento automático, omita esto.

En su archivo **app/Config/Routes.php** puede crear rutas a las que solo se puede acceder desde
CLI tan fácilmente como crearía cualquier otra ruta. En lugar de utilizar ``get()``,
``post()``, o un método similar, usarías el método ``cli()``. Todo lo demas
funciona exactamente como una definición de ruta normal:

.. literalinclude:: cli_controllers/002.php

Para obtener más información, consulte :ref:`Rutas<command-line-only-routes>` página.

.. warning:: If you enable :ref:`auto-routing-legacy` and place the command file in **app/Controllers**,
    cualquiera podría acceder al comando con la ayuda de :ref:`auto-routing-legacy` a través de HTTP.

Ejecutar a través de CLI
========================

Ahora normalmente visitarías tu sitio usando una URL similar a esta::

    ejemplo.com/index.php/tools/message/to

En su lugar, abriremos Terminal en Mac/Linux o iremos a Ejecutar > "cmd"
en Windows y navegue hasta la raíz web de nuestro proyecto Higgs.

.. code-block:: bash

    $ cd /ruta/al/proyecto/público
    $ php index.php mensaje de herramientas

Si lo hiciste bien, deberías ver "¡Hola mundo!" impreso.

.. code-block:: bash

    $ php index.php herramientas mensaje "John Smith"

Aquí le pasamos un argumento de la misma manera que los parámetros de URL
trabajar. "John Smith" se pasa como argumento y el resultado es::

    ¡Hola Juan Smith!


¡Eso es lo básico!
******************

Esto, en pocas palabras, es todo lo que hay que saber sobre los controladores en el
línea de comando. Recuerde que este es sólo un controlador normal, por lo que el enrutamiento
y ``_remap()`` funciona bien.

.. note:: ``_remap()`` does not work with :ref:`auto-routing-improved`.

Si desea asegurarse de ejecutar a través de CLI, verifique el valor de retorno de :php:func:`is_cli()`.

Sin embargo, Higgs proporciona herramientas adicionales para que la creación sea accesible mediante CLI.
scripts aún más agradables, incluyen enrutamiento solo CLI y una biblioteca que ayuda
usted con herramientas solo CLI.
