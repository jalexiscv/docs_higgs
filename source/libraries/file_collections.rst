#######################
Colecciones de archivos
#######################

Trabajar con grupos de archivos puede ser engorroso, por lo que el marco proporciona la clase ``FileCollection`` para facilitar
localizar y trabajar con grupos de archivos en todo el sistema de archivos.

.. contents::
    :local:
    :depth: 2


Uso básico
**********

En su forma más básica, ``FileCollection`` es un índice
de archivos que configuras o construyes:

.. literalinclude:: files/011.php

Después de haber ingresado los archivos con los que le gustaría trabajar, puede eliminar archivos o usar los comandos de filtrado para eliminarlos.
o conservar archivos que coincidan con una determinada expresión regular o patrón de estilo global:

.. literalinclude:: files/012.php

Cuando su colección esté completa, puede usar ``get()`` para recuperar la lista final de rutas de archivos, o aprovechar
``FileCollection`` es contable e iterable para trabajar directamente con cada ``File``:

.. literalinclude:: files/013.php

A continuación se detallan los métodos específicos para trabajar con una ``FileCollection``.


Comenzar una colección
**********************

__construct(cadena[] $archivos = [])
====================================

El constructor acepta una matriz opcional de rutas de archivos para usar como colección inicial. Estos se pasan a
``add()`` para que todos los archivos proporcionados por las clases secundarias en ``$files`` permanezcan.

definir()
=========

Permite que las clases secundarias definan sus propios archivos iniciales. Este método es llamado por el constructor y permite
colecciones predefinidas sin tener que utilizar sus métodos. Ejemplo:

.. literalinclude:: files/014.php

Ahora puede usar ``ConfigCollection`` en cualquier parte de su proyecto para acceder a todos los archivos de App Config sin
tener que volver a llamar los métodos de recopilación cada vez.

establecer(matriz $archivos)
============================

Establece la lista de archivos de entrada en la matriz de cadenas de rutas de archivos proporcionada. Esto eliminará cualquier existente
archivos de la colección, por lo que ``$collection->set([])`` es esencialmente un restablecimiento completo.


Ingresando archivos
*******************

agregar(cadena[]|cadena $rutas, bool $recursivo = verdadero)
==================================================== =

Agrega todos los archivos indicados por la ruta o conjunto de rutas. Si la ruta se resuelve en un directorio, entonces ``$recursivo``
incluirá subdirectorios.

agregarArchivo(cadena $archivo) / agregarArchivos(matriz $archivos)
===================================================================

Agrega el archivo o archivos a la lista actual de archivos de entrada. Los archivos son rutas absolutas a archivos reales.

eliminarArchivo(cadena $archivo) / eliminarArchivos(matriz $archivos)
==================================================== ==

Elimina el archivo o archivos de la lista actual de archivos de entrada.

addDirectory(cadena $directorio, bool $recursivo = falso)
==================================================== ======
addDirectories(matriz $directorios, bool $recursivo = falso)
==================================================== =========

Agrega todos los archivos del directorio o directorios, opcionalmente recurriendo a subdirectorios. Los directorios son
rutas absolutas a directorios reales.


Filtrar archivos
****************

removePattern(cadena $patrón, cadena $alcance = nulo)
==================================================== ==
retenerPatrón(cadena $patrón, cadena $alcance = nulo)
==================================================== ==

Filtra la lista de archivos actual a través del patrón (y el alcance opcional), eliminando o reteniendo los coincidentes.
archivos. ``$pattern`` puede ser una expresión regular completa (como ``'#[A-Za-z]+\.php#'``) o una pseudo-expresión regular similar
a ``glob()`` (como ``*.css``).
Si se proporciona un ``$scope`` entonces sólo se considerarán los archivos dentro o debajo de ese directorio (es decir, archivos
fuera de ``$scope`` siempre se conservan). Cuando no se proporciona ningún alcance, todos los archivos están sujetos.

Ejemplos:

.. literalinclude:: files/015.php


Recuperar archivos
******************

obtener(): cadena[]
===================

Devuelve una matriz de todos los archivos de entrada cargados.

.. note:: ``FileCollection`` is an ``IteratorAggregate`` so you can work with it directly (e.g. ``foreach ($collection as $file)``).
