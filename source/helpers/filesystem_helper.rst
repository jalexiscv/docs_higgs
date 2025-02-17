################################
Ayudante del sistema de archivos
################################

El archivo Filesystem Helper contiene funciones que ayudan a trabajar con
archivos y directorios.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: filesystem_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: directory_map($sourceDir[, $directoryDepth = 0[, $hidden = false]])

    :param  string $sourceDir: ruta al directorio de origen
    :param int $directoryDepth: Profundidad de los directorios a recorrer (``0`` = completamente recursivo, ``1`` = directorio actual, etc.)
    :param bool $hidden: si se incluyen rutas ocultas
    :devuelve: una serie de archivos
    :rtype: matriz

    Ejemplos:

    .. literalinclude:: filesystem_helper/002.php

    .. note:: Paths are almost always relative to your main **index.php** file.

    También se asignarán las subcarpetas contenidas en el directorio. Si
    Si desea controlar la profundidad de la recursividad, puede hacerlo usando el segundo
    parámetro (entero). Una profundidad de ``1`` solo asignará el directorio de nivel superior:

    .. literalinclude:: filesystem_helper/003.php

    De forma predeterminada, los archivos ocultos no se incluirán en la matriz devuelta y
    Se omitirán los directorios ocultos. Para anular este comportamiento, puede
    establezca un tercer parámetro en "verdadero" (booleano):

    .. literalinclude:: filesystem_helper/004.php

    Cada nombre de carpeta será un índice de matriz, mientras que los archivos que contiene serán
    estar indexados numéricamente. A continuación se muestra un ejemplo de una matriz típica:

        matriz (
            [bibliotecas] => Matriz
                (
                    [0] => punto de referencia.html
                    [1] => configuración.html
                    ["base de datos/"] => Matriz
                        (
                            [0] => consulta_builder.html
                            [1] => enlaces.html
                            [2] => configuración.html
                            [3] => conectando.html
                            [4] => ejemplos.html
                            [5] => campos.html
                            [6] => índice.html
                            [7] => consultas.html
                        )
                    [2] => correo electrónico.html
                    [3] => archivo_uploading.html
                    [4] => imagen_lib.html
                    [5] => entrada.html
                    [6] => idioma.html
                    [7] => cargador.html
                    [8] => paginación.html
                    [9] => uri.html
                )
        )

    Si no se encuentran resultados, esto devolverá una matriz vacía.

.. php:function:: directory_mirror($original, $target[, $overwrite = true])

    :param  string $original: directorio fuente original
    :param  string $objetivo: directorio de destino de destino
    :param bool $overwrite: si los archivos individuales se sobrescriben en caso de colisión

    Copia recursivamente los archivos y directorios del directorio de origen.
    en el directorio de destino, es decir, "reflejar" su contenido.

    Ejemplo:

    .. literalinclude:: filesystem_helper/005.php

    Opcionalmente, puede cambiar el comportamiento de sobrescritura mediante el tercer parámetro.

.. php:function:: write_file($path, $data[, $mode = 'wb'])

    :param  string $ruta: ruta del archivo
    :param string $data: datos para escribir en el archivo
    :param  string $modo: modo ``fopen()``
    :returns: ``true`` si la escritura fue exitosa, ``false`` en caso de error
    :rtype: booleano

    Escribe datos en el archivo especificado en la ruta. Si el archivo no existe entonces el
    La función lo creará.

    Ejemplo:

    .. literalinclude:: filesystem_helper/006.php

    Opcionalmente, puede configurar el modo de escritura a través del tercer parámetro:

    .. literalinclude:: filesystem_helper/007.php

    El modo predeterminado es ``'wb'``. Por favor vea `fopen()<https://www.php.net/manual/en/function.fopen.php>` _ en el manual de PHP
    para opciones de modo.

    .. note:: In order for this function to write data to a file, its permissions must
        configurarse de modo que se pueda escribir. Si el archivo aún no existe,
        entonces el directorio que lo contiene debe poder escribirse.

    .. note:: The path is relative to your main site **index.php** file, NOT your
        controlador o ver archivos. Higgs usa un controlador frontal para que los caminos
        son siempre relativos al índice del sitio principal.

    .. note:: This function acquires an exclusive lock on the file while writing to it.

.. php:function:: delete_files($path[, $delDir = false[, $htdocs = false[, $hidden = false]]])

    :param  string $ruta: ruta del directorio
    :param bool $delDir: si también se eliminan directorios
    :param bool $htdocs: si se debe omitir la eliminación de archivos .htaccess y de páginas de índice
    :param bool $hidden: si se deben eliminar también archivos ocultos (archivos que comienzan con un punto)
    :returns: ``true`` en caso de éxito, ``false`` en caso de error
    :rtype: booleano

    Elimina TODOS los archivos contenidos en la ruta proporcionada.

    Ejemplo:

    .. literalinclude:: filesystem_helper/008.php

    Si el segundo parámetro se establece en "verdadero", cualquier directorio contenido dentro del archivo proporcionado
    La ruta raíz también se eliminará.

    Ejemplo:

    .. literalinclude:: filesystem_helper/009.php

    .. note:: The files must be writable or owned by the system in order to be deleted.

