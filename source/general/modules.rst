#################
Módulos de código
#################

Higgs admite una forma de modularización de código para ayudarle a crear código reutilizable. Los módulos suelen ser
se centran en un tema específico y pueden considerarse como miniaplicaciones dentro de una aplicación más grande.

Cualquier
Se admiten todos los tipos de archivos estándar dentro del marco, como controladores, modelos, vistas, archivos de configuración, ayudas,
archivos de idioma, etc. Los módulos pueden contener tantos o tantos como desee.

Si desea crear un módulo como un paquete Composer, consulte también :doc:`../extending/composer_packages`.

.. contents::
    :local:
    :depth: 2


Espacios de nombres
*******************

El elemento central de la funcionalidad del módulo proviene de :doc:`carga automática compatible con PSR-4 <../concepts/autoloader>`
que usa Higgs. Si bien cualquier código puede utilizar el cargador automático y los espacios de nombres PSR-4, la forma principal de aprovechar al máximo
módulos es crear un espacio de nombres para su código y agregarlo a **app/Config/Autoload.php**, en la propiedad ``$psr4``.

Por ejemplo, digamos que queremos mantener un módulo de blog simple que podamos reutilizar entre aplicaciones. podríamos crear
carpeta con el nombre de nuestra empresa, Acme, para almacenar todos nuestros módulos. Lo pondremos junto a nuestra **aplicación**
directorio en la raíz principal del proyecto::

    acme/ // Nuevo directorio de módulos
    aplicación/
    public/
    sistema/
    pruebas/
    grabable/

Abra **app/Config/Autoload.php** y agregue el espacio de nombres ``Acme\Blog`` a la propiedad de matriz ``$psr4``:

.. literalinclude:: modules/001.php

Ahora que esto está configurado, podemos acceder a cualquier archivo dentro de la carpeta **acme/Blog** a través del espacio de nombres ``Acme\Blog``. esto solo
se encarga del 80% de lo que se necesita para que los módulos funcionen, por lo que debes asegurarte de familiarizarte con los espacios de nombres
y sentirse cómodo con su uso. Se escanearán automáticamente varios tipos de archivos en todos los espacios de nombres definidos, un ingrediente crucial para trabajar con módulos.

Una estructura de directorio común dentro de un módulo imitará la carpeta principal de la aplicación:

    cumbre/
        Blog/
            Configuración/
            Controladores/
            Base de datos/
                Migraciones/
                Semillas/
            Ayudantes/
            Idioma/
                en/
            Bibliotecas/
            Modelos/
            Puntos de vista/

Por supuesto, no hay nada que le obligue a utilizar esta estructura exacta y debe organizarla de la manera que
se adapta mejor a su módulo, omitiendo directorios que no necesita, creando nuevos directorios para Entidades, Interfaces,
o Repositorios, etc.


Carga automática de archivos que no son de clase
************************************************

La mayoría de las veces su módulo no contendrá sólo clases PHP sino también otras como clases de procedimiento.
funciones, archivos de arranque, archivos de constantes de módulos, etc. que normalmente no se cargan de la misma manera que las clases.
están cargados. Un enfoque para esto es usar ``require``-ing el archivo(s) al inicio del archivo donde
Sería usado.

Otro enfoque proporcionado por Higgs es cargar automáticamente estos archivos *que no son de clase* como lo harías con la carga automática
tus clases. Todo lo que tenemos que hacer es proporcionar la lista de rutas a esos archivos e incluirlos en el
Propiedad ``$files`` de su archivo **app/Config/Autoload.php**.

.. literalinclude:: modules/002.php

.. _auto-discovery:


Descubrimiento automático
*************************

Muchas veces, necesitarás especificar el espacio de nombres completo de los archivos que deseas incluir, pero Higgs puede ser
configurado para simplificar la integración de módulos en sus aplicaciones al descubrir automáticamente muchos módulos diferentes
tipos de archivos, incluyendo:

