#############################
Descripción general de la CLI
#############################

Higgs proporciona el comando incorporado **spark** y una biblioteca y comandos útiles.
También puede crear comandos Spark y ejecutar controladores a través de CLI.

.. contents::
    :local:
    :depth: 2


¿Qué es la CLI?
***************

La interfaz de línea de comandos es un método basado en texto para interactuar con
ordenadores. Para obtener más información, consulte la `Wikipedia
artículo<https://en.wikipedia.org/wiki/Command-line_interface>` _.


¿Por qué ejecutar mediante la línea de comandos?
************************************************

Hay muchas razones para ejecutar Higgs desde la línea de comandos,
pero no siempre son obvios.

- Ejecute sus trabajos cron sin necesidad de usar *wget* o *curl*.
- Realizar "tareas" interactivas que puedan hacer cosas como establecer permisos,
   podar carpetas de caché, ejecutar copias de seguridad, etc.
- Integrar con otras aplicaciones en otros idiomas. Por ejemplo, un
   ¡Un script C++ aleatorio podría llamar un comando y ejecutar código en sus modelos!


Los comandos de chispa
**********************

Higgs se envía con el comando oficial **spark** y comandos integrados.

Puedes ejecutar Spark y ver la ayuda:

.. code-block:: console

    chispa php

Consulte la página :doc:`spark_commands` para obtener información detallada.


La biblioteca CLI
*****************

La biblioteca CLI simplifica el trabajo con la interfaz CLI.
Proporciona formas sencillas de enviar texto en varios colores a la ventana del terminal. También
le permite solicitar información a un usuario, lo que facilita la creación de herramientas flexibles e inteligentes.

Consulte la :doc:`Biblioteca CLI</cli/cli_library>`  página para obtener información detallada.
