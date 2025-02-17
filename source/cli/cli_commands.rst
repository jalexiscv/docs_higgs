####################
Crear comandos Spark
####################

Si bien la capacidad de utilizar controladores a través de CLI como cualquier otra ruta es conveniente, es posible que encuentres ocasiones en las que
Necesito algo diferente. Ahí es donde entran los comandos de Spark. Son clases simples que no
Es necesario tener rutas definidas, lo que las hace perfectas para crear herramientas que los desarrolladores puedan usar para crear
simplificar sus trabajos, ya sea manejando migraciones o inicialización de bases de datos, verificando el estado de cronjobs o incluso
Creación de generadores de códigos personalizados para su empresa.

.. contents::
    :local:
    :depth: 2


Crear nuevos comandos
*********************

Puede crear muy fácilmente nuevos comandos para utilizarlos en su propio desarrollo. Cada clase debe estar en su propio archivo,
y debe extender ``Higgs\CLI\BaseCommand`` e implementar el método ``run()``.

Se deben utilizar las siguientes propiedades para aparecer en los comandos CLI y agregar funcionalidad de ayuda a su comando:

* ``$group``: una cadena para describir el grupo en el que se agrupa el comando al enumerar comandos. Por ejemplo: ``Base de datos``
* ``$name``: una cadena para describir el nombre del comando. Por ejemplo: ``hacer:controlador``
* ``$descripción``: una cadena para describir el comando. Por ejemplo: ``Genera un nuevo archivo de controlador.``
* ``$usage``: una cadena para describir el uso del comando. Por ejemplo: ``hacer:controlador<name> [opciones]``
* ``$argumentos``: una matriz de cadenas para describir cada argumento del comando. Por ejemplo: ``'nombre' => 'El nombre de la clase del controlador.'``
* ``$opciones``: una matriz de cadenas para describir cada opción de comando. Por ejemplo: ``'--force' => 'Forzar sobrescritura de archivo existente.'``

**La descripción de ayuda se generará automáticamente según los parámetros anteriores.**

Ubicación del archivo
=====================

Los comandos deben almacenarse dentro de un directorio llamado **Comandos**. Sin embargo, ese directorio debe estar ubicado en los espacios de nombres PSR-4.
para que el :doc:`Autocargador</concepts/autoloader>` puede localizarlo. Esto podría estar en **aplicación/Comandos**, o
un directorio en el que guarda los comandos para utilizarlos en todo el desarrollo de su proyecto, como **Acme/Commands**.

.. note:: When the commands are executed, the full Higgs CLI environment has been loaded, making it
 Es posible obtener información del entorno, información de ruta y utilizar cualquiera de las herramientas que utilizaría al crear un controlador.

Un comando de ejemplo
=====================

Veamos un comando de ejemplo cuya única función es informar información básica sobre la aplicación.
en sí, con fines de demostración. Comience creando un nuevo archivo en **app/Commands/AppInfo.php**. Él
debe contener el siguiente código:

.. literalinclude:: cli_commands/002.php

Si ejecuta el comando **list**, verá el nuevo comando listado en su propio grupo ``Demo``. Si lo tomas
Si lo miras de cerca, deberías ver cómo esto funciona con bastante facilidad. La propiedad ``$group`` simplemente le dice cómo organizar
este comando con todos los demás comandos que existen, indicándole en qué título incluirlo.

La propiedad ``$name`` es el nombre con el que se puede llamar a este comando. El único requisito es que no contenga
un espacio y todos los caracteres deben ser válidos en la propia línea de comando. Sin embargo, por convención, los comandos están en minúsculas,
y la agrupación adicional de comandos se realiza mediante el uso de dos puntos con el nombre del comando en sí. Esto ayuda a mantener
múltiples comandos tengan colisiones de nombres.

La propiedad final, ``$description`` es una cadena corta que se muestra en el comando **list** y debe describir
lo que hace el comando.

correr()
-----

El método ``run()`` es el método que se llama cuando se ejecuta el comando. La matriz ``$params`` es una lista de
cualquier argumento de CLI después del nombre del comando para su uso. Si la cadena CLI fuera:

.. code-block:: console

    php chispa foo bar baz

Entonces **foo** es el nombre del comando, y la matriz ``$params`` sería:

.. literalinclude:: cli_commands/003.php

También se puede acceder a esto a través de :doc:`CLI </cli/cli_library>`biblioteca, pero ya se ha eliminado su comando
de la cuerda. Estos parámetros se pueden utilizar para personalizar el comportamiento de sus scripts.

Nuestro comando de demostración podría tener un método ``run()`` similar a:

.. literalinclude:: cli_commands/004.php

Consulte la :doc:`Biblioteca CLI</cli/cli_library>`  página para obtener información detallada.

Terminación del comando
-----------------------

De forma predeterminada, el comando sale con un código de éxito de ``0``. Si se encuentra un error al ejecutar un comando,
puedes terminar el comando usando la construcción del lenguaje ``return`` con un código de salida en el método ``run()``.

Por ejemplo, ``devuelve EXIT_ERROR;``

Este enfoque puede ayudar con la depuración a nivel del sistema, si el comando, por ejemplo, se ejecuta mediante crontab.

Puede utilizar las constantes del código de salida ``EXIT_*`` definidas en el archivo **app/Config/Constants.php**.


Comando base
************

La clase ``BaseCommand`` que todos los comandos deben extender tiene un par de métodos de utilidad útiles que usted debe
familiarícese al crear sus propios comandos. También tiene un :doc:`Logger </general/logging>` disponible en
``$this->logger``.

.. php:namespace:: Higgs\CLI

.. php:class:: BaseCommand

    .. php:method:: call(string $command[, array $params = []])

        :param  string $comando: el nombre de otro comando al que llamar.
        :param array $params: Argumentos CLI adicionales para poner a disposición de ese comando.

        Este método le permite ejecutar otros comandos durante la ejecución de su comando actual:

        .. literalinclude:: cli_commands/005.php

    .. php:method:: showError(Throwable $e)

        :param Throwable $e: la excepción que se utilizará para informar errores.

        Un método conveniente para mantener una salida de error clara y consistente a la CLI:

        .. literalinclude:: cli_commands/006.php

    .. php:method:: showHelp()

        Un método para mostrar la ayuda del comando: (uso, argumentos, descripción, opciones)

    .. php:method:: setPad(string $item, int $max, int $extra = 2, int $indent = 0): string

        :param string $item: el elemento de cadena.
        :param entero $max: El tamaño máximo.
        :param integer $extra: cuántos espacios adicionales agregar al final.
        :param entero $indent: Los espacios de sangría.

        Rellena nuestra cadena para que todos los títulos tengan la misma longitud para alinear bien
        descripciones arriba:

        .. literalinclude:: cli_commands/007.php
            :lines: 2-

    .. php:method:: getPad($array, $pad)

        .. deprecated:: 7.0.5
            Utilice :php:meth:`Higgs\\CLI\\BaseCommand::setPad()` en su lugar.

        :param array $array: La matriz $key => $value.
        :param entero $pad: Los espacios del pad.

        Un método para calcular el relleno para la salida de la matriz ``$key => $value``. El relleno se puede utilizar para generar una tabla formateada en CLI.
