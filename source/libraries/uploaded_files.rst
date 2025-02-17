##############################
Trabajar con archivos cargados
##############################

Higgs hace que trabajar con archivos cargados a través de un formulario sea mucho más simple y seguro que usar ``$_FILES`` de PHP
matriz directamente. Esto extiende la clase :doc:`File</libraries/files>`  y así obtiene todas las características de esa clase.

.. note:: This is not the same as the File Uploading class in Higgs v3.x. This provides a raw
    Interfaz para los archivos cargados con algunas características pequeñas.

.. contents::
    :local:
    :depth: 2


El proceso
**********

Cargar un archivo implica el siguiente proceso general:

- Se muestra un formulario de carga, que permite al usuario seleccionar un archivo y
   subirlo.
- Cuando se envía el formulario, el archivo se carga en el destino.
   tu específicas.
- A lo largo del camino, el archivo se valida para garantizar que se permita su
   cargado según las preferencias que establezca.
- Una vez subido, al usuario se le mostrará un mensaje de éxito.

Para demostrar este proceso aquí hay un breve tutorial. Después podrás
encontrar información de referencia.

Creando el formulario de carga
==============================

Usando un editor de texto, cree un formulario llamado **upload_form.php**. En él, coloque
este código y guárdelo en su directorio **app/Views/**:

.. literalinclude:: uploaded_files/001.php

Notarás que estamos usando un asistente de formulario para crear la etiqueta de apertura del formulario.
Las cargas de archivos requieren un formulario de varias partes, por lo que el asistente crea el formulario adecuado.
sintaxis para usted. También notarás que tenemos una variable ``$errors``. Esto es
para que podamos mostrar mensajes de error en caso de que el usuario haga algo
equivocado.

La página del éxito
===================

Usando un editor de texto, cree un formulario llamado **upload_success.php**. En eso,
coloque este código y guárdelo en su directorio **app/Views/**::

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Cargar formulario</title>
    </head>
    <body>

    <h3>¡Su archivo se cargó exitosamente!</h3>

    <ul>
        <li>nombre:<?= esc($uploaded_fileinfo-> obtenerNombreBase()) ?></li>
        <li>tamaño:<?= esc($uploaded_fileinfo-> getSizeByUnit('kb')) ?> KB</li>
        <li>extensión:<?= esc($uploaded_fileinfo-> SupongoExtensión()) ?></li>
    </ul>

    <p><?= anchor('upload', 'Upload Another File!') ?></p>

    </body>
    </html>

El controlador
==============

Usando un editor de texto, cree un controlador llamado **Upload.php**. En él, coloque
este código y guárdelo en su directorio **app/Controllers/**:

.. literalinclude:: uploaded_files/002.php

.. note:: Since the value of a file upload HTML field doesn't exist, and is stored in the ``$_FILES`` global,
    Sólo :ref:`rules-for-file-uploads` se puede utilizar para validar el archivo cargado con :doc:`validation`.
    La regla ``required`` tampoco se puede usar, así que use ``uploaded`` en su lugar.

Las Rutas
=========

Usando un editor de texto, abra **app/Config/Routes.php**. En él, agregue las siguientes dos rutas:

.. literalinclude:: uploaded_files/021.php

El directorio de carga
======================

Los archivos cargados se almacenan en el directorio **writable/uploads/**.

¡Intentalo!
===========

Para probar su formulario, visite su sitio usando una URL similar a esta::

    ejemplo.com/index.php/upload/

Deberías ver un formulario de carga. Intente cargar un archivo de imagen (ya sea un
**jpg**, **gif**, **png** o **webp**). Si la ruta en su controlador es correcta, debería
trabajar.

.. _uploaded-files-accessing-files:


Accediendo a archivos
*********************

Todos los archivos
==================

Cuando subes archivos, se puede acceder a ellos de forma nativa en PHP a través del superglobal ``$_FILES``. Esta matriz tiene algunos
importantes deficiencias al trabajar con varios archivos cargados a la vez, y tiene posibles fallos de seguridad para muchos desarrolladores
no son conscientes de. Higgs ayuda con ambas situaciones al estandarizar el uso de archivos detrás de un
interfaz común.

Se accede a los archivos a través de la instancia actual ``IncomingRequest``. Para recuperar todos los archivos que se cargaron con este
solicitud, utilice ``getFiles()``. Esto devolverá una matriz de archivos representados por instancias de ``Higgs\HTTP\Files\UploadedFile``:

.. literalinclude:: uploaded_files/003.php

Por supuesto, hay varias formas de nombrar la entrada del archivo, y cualquier cosa que no sea la más simple puede generar resultados extraños.
La matriz regresa de la manera esperada. Con el uso más simple, se podría enviar un solo archivo como:

    <input type="file" name="avatar">

Lo que devolvería una matriz simple como::

    [
        'avatar' => // Instancia de archivo cargado,
    ];

.. note:: The UploadedFile instance corresponds to ``$_FILES``. Even if a user just clicks the submit button and does not upload any file, the instance will still exist. You can check that the file was actually uploaded by the ``isValid()`` method in UploadedFile. See :ref:`verify-a-file`.

Si usó una notación de matriz para el nombre, la entrada se vería así:

    <input type="file" name="my-form[details][avatar]">

La matriz devuelta por ``getFiles()`` se parecería más a esto::

    [
         'mi-formulario' => [
            'detalles' => [
                'avatar' => // instancia de archivo subido
            ],
        ],
    ]


En algunos casos, puede especificar una serie de archivos para cargar::

    Sube un avatar:<input type="file" name="my-form[details][avatars][]">
    Sube un avatar:<input type="file" name="my-form[details][avatars][]">

En este caso, la matriz de archivos devuelta sería más parecida a::

    [
        'mi-formulario' => [
            'detalles' => [
                'avatar' => [
                    0 => // Instancia de archivo cargado,
                    1 => // Instancia de archivo cargado,
                ],
            ],
        ],
    ]

Fila india
==========

Si sólo necesita acceder a un único archivo, puede utilizar ``getFile()`` para recuperar la instancia del archivo directamente. Esto devolverá una instancia de ``Higgs\HTTP\Files\UploadedFile``:

Uso más simple
--------------

Con el uso más simple, se podría enviar un solo archivo como:

    <input type="file" name="userfile">

Lo que devolvería una instancia de archivo simple como:

.. literalinclude:: uploaded_files/004.php

Notación de matriz
--------------

Si usó una notación de matriz para el nombre, la entrada se vería así:

    <input type="file" name="my-form[details][avatar]">

Para obtener la instancia del archivo:

.. literalinclude:: uploaded_files/005.php

Varios archivos
===============

::

    <input type="file" name="images[]" multiple>

En controlador:

.. literalinclude:: uploaded_files/006.php

donde ``imágenes`` es un bucle desde el nombre del campo del formulario.

Si hay varios archivos con el mismo nombre, puede utilizar ``getFile()`` para recuperar cada archivo individualmente.

En controlador:

.. literalinclude:: uploaded_files/007.php

Puede que le resulte más fácil utilizar ``getFileMultiple()`` para obtener una serie de archivos cargados con el mismo nombre:

.. literalinclude:: uploaded_files/008.php

Otro ejemplo::

    Sube un avatar:<input type="file" name="my-form[details][avatars][]">
    Sube un avatar:<input type="file" name="my-form[details][avatars][]">

En controlador:

.. literalinclude:: uploaded_files/009.php

.. note:: Using ``getFiles()`` is more appropriate.


Trabajar con el archivo
***********************

Una vez que haya recuperado la instancia de UploadedFile, podrá recuperar información sobre el archivo de forma segura, así como
mueva el archivo a una nueva ubicación.

.. _verify-a-file:

Verificar un archivo
====================

Puedes comprobar que un archivo se cargó realmente a través de HTTP sin errores llamando al método ``isValid()``:

.. literalinclude:: uploaded_files/010.php

Como se ve en este ejemplo, si un archivo tuvo un error de carga, puede recuperar el código de error (un número entero) y el error
mensaje con los métodos ``getError()`` y ``getErrorString()``. Los siguientes errores se pueden descubrir a través de
este método:

* El archivo excede su directiva ini ``upload_max_filesize``.
* El archivo excede el límite de carga definido en su formulario.
* El archivo se cargó solo parcialmente.
* Ningun archivo fue subido.
* El archivo no se pudo escribir en el disco.
* No se pudo cargar el archivo: falta el directorio temporal.
* La carga del archivo fue detenida por una extensión PHP.

Nombres de archivos
===================

obtenerNombre()
---------

Puede recuperar el nombre de archivo original proporcionado por el cliente con el método ``getName()``. Este será normalmente el
nombre de archivo enviado por el cliente y no debe ser confiable. Si el archivo se ha movido, esto devolverá el nombre final de
el archivo movido:

.. literalinclude:: uploaded_files/011.php

obtenerNombreCliente()
---------------

Siempre devuelve el nombre original del archivo cargado tal como lo envió el cliente, incluso si el archivo se ha movido:

.. literalinclude:: uploaded_files/012.php

getTempName()
-------------

Para obtener la ruta completa del archivo temporal que se creó durante la carga, puede utilizar el método ``getTempName()``:

.. literalinclude:: uploaded_files/013.php

Otra información del archivo
============================

obtenerExtensiónCliente()
--------------------

Devuelve la extensión del archivo original, según el nombre del archivo que se cargó:

.. literalinclude:: uploaded_files/014.php

.. warning:: This is NOT a trusted source. For a trusted version, use ``guessExtension()`` instead.

getClientMimeType()
-------------------

Devuelve el tipo mime (tipo mime) del archivo proporcionado por el cliente. Este NO es un valor confiable. Para un confiable
versión, use ``getMimeType()`` en su lugar:

.. literalinclude:: uploaded_files/015.php

obtenerRutaCliente()
---------------

.. versionadded:: 4.4.0

Devuelve la ruta relativa del `webkit<https://developer.mozilla.org/en-US/docs/Web/API/File/webkitRelativePath>` _ del archivo cargado cuando el cliente ha subido archivos mediante la carga del directorio.
En versiones de PHP inferiores a 8.1, esto devuelve ``nulo``

.. literalinclude:: uploaded_files/023.php

Mover archivos
==============

con nombre de archivo original
----------------------

Cada archivo se puede mover a su nueva ubicación con el método ``move()``, apropiadamente llamado. Esto toma el directorio para moverse.
el archivo como primer parámetro:

.. literalinclude:: uploaded_files/016.php

De forma predeterminada, se utilizó el nombre de archivo original.

con nuevo nombre de archivo
-----------------

Puede especificar un nuevo nombre de archivo pasándolo como segundo parámetro:

.. literalinclude:: uploaded_files/017.php

Sobrescribir archivo existente
-------------------------

De forma predeterminada, si el archivo de destino ya existe, se utilizará un nuevo nombre de archivo.
Por ejemplo, si **nombre_imagen.jpg** ya existe en el directorio, entonces el
El nombre del archivo será **nombre_imagen_1.jpg** automáticamente.

Puede sobrescribir el archivo existente pasando ``true``
como tercer parámetro:

.. literalinclude:: uploaded_files/022.php

Compruebe si el archivo se movió
-----------------------

Una vez que se ha eliminado el archivo, se elimina el archivo temporal. Puedes comprobar si un archivo ya se ha movido con
el método ``hasMoved()``, que devuelve un valor booleano:

.. literalinclude:: uploaded_files/018.php

Cuando la mudanza falla
-----------------

Mover un archivo cargado puede fallar, con una excepción HTTP, en varias circunstancias:

- el archivo ya ha sido movido
- el archivo no se cargó correctamente
- la operación de movimiento de archivos falla (por ejemplo, permisos inadecuados)

Almacenar archivos
==================

Cada archivo se puede mover a su nueva ubicación con el método ``store()``, apropiadamente llamado.

Con el uso más simple, se podría enviar un solo archivo como:

    <input type="file" name="userfile">

De forma predeterminada, los archivos cargados se guardan en el directorio **escribible/cargas**. La carpeta **AAAAMMDD**
y se creará un nombre de archivo aleatorio. Devuelve una ruta de archivo:

.. literalinclude:: uploaded_files/019.php

Puede especificar un directorio al que mover el archivo como primer parámetro. Un nuevo nombre de archivo por
pasándolo como segundo parámetro:

.. literalinclude:: uploaded_files/020.php

Mover un archivo cargado puede fallar, con una ``HTTPException``, en varias circunstancias:

- el archivo ya ha sido movido
- el archivo no se cargó correctamente
- la operación de movimiento de archivos falla (por ejemplo, permisos inadecuados)