- :doc:`Eventos <../extending/events>`
- :doc:`Filtros <../entrantes/filtros>`
- :ref:`registradores`
- :doc:`Archivos de ruta <../entrantes/enrutamiento>`
- :doc:`Servicios <../conceptos/servicios>`

Esto se configura en el archivo **app/Config/Modules.php**.

El sistema de descubrimiento automático funciona escaneando directorios y archivos particulares dentro de los espacios de nombres psr4 que se han definido en **Config/Autoload.php** y los paquetes Composer.

El proceso de descubrimiento buscaría elementos detectables en esa ruta y debería, por ejemplo, encontrar el archivo de rutas en **acme/Blog/Config/Routes.php**.

Activar/Desactivar Descubrir
============================

Puede activar o desactivar todo el descubrimiento automático en el sistema con la variable de clase ``$enabled``. Falso deshabilitará
todo descubrimiento, optimizando el rendimiento, pero negando las capacidades especiales de sus módulos y paquetes Composer.

Especificar elementos de descubrimiento
=======================================

Con la opción ``$alias``, puede especificar qué elementos se descubren automáticamente. Si el artículo no es
presente, entonces no se realizará ningún descubrimiento automático para ese elemento, pero los demás en la matriz aún serán descubiertos.

Descubridor y compositor
========================

Los paquetes instalados a través de Composer utilizando espacios de nombres PSR-4 también se descubrirán de forma predeterminada.
Los paquetes con espacio de nombres PSR-0 no se detectarán.

.. _modules-specify-composer-packages:

Especificar paquetes de compositor
-------------------------

.. versionadded:: 7.0.0

Para evitar perder tiempo buscando paquetes de Composer irrelevantes, puede especificar manualmente los paquetes para descubrir editando la variable ``$composerPackages`` en **app/Config/Modules.php**:

.. literalinclude:: modules/013.php

Alternativamente, puede especificar qué paquetes excluir del descubrimiento.

.. literalinclude:: modules/014.php

Deshabilitar el descubrimiento del paquete Composer
----------------------------------

Si no desea que se analicen todos los directorios conocidos de Composer al localizar archivos, puede desactivar esta opción.
editando la variable ``$discoverInComposer`` en **app/Config/Modules.php**:

.. literalinclude:: modules/004.php


Trabajar con archivos
*********************

Esta sección analizará cada uno de los tipos de archivos (controladores, vistas, archivos de idioma, etc.) y cómo pueden
ser utilizado dentro del módulo. Parte de esta información se describe con más detalle en la ubicación correspondiente del usuario.
guía, pero se reproduce aquí para que sea más fácil comprender cómo encajan todas las piezas.

Rutas
=====

De forma predeterminada, :doc:`rutas <../incoming/routing>` se escanean automáticamente dentro de los módulos. Se puede apagar en
el archivo de configuración **Módulos**, descrito anteriormente.

.. note:: Since the files are being included into the current scope, the ``$routes`` instance is already defined for you.
    Causará errores si intenta redefinir esa clase.

Cuando se trabaja con módulos, puede ser un problema si las rutas de la aplicación contienen comodines.
En ese caso, consulte :ref:`prioridad de enrutamiento`.

.. _modules-filters:

Filtros
=======

.. deprecated:: 4.4.2

.. note:: This feature is deprecated. Use :ref:`registrars` instead like the
    siguiente:

    .. literalinclude:: modules/015.php

De forma predeterminada, :doc:`filtros <../incoming/filters>` se escanean automáticamente dentro de los módulos.
Se puede desactivar en el archivo de configuración **Módulos**, descrito anteriormente.

.. note:: Since the files are being included into the current scope, the ``$filters`` instance is already defined for you.
    Causará errores si intenta redefinir esa clase.

En el archivo **Config/Filters.php** del módulo, debes definir los alias de los filtros que utilizas:

