######################################
Controlador de almacenamiento en caché
######################################

Higgs incluye envoltorios de algunas de las formas más populares de
Almacenamiento en caché rápido y dinámico. Todos, excepto el almacenamiento en caché basado en archivos, requieren
requisitos del servidor y se generará una excepción fatal si el servidor
no se cumplen los requisitos.

.. contents::
    :local:
    :depth: 2


Uso de ejemplo
**************

El siguiente ejemplo muestra un patrón de uso común dentro de sus controladores.

.. literalinclude:: caching/001.php

Puede obtener una instancia del motor de caché directamente a través de la clase Servicios:

.. literalinclude:: caching/002.php

.. _libraries-caching-configuring-the-cache:


Configurando el caché
*********************

Toda la configuración del motor de caché se realiza en **app/Config/Cache.php**. En ese archivo,
Los siguientes artículos están disponibles.

$ controlador
=============

Es el nombre del controlador que debe usarse como controlador principal al arrancar el motor.
Los nombres disponibles son: dummy, file, memcached, redis, predis, wincache.

$backupHandler
==============

En el caso de que la primera opción ``$handler`` no esté disponible, este será el siguiente controlador de caché que se cargará.
Este es comúnmente el controlador ``File`` ya que el sistema de archivos siempre está disponible, pero puede no encajar.
configuraciones más complejas de múltiples servidores.

$prefijo
========

Si tiene más de una aplicación usando el mismo almacenamiento de caché, puede agregar un prefijo personalizado
cadena aquí que se antepone a todos los nombres de clave.

$ttl
====

El número predeterminado de segundos para guardar elementos cuando no se especifica ninguno.

ADVERTENCIA: Esto no lo utilizan los controladores de marco donde 60 segundos están codificados, pero puede ser útil
a proyectos y módulos. Esto reemplazará el valor codificado en una versión futura.

$archivo
========

Esta es una serie de configuraciones específicas del controlador ``Archivo`` para determinar cómo se deben guardar los archivos de caché.

$memcached
==========

Este es un conjunto de servidores que se utilizarán cuando se utilice el controlador ``Memcache(d)``.

$redis
======

La configuración para el servidor Redis que desea utilizar cuando utiliza el controlador ``Redis`` y ``Predis``.


Herramientas de línea de comandos
*********************************

Higgs se envía con varios :doc:`comandos</cli/spark_commands>` que están disponibles
desde la línea de comando para ayudarle a trabajar con Cache.
Estas herramientas no son necesarias para utilizar el controlador de caché, pero pueden resultarle útiles.

caché: borrar
=============

Borra las cachés del sistema actual:

.. code-block:: console

    caché de chispa de php: borrar

caché: información
==================

Muestra información de caché de archivos en el sistema actual:

.. code-block:: console

    caché de chispa php: información

.. note:: This command only supports the File cache handler.


Referencia de clase
*******************

.. php:namespace:: Higgs\Cache

