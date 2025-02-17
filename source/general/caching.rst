######################################
Almacenamiento en caché de páginas web
######################################

Higgs te permite almacenar en caché tus páginas para lograr el máximo
actuación.

Aunque Higgs es bastante rápido, la cantidad de información dinámica
que muestra en sus páginas se correlacionará directamente con el servidor
recursos, memoria y ciclos de procesamiento utilizados, que afectan su
velocidades de carga de la página. Al almacenar en caché sus páginas, ya que se guardan en su
estado completamente renderizado, puede lograr un rendimiento mucho más cercano al de
páginas web estáticas.

.. contents::
    :local:
    :depth: 2

¿Cómo funciona el almacenamiento en caché?
==========================================

El almacenamiento en caché se puede habilitar por página y puede establecer la longitud
de tiempo que una página debe permanecer almacenada en caché antes de ser actualizada. Cuando un
La página se carga por primera vez, la página se almacenará en caché utilizando el
motor de caché actualmente configurado. En cargas de páginas posteriores, el caché
será recuperado y enviado al navegador del usuario solicitante. si tiene
caducado, se eliminará y actualizará antes de enviarse al
navegador.

.. note:: The Benchmark tag is not cached so you can still view your page
    velocidad de carga cuando el almacenamiento en caché está habilitado.

Configurar el almacenamiento en caché
=====================================

Configuración del motor de caché
--------------------

Antes de utilizar el almacenamiento en caché de páginas web, debe configurar el motor de caché editando
**aplicación/Config/Cache.php**. Ver :ref:`bibliotecas-almacenamiento-en-caché-configuración-de-la-caché`
para detalles.

Configuración de $cacheQueryString
-------------------------

Puede establecer si desea incluir o no la cadena de consulta al generar el caché
con ``Config\Cache::$cacheQueryString``.

Las opciones válidas son:

- ``false``: (predeterminado) Deshabilitado. La cadena de consulta no se tiene en cuenta; el
  Se devuelve el mismo caché para solicitudes con la misma ruta URI pero consulta diferente
  instrumentos de cuerda.
- ``true``: Habilitado, tiene en cuenta todos los parámetros de consulta. Tenga en cuenta que esto
  puede resultar en numerosos cachés generados para la misma página una y otra vez
  de nuevo.
- **array**: Habilitado, pero solo tiene en cuenta la lista de consultas especificada
  parámetros. Por ejemplo, ``['q', 'página']``.

Habilitar el almacenamiento en caché
====================================

Para habilitar el almacenamiento en caché, coloque la siguiente etiqueta en cualquiera de sus controladores
métodos:

.. literalinclude:: caching/001.php

Donde ``$n`` es el número de **segundos** que desea que permanezca la página
almacenado en caché entre actualizaciones.

La etiqueta anterior puede ir a cualquier lugar dentro de un método. No se ve afectado por
el orden en que aparece, así que colóquelo donde le parezca más lógico
tú. Una vez que la etiqueta esté colocada, sus páginas comenzarán a almacenarse en caché.

.. important:: If you change configuration options that might affect
    su salida, debe eliminar manualmente su caché.

Eliminar cachés
===============

Si ya no desea almacenar en caché una página, puede eliminar la etiqueta de almacenamiento en caché y
ya no se actualizará cuando caduque.

.. note:: Removing the tag will not delete the cache immediately. It will
    tiene que expirar normalmente.
