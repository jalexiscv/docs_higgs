######
Editor
######

La biblioteca de Publisher proporciona un medio para copiar archivos dentro de un proyecto mediante una sólida detección y comprobación de errores.

.. contents::
    :local:
    :depth: 2


Cargando la biblioteca
**********************

Debido a que las instancias de Publisher son específicas de su origen y destino, esta biblioteca no está disponible
a través de ``Servicios`` pero debe crearse una instancia o extenderse directamente. P.ej:

.. literalinclude:: publisher/001.php


Concepto y uso
**************

``Publisher`` resuelve algunos problemas comunes cuando se trabaja dentro de un marco backend:

* ¿Cómo mantengo los activos del proyecto con dependencias de versión?
* ¿Cómo administro las cargas y otros archivos "dinámicos" que deben ser accesibles desde la web?
* ¿Cómo puedo actualizar mi proyecto cuando cambian el marco o los módulos?
* ¿Cómo pueden los componentes inyectar contenido nuevo en proyectos existentes?

En su forma más básica, publicar equivale a copiar un archivo o archivos en un proyecto. ``Publisher`` extiende ``FileCollection``
para implementar un encadenamiento de comandos de estilo fluido para leer, filtrar y procesar archivos de entrada, luego copiarlos o fusionarlos en el destino de destino.
Puede utilizar ``Publisher`` a pedido en sus Controladores u otros componentes, o puede organizar publicaciones extendiendo
la clase y aprovechar su descubrimiento con ``spark Publish``.

Bajo demanda
============

Acceda a ``Publisher`` directamente creando una instancia nueva de la clase:

.. literalinclude:: publisher/002.php

De forma predeterminada, el origen y el destino se establecerán en ``ROOTPATH`` y ``FCPATH`` respectivamente, lo que dará como resultado ``Publisher``.
Fácil acceso para tomar cualquier archivo de su proyecto y hacerlo accesible desde la web. Alternativamente, puedes pasar una nueva fuente.
o origen y destino en el constructor:

.. literalinclude:: publisher/003.php

Una vez que todos los archivos estén preparados, utilice uno de los comandos de salida (**copiar()** o **merge()**) para procesar los archivos preparados.
a su(s) destino(s):

.. literalinclude:: publisher/004.php

Consulte la :ref:`referencia` para obtener una descripción completa de los métodos disponibles.

Automatización y descubrimiento
===============================

Es posible que tenga tareas de publicación periódicas integradas como parte de la implementación o el mantenimiento de su aplicación. ``Editor`` aprovecha
el poderoso ``Autoloader`` para localizar cualquier clase secundaria preparada para su publicación:

.. literalinclude:: publisher/005.php

Por defecto ``discover()`` buscará el directorio "Editores" en todos los espacios de nombres, pero puedes especificar un
directorio diferente y devolverá cualquier clase secundaria encontrada:

.. literalinclude:: publisher/006.php

La mayoría de las veces no necesitarás manejar tu propio descubrimiento, simplemente usa el comando "publicar" proporcionado:

.. code-block:: console

    publicación de chispa php

De forma predeterminada, en su extensión de clase ``publish()`` agregará todos los archivos de su ``$source`` y los fusionará.
hacia su destino, sobrescribiendo en caso de colisión.

Seguridad
=========

