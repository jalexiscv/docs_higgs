###############
Puntos de vista
###############

.. contents::
    :local:
    :depth: 2

Una vista es simplemente una página web o un fragmento de página, como un encabezado, pie de página, barra lateral, etc.
Las vistas se pueden incrustar de manera flexible dentro de otras vistas (dentro de otras vistas, etc.) si es necesario.
este tipo de jerarquía.

Las vistas nunca se llaman directamente, deben cargarse mediante un controlador o :ref:`ruta de vista<view-routes>` .

Recuerde que en un marco MVC,
el Controlador actúa como policía de tráfico, por lo que es responsable de obtener una vista particular. Si usted tiene
no leer el :doc:`Controladores</incoming/controllers>`  página, debe hacerlo antes de continuar.

Usando el controlador de ejemplo que creó en la página del controlador, agreguemosle una vista.

Creando una vista
=================

Usando tu editor de texto, crea un archivo llamado **blog_view.php** y pon esto en él::

    <html>
        <head>
            <title>Mi blog</title>
        </head>
        <body>
            <h1>¡Bienvenido a mi blog!</h1>
        </body>
    </html>

Luego guarde el archivo en su directorio **app/Views**.

Mostrar una vista
=================

Para cargar y mostrar un archivo de vista particular, utilizará :php:func:`view()`
Funciona como el siguiente código en tu controlador:

.. literalinclude:: views/001.php
   :lines: 2-

Donde *nombre* es el nombre de su archivo de visualización.

.. important:: If the file extension is omitted, then the views are expected to end with the **.php** extension.

Ahora, cree un archivo llamado **Blog.php** en el directorio **app/Controllers**,
y ponle esto:

.. literalinclude:: views/002.php

Abra el archivo de enrutamiento ubicado en **app/Config/Routes.php** y busque "Definiciones de ruta".
Agregue el siguiente código:

.. literalinclude:: views/013.php
   :lines: 2-

Si visita su sitio, debería ver su nueva vista. La URL era similar a esta::

    ejemplo.com/index.php/blog/

Cargando múltiples vistas
=========================

Higgs manejará inteligentemente múltiples llamadas a :php:func:`view()` desde
dentro de un controlador. Si ocurre más de una llamada, se agregarán juntas.

Por ejemplo, es posible que desee tener una vista de encabezado, una vista de menú, una
vista de contenido y una vista de pie de página. Podría verse así:

.. literalinclude:: views/003.php

En el ejemplo anterior, utilizamos "datos agregados dinámicamente", que verá a continuación.

Almacenamiento de vistas dentro de subdirectorios
=================================================

Los archivos de visualización también se pueden almacenar en subdirectorios si prefiere ese tipo de organización.
Al hacerlo, deberá incluir el nombre del directorio que carga la vista. Ejemplo:

.. literalinclude:: views/004.php
   :lines: 2-

Vistas con espacio de nombres
=============================

Puede almacenar vistas en un directorio **Ver** que tenga un espacio de nombres y cargar esa vista como si tuviera un espacio de nombres. Mientras
PHP no admite la carga de archivos que no sean de clase desde un espacio de nombres, Higgs proporciona esta característica para hacerlo posible
para empaquetar sus vistas en forma de módulo para facilitar su reutilización o distribución.

Si tiene un directorio **ejemplo/blog** que tiene una asignación PSR-4 configurada en :doc:`Autoloader</concepts/autoloader>` viviendo
bajo el espacio de nombres ``Ejemplo\Blog``, puede recuperar archivos de vista como si también tuvieran un espacio de nombres.

Siguiendo esto
Por ejemplo, podrías cargar el archivo **blog_view.php** desde **example/blog/Views** anteponiendo el espacio de nombres al nombre de la vista:

.. literalinclude:: views/005.php

.. _caching-views:

Vistas de almacenamiento en caché
=================================

Puede almacenar en caché una vista con la función :php:func:`view()` pasando un ``cache``
opción con el número de segundos para almacenar en caché la vista, en el tercer parámetro:

.. literalinclude:: views/006.php
   :lines: 2-

De forma predeterminada, la vista se almacenará en caché con el mismo nombre que el archivo de vista. Puedes personalizar esto pasando
junto con ``cache_name`` y el ID de caché que deseas usar:

.. literalinclude:: views/007.php
   :lines: 2-

Agregar datos dinámicos a la vista
==================================

Los datos se pasan del controlador a la vista a través de una matriz en el segundo
parámetro de la función :php:func:`view()`.

He aquí un ejemplo:

.. literalinclude:: views/008.php
   :lines: 2-

Probémoslo con su archivo de controlador. Ábrelo y agrega este código:

.. literalinclude:: views/009.php

Ahora abra su archivo de vista y cambie el texto a variables que correspondan a las claves de matriz en sus datos::

    <html>
        <head>
            <title><?= esc($título)?></title>
        </head>
        <body>
            <h1><?= esc($heading) ?></h1>
        </body>
    </html>

Luego cargue la página en la URL que ha estado usando y debería ver las variables reemplazadas.

La opción guardar datos
-------------------

Los datos pasados se conservan para llamadas posteriores a :php:func:`view()`. Si usted
llame a la función varias veces en una sola solicitud, no tendrá que pasar
los datos deseados a cada ``vista()``.

Pero es posible que esto no impida que los datos se "filtren" en
otras vistas, lo que podría causar problemas. Si prefiere limpiar los datos después de una llamada, puede pasar la opción ``saveData``
en la matriz ``$option`` en el tercer parámetro.

.. literalinclude:: views/010.php
   :lines: 2-

Además, si desea que la funcionalidad predeterminada de la función ``view()`` borre los datos
entre llamadas, puede configurar ``$saveData`` en ``false`` en **app/Config/Views.php**.

Creando bucles
==============

La matriz de datos que pasa a sus archivos de vista no se limita a variables simples. Puedes pasar multidimensional
matrices, que se pueden repetir para generar varias filas. Por ejemplo, si extrae datos de su base de datos,
normalmente tendrá la forma de una matriz multidimensional.

He aquí un ejemplo sencillo. Añade esto a tu controlador:

.. literalinclude:: views/011.php

Ahora abra su archivo de vista y cree un bucle:

.. literalinclude:: views/012.php
