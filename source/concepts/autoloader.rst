############################
Archivos de carga automática
############################

.. contents::
    :local:
    :depth: 2

Cada aplicación consta de una gran cantidad de clases en muchos lugares diferentes.
El marco proporciona clases para la funcionalidad principal. Su solicitud tendrá un
número de bibliotecas, modelos y otras entidades para que funcione. Es posible que tenga terceros
clases que utiliza su proyecto. Realizar un seguimiento de dónde está cada archivo y
codificar esa ubicación en sus archivos en una serie de ``requires()`` es una tarea enorme.
dolor de cabeza y muy propenso a errores. Ahí es donde entran los cargadores automáticos.

Cargador automático de Higgs (IA)
*********************************

Higgs proporciona un cargador automático muy flexible que se puede utilizar con muy poca configuración. Puede localizar clases con espacios de nombres individuales que se adhieran a
`PSR-4<https://www.php-fig.org/psr/psr-4/>` _ carga automática
estructuras de directorios. El cargador automático funciona muy bien por sí solo, pero también puede funcionar con otros cargadores automáticos, como
`Composer<https://getcomposer.org>` _, o incluso sus propios cargadores automáticos personalizados, si es necesario.
Porque todos están registrados a través de
`spl_autoload_register<https://www.php.net/manual/en/function.spl-autoload-register.php>` _,
Trabajan en secuencia y no se interponen entre sí.

El autocargador siempre está activo, estando registrado con ``spl_autoload_register()`` en el
inicio de la ejecución del framework.

.. important:: You should always be careful about the case of filenames. Many
    los desarrolladores desarrollan en sistemas de archivos que no distinguen entre mayúsculas y minúsculas en Windows o macOS.
    Sin embargo, la mayoría de los entornos de servidores utilizan sistemas de archivos que distinguen entre mayúsculas y minúsculas. Si el
    Las mayúsculas y minúsculas del nombre del archivo son incorrectas, el cargador automático no puede encontrar el archivo en el
    servidor.

Configuración
*************

La configuración inicial se realiza en **app/Config/Autoload.php**. Este archivo contiene dos principales
matrices: una para el mapa de clases y otra para espacios de nombres compatibles con PSR-4.

.. _autoloader-namespaces:

Espacios de nombres
===================

El método recomendado para organizar sus clases es crear uno o más espacios de nombres para su
archivos de la aplicación. Esto es más importante para cualquier clase relacionada con la lógica empresarial, clases de entidad,
etc. La matriz ``$psr4`` en el archivo de configuración le permite asignar el espacio de nombres al directorio
esas clases se pueden encontrar en:

.. literalinclude:: autoloader/001.php

La clave de cada fila es el propio espacio de nombres. Esto no necesita una barra diagonal inversa.
El valor es la ubicación del directorio en el que se pueden encontrar las clases.

.. _confirming-namespaces:

Confirmar espacios de nombres
=============================

Puede verificar la configuración del espacio de nombres con el comando ``spark namespaces``:

.. code-block:: console

    espacios de nombres de php spark

Espacio de nombres de la aplicación
===================================

De forma predeterminada, el directorio de la aplicación es un espacio de nombres del espacio de nombres ``App``. Debes crear un espacio de nombres para los controladores,
bibliotecas o modelos en el directorio de la aplicación, y se encontrarán en el espacio de nombres ``App``.

Puede cambiar este espacio de nombres editando el archivo **app/Config/Constants.php** y configurando el
nuevo valor de espacio de nombres bajo la configuración ``APP_NAMESPACE``:

.. literalinclude:: autoloader/002.php
   :lines: 2-

Deberá modificar cualquier archivo existente que haga referencia al espacio de nombres actual.

.. important:: Config files are namespaced in the ``Config`` namespace, not in ``App\Config`` as you might
    esperar. Esto permite que los archivos principales del sistema siempre puedan ubicarlos, incluso cuando la aplicación
    El espacio de nombres ha cambiado.

Mapa de clase
=============

Higgs utiliza ampliamente el mapa de clases para obtener los últimos gramos de rendimiento del sistema.
al no golpear el sistema de archivos con llamadas adicionales ``is_file()``. Puede utilizar el mapa de clase para vincular a
bibliotecas de terceros que no tienen espacios de nombres:

.. literalinclude:: autoloader/003.php

La clave de cada fila es el nombre de la clase que desea ubicar. El valor es la ruta para ubicarlo.

Soporte para compositores
*************************

La compatibilidad con Composer se inicializa automáticamente de forma predeterminada. De forma predeterminada, busca el archivo de carga automática de Composer en
``ROOTPATH . 'vendor/autoload.php'``. Si necesita cambiar la ubicación de ese archivo por algún motivo, puede modificar
el valor definido en **app/Config/Constants.php**.

.. note:: If the same namespace is defined in both Higgs and Composer, Higgs's autoloader will be
    el primero en tener la oportunidad de localizar el archivo.