.. php:class:: CacheInterface

    .. php:method:: isSupported()

        :devuelve: ``true`` si es compatible, ``false`` si no
        :rtype: booleano

    .. php:method:: get($key): mixed

        :param  string $key: nombre del elemento de caché
        :returns: valor del artículo o ``nulo`` si no se encuentra
        :rtype: mixto

        Este método intentará recuperar un elemento del almacén de caché. Si el
        El elemento no existe, el método devolverá nulo.

        Ejemplo:

        .. literalinclude:: caching/003.php

    .. php:method:: remember(string $key, int $ttl, Closure $callback)

        :param  string $key: nombre del elemento de caché
        :param int $ttl: Tiempo de vida en segundos
        :param Cierre $callback: Devolución de llamada para invocar cuando el elemento de caché devuelve nulo
        :returns: el valor del elemento de caché
        :rtype: mixto

        Obtiene un elemento del caché. Si se devolvió ``null``, esto invocará la devolución de llamada
        y guarda el resultado. De cualquier manera, esto devolverá el valor.

    .. php:method:: save(string $key, $data[, int $ttl = 60[, $raw = false]])

        :param  string $key: nombre del elemento de caché
        :param mixed $data: los datos a guardar
        :param int $ttl: Tiempo de vida, en segundos (predeterminado 60)
        :param bool $raw: si se debe almacenar el valor bruto
        :returns: ``true`` en caso de éxito, ``false`` en caso de error
        :rtype: booleano

        Este método guardará un elemento en el almacén de caché. Si el guardado falla, el
        El método devolverá ``false``.

        Ejemplo:

        .. literalinclude:: caching/004.php

        .. note:: The ``$raw`` parameter is only utilized by Memcache,
            para permitir el uso de ``increment()`` y ``decrement()``.

    .. php:method:: delete($key): bool

        :param  string $key: nombre del elemento almacenado en caché
        :returns: ``true`` en caso de éxito, ``false`` en caso de error
        :rtype: booleano

        Este método eliminará un elemento específico del almacén de caché. Si el artículo
        la eliminación falla, el método devolverá falso.

        Ejemplo:

        .. literalinclude:: caching/005.php

    .. php:method:: deleteMatching($pattern): integer

        :param string $pattern: patrón de estilo global para que coincida con las claves de los elementos almacenados en caché
        :returns: número de elementos eliminados
        :rtype: entero

        Este método eliminará varios elementos del almacén de caché a la vez
        haciendo coincidir sus claves con un patrón de estilo globo. Devolverá el número total de elementos eliminados.

        .. important:: This method is only implemented for File, Redis and Predis handlers.
            Debido a limitaciones, no se pudo implementar para los controladores de Memcached y Wincache.

        Ejemplo:

        .. literalinclude:: caching/006.php

        Para obtener más información sobre la sintaxis de estilo glob, consulte
        `Glob (programación)<https://en.wikipedia.org/wiki/Glob_(programming)#Syntax>` _.

    .. php:method:: increment($key[, $offset = 1]): mixed

        :param  string $clave: ID de caché
        :param int $offset: Paso/valor a agregar
        :returns: Nuevo valor en caso de éxito, ``false`` en caso de error
        :rtype: mixto

        Realiza un incremento atómico de un valor almacenado sin procesar.

        Ejemplo:

        .. literalinclude:: caching/007.php

    .. php:method:: decrement($key[, $offset = 1]): mixed

        :param  string $clave: ID de caché
        :param int $offset: Paso/valor a reducir
        :returns: Nuevo valor en caso de éxito, ``false`` en caso de error
        :rtype: mixto

        Realiza una disminución atómica de un valor almacenado sin procesar.

        Ejemplo:

        .. literalinclude:: caching/008.php

    .. php:method:: clean()

        :returns: ``true`` en caso de éxito, ``false`` en caso de error
        :rtype: booleano

        Este método "limpiará" todo el caché. Si la eliminación del
        Los archivos de caché fallan, el método devolverá falso.

        Ejemplo:

        .. literalinclude:: caching/009.php

    .. php:method:: getCacheInfo()

        :returns: información sobre toda la base de datos de caché
        :rtype: mixto

        Este método devolverá información sobre todo el caché.

        Ejemplo:

        .. literalinclude:: caching/010.php

        .. note:: The information returned and the structure of the data is dependent
            en qué adaptador se está utilizando.

    .. php:method:: getMetadata(string $key)

        :param  string $key: nombre del elemento de caché
        :returns: metadatos del elemento almacenado en caché. ``null`` para elementos faltantes, o una matriz con al menos la clave "caducar" para una época de vencimiento absoluta (``null`` para nunca caduca).
        :rtype: matriz|nulo

        Este método devolverá información detallada sobre un elemento específico en el
        cache.

        Ejemplo:

        .. literalinclude:: caching/011.php

        .. note:: The information returned and the structure of the data is dependent
              en qué adaptador se está utilizando. Algunos adaptadores (Archivo, Memcached, Wincache)
              aún devuelve "falso" para los elementos faltantes.

    .. php:staticmethod:: validateKey(string $key, string $prefix)

        :param  string $key: clave de caché potencial
        :param  string $prefijo: Prefijo opcional
        :returns: La clave verificada y con prefijo. Si la clave excede la longitud máxima de clave del controlador, se aplicará un hash.
        :rtype: cadena

        Este método lo utilizan los métodos del controlador para comprobar que las claves son válidas. tirará
        una ``InvalidArgumentException`` para caracteres que no son cadenas, no válidos y longitudes vacías.

        Ejemplo:

        .. literalinclude:: caching/012.php


Conductores
***********

Almacenamiento en caché basado en archivos
==========================================

A diferencia del almacenamiento en caché de la clase de salida, el almacenamiento en caché basado en archivos del controlador
permite almacenar en caché partes de los archivos de visualización. Úselo con cuidado y
asegúrese de comparar su aplicación, ya que puede llegar un punto en el que el disco
La E/S anulará las ganancias positivas mediante el almacenamiento en caché. Esto requiere un caché
directorio para que la aplicación realmente pueda escribirlo.

Almacenamiento en caché de Memcached
====================================

Los servidores Memcached se pueden especificar en el archivo de configuración de caché. Las opciones disponibles son:

.. literalinclude:: caching/013.php

Para obtener más información sobre Memcached, consulte
`https://www.php.net/memcached<https://www.php.net/memcached>` _.

Almacenamiento en caché de WinCache
===================================

En Windows, también puede utilizar el controlador WinCache.

Para obtener más información sobre WinCache, consulte
`https://www.php.net/wincache<https://www.php.net/wincache>` _.

Almacenamiento en caché de Redis
================================

Redis es un almacén de valores clave en memoria que puede funcionar en modo caché LRU.
Para usarlo, necesita el `servidor Redis y la extensión PHP phpredis<https://github.com/phpredis/phpredis>` _.

Opciones de configuración para conectarse al servidor Redis almacenado en el archivo de configuración de caché. Las opciones disponibles son:

.. literalinclude:: caching/014.php

Para obtener más información sobre Redis, consulte
`https://redis.io<https://redis.io>` _.

Predios Caching
===============

Predis es una biblioteca cliente PHP flexible y con todas las funciones para el almacén clave-valor de Redis.
Para usarlo, desde la línea de comando dentro de la raíz de tu proyecto:

.. code-block:: console

    composer require predios/predios

Para obtener más información sobre Redis, consulte
`https://github.com/nrk/predis<https://github.com/nrk/predis>` _.

Caché ficticia
==============

Este es un backend de almacenamiento en caché que siempre "fallará". No almacena datos,
pero le permite mantener su código de almacenamiento en caché en entornos que no lo hacen
admite el caché elegido.