.. php:function:: get_filenames($sourceDir[, $includePath = false[, $hidden = false[, $includeDir = true]]])

    :param  string $sourceDir: ruta del directorio
    :param bool|null $includePath: si se debe incluir la ruta como parte del nombre del archivo; falso para ninguna ruta, nulo para la ruta relativa a ``$sourceDir``, verdadero para la ruta completa
    :param bool $hidden: si se incluyen archivos ocultos (archivos que comienzan con un punto)
    :param bool $includeDir: si se incluyen directorios en la salida de la matriz
    :returns: una matriz de nombres de archivos
    :rtype: matriz

    Toma una ruta del servidor como entrada y devuelve una matriz que contiene los nombres de todos los archivos.
    contenida dentro de ella. La ruta del archivo se puede agregar opcionalmente a los nombres de los archivos configurando
    el segundo parámetro a 'relativo' para rutas relativas o cualquier otro valor no vacío para
    una ruta de archivo completa.

    .. note:: Prior to v7.4.4, due to a bug, this function did not follow symlink folders.

    Ejemplo:

    .. literalinclude:: filesystem_helper/010.php

.. php:function:: get_dir_file_info($sourceDir[, $topLevelOnly = true])

    :param  string $sourceDir: ruta del directorio
    :param bool $topLevelOnly: si se debe buscar solo en el directorio especificado (excluidos los subdirectorios)
    :returns: una matriz que contiene información sobre el contenido del directorio proporcionado
    :rtype: matriz

    Lee el directorio especificado y crea una matriz que contiene los nombres de archivo, tamaño de archivo,
    fechas y permisos. Las subcarpetas contenidas dentro de la ruta especificada solo se leen
    si se fuerza enviando el segundo parámetro a falso, ya que esto puede ser un proceso intensivo
    operación.

    Ejemplo:

    .. literalinclude:: filesystem_helper/011.php

.. php:function:: get_file_info($file[, $returnedValues = ['name', 'server_path', 'size', 'date']])

    :param  string $archivo: ruta del archivo
    :param array|string $returnedValues: qué tipo de información devolver se pasará como una matriz o una cadena separada por comas
    :returns: una matriz que contiene información sobre el archivo especificado o falso en caso de error
    :rtype: matriz

    Dado un archivo y una ruta, devuelve (opcionalmente) *nombre*, *ruta*, *tamaño* y *fecha de modificación*
    atributos de información para un archivo. El segundo parámetro le permite declarar explícitamente qué
    información que desea que le devuelvan.

    Las opciones válidas de ``$returnedValues`` son: ``nombre``, ``tamaño``, ``fecha``, ``legible``, ``escribible``,
    ``ejecutable`` y ``fileperms``.

.. php:function:: symbolic_permissions($perms)

    :param int $perms: Permisos
    :devuelve: cadena de permisos simbólicos
    :rtype: cadena

    Toma permisos numéricos (como los que devuelve `fileperms()<https://www.php.net/manual/en/function.fileperms.php>` _) y devuelve
    Notación simbólica estándar de permisos de archivos.

    .. literalinclude:: filesystem_helper/012.php

.. php:function:: octal_permissions($perms)

    :param int $perms: Permisos
    :devuelve: cadena de permisos octales
    :rtype: cadena

    Toma permisos numéricos (como los que devuelve `fileperms()<https://www.php.net/manual/en/function.fileperms.php>` _) y devuelve
    una notación octal de tres caracteres de permisos de archivos.

    .. literalinclude:: filesystem_helper/013.php

.. php:function:: same_file($file1, $file2)

    :param  string $file1: Ruta al primer archivo
    :param  string $file2: Ruta al segundo archivo
    :returns: si ambos archivos existen con hashes idénticos
    :rtype: booleano

    Compara dos archivos para ver si son iguales (según su hash MD5).

    .. literalinclude:: filesystem_helper/014.php

.. php:function:: set_realpath($path[, $checkExistence = false])

    :param  string $ruta: Ruta
    :param bool $checkExistence: si se debe verificar si la ruta realmente existe
    :regresa: Un camino absoluto
    :rtype: cadena

    Esta función devolverá una ruta del servidor sin enlaces simbólicos ni
    estructuras de directorios relativas. Un segundo argumento opcional
    provocar que se active un error si la ruta no se puede resolver.

    Ejemplos:

    .. literalinclude:: filesystem_helper/015.php