.. literalinclude:: modules/005.php

Controladores
=============

Los controladores fuera del directorio principal **app/Controllers** no se pueden enrutar automáticamente mediante la detección de URI.
pero debe especificarse dentro del propio archivo de Rutas:

.. literalinclude:: modules/006.php

Para reducir la cantidad de escritura necesaria aquí, la función de enrutamiento **grupo** es útil:

.. literalinclude:: modules/007.php

Archivos de configuración
=========================

No se necesitan cambios especiales cuando se trabaja con archivos de configuración. Estas todavía son clases con espacios de nombres y cargadas.
con el comando ``nuevo``:

.. literalinclude:: modules/008.php

Los archivos de configuración se descubren automáticamente cada vez que se utiliza la función :php:func:`config()` que siempre está disponible y se le pasa un nombre de clase corto.

.. note:: We don't recommend you use the same short classname in modules.
    Los módulos que necesitan anular o agregar configuraciones conocidas en **app/Config/** deben usar :ref:`Registradores implícitos<registrars>` .

.. note:: Prior to v7.4.0, ``config()`` finds the file in **app/Config/** when there
    es una clase con el mismo nombre corto,
    incluso si especifica un nombre de clase completo como ``config(\Acme\Blog\Config\Blog::class)``.
    Este comportamiento se solucionó en v7.4.0 y devuelve la instancia especificada.

Migraciones
===========

Los archivos de migración se descubrirán automáticamente dentro de los espacios de nombres definidos. Todas las migraciones encontradas en todos
Los espacios de nombres se ejecutarán cada vez.

Semillas
========

Los archivos semilla se pueden usar desde la CLI y se pueden llamar desde otros archivos semilla, siempre que el espacio de nombres completo
está provisto. Si llama a la CLI, deberá proporcionar barras invertidas dobles:


Para Unix:

.. code-block:: console

    php spark db:seed Acme\\Blog\\Database\\Seeds\\TestPostSeeder

Para ventanas:

.. code-block:: console

    php spark db:seed Acme\Blog\Database\Seeds\TestPostSeeder

Ayudantes
=========

Los ayudantes se descubrirán automáticamente dentro de los espacios de nombres definidos cuando se utilice el
Función :php:func:`helper()`, siempre y cuando esté dentro de los espacios de nombres **Helpers**
directorio:

.. literalinclude:: modules/009.php

Puede especificar espacios de nombres. Consulte :ref:`helpers-loading-from-specified-namespace` para obtener más detalles.

Archivos de lenguaje
====================

Los archivos de idioma se ubican automáticamente desde espacios de nombres definidos cuando se utiliza el método ``lang()``, siempre que el
El archivo sigue las mismas estructuras de directorio que el directorio principal de la aplicación.

Bibliotecas
===========

Las bibliotecas siempre se crean instancias por su nombre de clase completo, por lo que no se proporciona ningún acceso especial:

.. literalinclude:: modules/010.php

Modelos
=======

Si crea instancias de modelos con la palabra clave ``new`` por sus nombres de clase completos, no se proporciona ningún acceso especial:

.. literalinclude:: modules/011.php

Los archivos de modelo se descubren automáticamente cada vez que se utiliza la función :php:func:`model()` que siempre está disponible.

.. note:: We don't recommend you use the same short classname in modules.

.. note:: ``model()`` finds the file in **app/Models/** when there is a class with the same shortname,
    incluso si especifica un nombre de clase completo como ``model(\Acme\Blog\Model\PostModel::class)``.
    Esto se debe a que ``model()`` es un contenedor para la clase ``Factories`` que usa ``preferApp`` de forma predeterminada. Consulte :ref:`factories-loading-class` para obtener más información.

Puntos de vista
===============

Las vistas se pueden cargar usando el espacio de nombres de la clase como se describe en :doc:`views</outgoing/views>` documentación:

.. literalinclude:: modules/012.php
