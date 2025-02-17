#####################
Trabajar con archivos
#####################

Higgs proporciona una clase File que envuelve el `SplFileInfo<https://www.php.net/manual/en/class.splfileinfo.php>` _ clase
y proporciona algunos métodos de conveniencia adicionales. Esta clase es la clase base para :doc:`archivos cargados</libraries/uploaded_files>`
y :doc:`imágenes</libraries/images>` .

.. contents::
    :local:
    :depth: 2

Obtener una instancia de archivo
********************************

Crea una nueva instancia de Archivo pasando la ruta al archivo en el constructor.
De forma predeterminada, no es necesario que el archivo exista. Sin embargo, puede pasar un argumento adicional de "verdadero"
para verificar que el archivo existe y lanzar ``FileNotFoundException()`` si no es así.

.. literalinclude:: files/001.php

Aprovechando el SPL
*******************

Una vez que tenga una instancia, tendrá listo todo el poder de la clase SplFileInfo, que incluye:

.. literalinclude:: files/002.php

Nuevas características
**********************

Además de todos los métodos de la clase SplFileInfo, obtienes algunas herramientas nuevas.

obtenerNombreAleatorio()
========================

Puede generar un nombre de archivo aleatorio criptográficamente seguro, con la marca de tiempo actual antepuesta, con ``getRandomName()``
método. Esto es especialmente útil para cambiar el nombre de los archivos al moverlos de modo que el nombre del archivo sea imposible de adivinar:

.. literalinclude:: files/003.php

obtenerTamaño()
===============

Devuelve el tamaño del archivo cargado en bytes:

.. literalinclude:: files/004.php

obtenerTamañoPorUnidad()
========================

Devuelve el tamaño predeterminado del archivo cargado en bytes. Puede pasar 'kb' o 'mb' como primer parámetro para obtener
los resultados en kilobytes o megabytes, respectivamente:

.. literalinclude:: files/005.php

obtenerTipoMime()
=================

Recupere el tipo de medio (tipo mime) del archivo. Utiliza métodos que se consideran lo más seguros posible al determinar
el tipo de archivo:

.. literalinclude:: files/006.php

adivinarExtensión()
===================

Intenta determinar la extensión del archivo basándose en el método confiable ``getMimeType()``. Si se desconoce el tipo de mimo,
devolverá nulo. Esta suele ser una fuente más confiable que simplemente usar la extensión proporcionada por el nombre del archivo. Usos
los valores en **app/Config/Mimes.php** para determinar la extensión:

.. literalinclude:: files/007.php

Mover archivos
==============

Cada archivo se puede mover a su nueva ubicación con el método ``move()``, apropiadamente llamado. Esto toma el directorio para moverse.
el archivo como primer parámetro:

.. literalinclude:: files/008.php

De forma predeterminada, se utilizó el nombre de archivo original. Puede especificar un nuevo nombre de archivo pasándolo como segundo parámetro:

.. literalinclude:: files/009.php

El método move() devuelve una nueva instancia de archivo para el archivo reubicado, por lo que debe capturar el resultado si el
Se necesita la ubicación resultante:

.. literalinclude:: files/010.php