Para evitar que los módulos inyecten código malicioso en sus proyectos, ``Publisher`` contiene un archivo de configuración
que define qué directorios y patrones de archivos están permitidos como destinos. De forma predeterminada, los archivos sólo se pueden publicar
a su proyecto (para evitar el acceso al resto del sistema de archivos), y la carpeta **public/** (``FCPATH``) solo
recibir archivos con las siguientes extensiones:

* Activos web: css, scss, js, mapa
* Archivos web no ejecutables: htm, html, xml, json, webmanifest
* Fuentes: ttf, eot, woff, woff2
* Imágenes: gif, jpg, jpeg, tif, tiff, png, webp, bmp, ico, svg

Si necesita agregar o ajustar la seguridad de su proyecto, modifique la propiedad ``$restrictions`` de ``Config\Publisher`` en **app/Config/Publisher.php**.


Ejemplos
********

A continuación se muestran algunos casos de uso de ejemplo y sus implementaciones para ayudarle a comenzar a publicar.

Ejemplo de sincronización de archivos
=====================================

Quiere mostrar una imagen de "foto del día" en su página de inicio. Tienes un feed de fotos diarias pero
Debes colocar el archivo real en una ubicación navegable de tu proyecto en **public/images/daily_photo.jpg**.
Puede configurar :doc:`Comando personalizado</cli/cli_commands>`  para ejecutar diariamente que se encargará de esto por usted:

.. literalinclude:: publisher/007.php

Ahora, ejecutar ``spark Publish:daily`` mantendrá actualizada la imagen de su página de inicio. ¿Y si la foto es?
¿Viene de una API externa? Puede utilizar ``addUri()`` en lugar de ``addPath()`` para descargar el control remoto.
recurso y publicarlo en su lugar:

.. literalinclude:: publisher/008.php

Ejemplo de dependencias de activos
==================================

Quiere integrar la biblioteca frontend "Bootstrap" en su proyecto, pero las frecuentes actualizaciones lo convierten en una molestia.
Mantén el paso. Puede crear una definición de publicación en su proyecto para sincronizar los activos de la interfaz extendiendo
``Editor`` en su proyecto. Entonces **app/Publishers/BootstrapPublisher.php** podría verse así:

.. literalinclude:: publisher/009.php

.. note:: Directory ``$destination`` must be created before executing the command.

Ahora agregue la dependencia a través de Composer y llame a ``spark Publish`` para ejecutar la publicación:

.. code-block:: console

    el compositor requiere twbs/bootstrap
    publicación de chispa php

... and you'll end up with something like this::

    public/.htaccess
    public/favicon.ico
    public/index.php
    public/robots.txt
    public/
        oreja/
            css/
                arranque.min.css
                bootstrap-utilities.min.css.map
                bootstrap-grid.min.css
                arranque.rtl.min.css
                bootstrap.min.css.map
                arranque-reinicio.min.css
                bootstrap-utilidades.min.css
                arranque-reinicio.rtl.min.css
                bootstrap-grid.min.css.map
            js/
                bootstrap.esm.min.js
                bootstrap.bundle.min.js.map
                arranque.paquete.min.js
                arranque.min.js
                bootstrap.esm.min.js.map
                bootstrap.min.js.map

Ejemplo de implementación del módulo
====================================

Quiere permitir a los desarrolladores que utilizan su popular módulo de autenticación la capacidad de ampliar el comportamiento predeterminado
de su Migración, Controlador y Modelo. Puede crear su propio comando de "publicación" de módulo para inyectar estos componentes
en una aplicación para su uso:

.. literalinclude:: publisher/010.php

Ahora, cuando los usuarios de su módulo ejecuten ``php spark auth:publish``, se les agregará lo siguiente a su proyecto::

    aplicación/Controladores/AuthController.php
    aplicación/Base de datos/Migraciones/2017-11-20-223112_create_auth_tables.php.php
    aplicación/Modelos/LoginModel.php
    aplicación/Modelos/UserModel.php

.. _reference:


Referencia de la biblioteca
***************************

.. note:: ``Publisher`` is an extension of :doc:`FileCollection </libraries/files>` so has access to all those methods for reading and filtering files.

Métodos de soporte
==================

[estático] descubrir(cadena $directorio = 'Editores'): Editor[]
-----------------------------------------------------------------

Descubre y devuelve todos los publicadores en el directorio de espacio de nombres especificado. Por ejemplo, si ambos
**app/Publishers/FrameworkPublisher.php** y **myModule/src/Publishers/AssetPublisher.php** existen y están
extensiones de ``Publisher`` entonces ``Publisher::discover()`` devolvería una instancia de cada una.

publicar(): booleano
---------------

Procesa la cadena completa de entrada-proceso-salida. Por defecto esto es el equivalente a llamar a ``addPath($source)``
y ``merge(true)`` pero las clases secundarias normalmente proporcionarán su propia implementación. ``publicar()`` se llama
en todos los editores descubiertos cuando se ejecuta ``spark Publish``.
Devuelve éxito o fracaso.

getScratch(): cadena
--------------------

Devuelve el espacio de trabajo temporal, creándolo si es necesario. Algunas operaciones utilizan almacenamiento intermedio para preparar
archivos y cambios, y esto proporciona la ruta a un directorio transitorio en el que se puede escribir y que también puede usar.

getErrors(): matriz<string, Throwable>
-------------------------------

Devuelve cualquier error de la última operación de escritura. Las claves de la matriz son los archivos que causaron el error y el
Los valores son el Throwable que fue atrapado. Utilice ``getMessage()`` en Throwable para obtener el mensaje de error.

addPath(cadena $ruta, bool $recursivo = verdadero)
---------------------------------------

Agrega todos los archivos indicados por la ruta relativa. La ruta es una referencia a archivos o directorios reales relativos
a ``$fuente``. Si la ruta relativa se resuelve en un directorio, entonces ``$recursivo`` incluirá subdirectorios.

addPaths(matriz $rutas, bool $recursivo = verdadero)
----------------------------------------------

Agrega todos los archivos indicados por las rutas relativas. Las rutas son referencias a archivos o directorios reales relativos
a ``$fuente``. Si la ruta relativa se resuelve en un directorio, entonces ``$recursivo`` incluirá subdirectorios.

agregarUri(cadena $uri)
-------------------

Descarga el contenido de un URI usando ``CURLRequest`` en el espacio de trabajo temporal y luego agrega el resultado.
archivo a la lista.

agregarUris(matriz $uris)
--------------------

Descarga el contenido de los URI usando ``CURLRequest`` en el espacio de trabajo temporal y luego agrega el resultado.
archivos a la lista.

.. note:: The CURL request made is a simple ``GET`` and uses the response body for the file contents. Some
    Los archivos remotos pueden necesitar una solicitud personalizada para manejarse correctamente.

Salida de archivos
==================

limpiar()
------

Elimina todos los archivos, directorios y subdirectorios de ``$destino``.

.. important:: Use wisely.

copiar(bool $reemplazar = verdadero): bool
--------------------------------

Copia todos los archivos en el ``$destino``. Esto no recrea la estructura del directorio, por lo que cada archivo
de la lista actual terminarán en el mismo directorio de destino. El uso de ``$replace`` hará que los archivos
para sobrescribir cuando ya existe un archivo. Devuelve éxito o fracaso, use ``getPublished()``
y ``getErrors()`` para solucionar fallas.
Tenga en cuenta las colisiones de nombres base duplicados, por ejemplo:

.. literalinclude:: publisher/011.php

fusionar(bool $reemplazar = verdadero): bool
---------------------------------

Copia todos los archivos en ``$destino`` en los subdirectorios relativos apropiados. Cualquier archivo que
coincidentes ``$source`` se colocarán en sus directorios equivalentes en ``$destination``, efectivamente
creando una operación "espejo" o "rsync". El uso de ``$replace`` hará que los archivos
sobrescribir cuando ya existe un archivo; dado que los directorios están fusionados, esto no
afectar a otros archivos en el destino. Devuelve éxito o fracaso, use ``getPublished()`` y
``getErrors()`` para solucionar fallas.

Ejemplo:

.. literalinclude:: publisher/012.php

.. _publisher-modifying-files:

Modificar archivos
==================

reemplazar(cadena $archivo,matriz $reemplaza): bool
--------------------------------------

.. versionadded:: 7.0.0

Reemplaza el contenido del ``$file``. El segundo parámetro de la matriz ``$replaces`` especifica las cadenas de búsqueda como claves y los reemplazos como valores.

.. literalinclude:: publisher/013.php

addLineAfter(cadena $archivo, cadena $línea, cadena $después): bool
--------------------------------------------------------------

.. versionadded:: 7.0.0

Agrega ``$line`` después de una línea con una cadena específica ``$after``.

.. literalinclude:: publisher/014.php

addLineBefore(cadena $archivo, cadena $línea, cadena $después): bool
---------------------------------------------------------------

.. versionadded:: 7.0.0

Agrega ``$line`` antes de una línea con una cadena específica ``$after``.

.. literalinclude:: publisher/015.php
