##########################
Manejo de recursos RESTful
##########################

.. contents::
    :local:
    :depth: 2

La transferencia de estado representacional (REST) es un estilo arquitectónico para
aplicaciones distribuidas, descritas por primera vez por Roy Fielding en su
2000 Tesis doctoral, "Estilos arquitectónicos y
el diseño de arquitecturas de software basadas en red
<https://www.ics.uci.edu/~fielding/pubs/dissertation/top.htm>`_.
Puede que sea una lectura un poco seca, y es posible que encuentres el libro de Martin Fowler
`Modelo de madurez de Richardson<https://martinfowler.com/articles/richardsonMaturityModel.html>` _
una introducción más suave.

REST ha sido interpretado, y malinterpretado, en más formas que la mayoría
arquitecturas de software, y podría ser más fácil decir que cuanto más
de los principios de Roy Fielding que se adoptan en una arquitectura, el
La aplicación más "RESTful" sería considerada.

Higgs facilita la creación de API RESTful para sus recursos,
con sus rutas de recursos y `ResourceController`.


Rutas de recursos
*****************

Puede crear rápidamente un puñado de rutas RESTful para un único recurso con el método ``resource()``. Este
crea las cinco rutas más comunes necesarias para el CRUD completo de un recurso: crear un nuevo recurso, actualizar uno existente,
enumere todo ese recurso, muestre un solo recurso y elimine un solo recurso. El primer parámetro es el recurso.
nombre:

.. literalinclude:: restful/001.php

.. note:: The ordering above is for clarity, whereas the actual order the routes are created in, in RouteCollection, ensures proper route resolution

.. important:: The routes are matched in the order they are specified, so if you have a resource photos above a get 'photos/poll' the show action's route for the resource line will be matched before the get line. To fix this, move the get line above the resource line so that it is matched first.

El segundo parámetro acepta una serie de opciones que se pueden utilizar para modificar las rutas que se generan. Mientras estos
las rutas están orientadas al uso de API, donde se permiten más métodos, puede pasar la opción ``websafe`` para tenerla
generar métodos de actualización y eliminación que funcionen con formularios HTML:

.. literalinclude:: restful/002.php

Cambiar el controlador utilizado
================================

Puede especificar el controlador que debe usarse pasando la opción ``controller`` con el nombre de
El controlador que se debe utilizar:

.. literalinclude:: restful/003.php

.. literalinclude:: restful/017.php

.. literalinclude:: restful/018.php

Véase también :ref:`controladores-espacio de nombres`.

Cambiar el marcador de posición utilizado
=========================================

De forma predeterminada, el marcador de posición ``(:segmento)`` se utiliza cuando se necesita un ID de recurso. Puedes cambiar esto pasando
en la opción ``placeholder`` con la nueva cadena a usar:

.. literalinclude:: restful/004.php

Limitar las rutas realizadas
============================

Puedes restringir las rutas generadas con la opción ``solo``. Esto debería ser **una matriz** o una **lista separada por comas** de nombres de métodos que deberían
ser creado. Sólo se crearán rutas que coincidan con uno de estos métodos. El resto será ignorado:

.. literalinclude:: restful/005.php

De lo contrario, puede eliminar rutas no utilizadas con la opción ``excepto``. Esto también debería ser **una matriz** o una **lista separada por comas** de nombres de métodos. Esta opción se ejecuta después de ``solo``:

.. literalinclude:: restful/006.php

Los métodos válidos son: ``index``, ``show``, ``create``, ``update``, ``new``, ``edit`` y ``delete``.


Controlador de recursos
***********************

El ``ResourceController`` proporciona un punto de partida conveniente para su API RESTful,
con métodos que corresponden a las rutas de recursos anteriores.

Extiéndalo, anulando las propiedades ``modelName`` y ``format``, y luego
implemente los métodos que desea manejar:

.. literalinclude:: restful/007.php

La ruta para esto sería:

.. literalinclude:: restful/008.php


Rutas del presentador
*********************

Puede crear rápidamente un controlador de presentación que alinee
con un controlador de recursos, usando el método ``presenter()``. Este
crea rutas para los métodos del controlador que devolverían vistas
para su recurso o procesar formularios enviados desde esas vistas.

No es necesario, ya que la presentación se puede manejar con
un controlador convencional: es una comodidad.
Su uso es similar al enrutamiento de recursos:

.. literalinclude:: restful/009.php

.. note:: The ordering above is for clarity, whereas the actual order the routes are created in, in RouteCollection, ensures proper route resolution

No tendría rutas para "fotos" tanto para un recurso como para un presentador
controlador. Es necesario distinguirlos, por ejemplo:

.. literalinclude:: restful/010.php

El segundo parámetro acepta una serie de opciones que se pueden utilizar para modificar las rutas que se generan.

Cambiar el controlador utilizado
================================

Puede especificar el controlador que debe usarse pasando la opción ``controller`` con el nombre de
El controlador que se debe utilizar:

.. literalinclude:: restful/011.php

.. literalinclude:: restful/019.php

.. literalinclude:: restful/020.php

Véase también :ref:`controladores-espacio de nombres`.

Cambiar el marcador de posición utilizado
=========================================

De forma predeterminada, el marcador de posición ``(:segmento)`` se utiliza cuando se necesita un ID de recurso. Puedes cambiar esto pasando
en la opción ``placeholder`` con la nueva cadena a usar:

.. literalinclude:: restful/012.php

Limitar las rutas realizadas
============================

Puedes restringir las rutas generadas con la opción ``solo``. Esto debería ser **una matriz** o una **lista separada por comas** de nombres de métodos que deberían
ser creado. Sólo se crearán rutas que coincidan con uno de estos métodos. El resto será ignorado:

.. literalinclude:: restful/013.php

De lo contrario, puede eliminar rutas no utilizadas con la opción ``excepto``. Esto también debería ser **una matriz** o una **lista separada por comas** de nombres de métodos. Esta opción se ejecuta después de ``solo``:

.. literalinclude:: restful/014.php

Los métodos válidos son: ``index``, ``show``, ``new``, ``create``, ``edit``, ``update``, ``remove`` y ``delete`. `.


Presentador de recursos
***********************

``ResourcePresenter`` proporciona un punto de partida conveniente para presentar vistas
de su recurso y procesar datos de formularios en esas vistas,
con métodos que se alinean con las rutas de recursos anteriores.

Extiéndalo, anulando la propiedad ``modelName`` y luego
implemente los métodos que desea manejar:

.. literalinclude:: restful/015.php

La ruta para esto sería:

.. literalinclude:: restful/016.php


Comparación presentador/controlador
***********************************

Esta tabla presenta una comparación de las rutas predeterminadas creadas por `resource()`
y `presentador()` con sus correspondientes funciones de Controlador.

================ ========= ======================= === ====================== ======================= ======= ================
Método de operación Ruta del controlador Presentador de ruta Función del controlador Función del presentador
================ ========= ======================= === ====================== ======================= ======= ================
**Nuevo** OBTENER fotos/nuevas fotos/nuevo ``nuevo()````nuevo()``
**Crear** PUBLICAR fotos fotos ``create()````create()``
Crear (alias) POST fotos/crear ``create()``
**Lista** OBTENER fotos fotos ``index()````index()``
**Mostrar** OBTENER fotos/(:segmento) fotos/(:segmento) ``mostrar($id = null)````mostrar($id = null)``
Mostrar (alias) OBTENER fotos/mostrar/(:segmento) ``mostrar($id = null)``
**Editar** OBTENER fotos/(:segmento)/editar fotos/editar/(:segmento) ``editar($id = null)````editar($id = null)``
**Actualizar** PUT/PATCH fotos/(:segmento) ``actualizar($id = null)``
Actualizar (websafe) POST fotos/(:segmento) fotos/actualizar/(:segmento) ``actualizar($id = null)````actualizar($id = null)``
**Eliminar** OBTENER fotos/eliminar/(:segmento) ``eliminar($id = null)``
**Eliminar** ELIMINAR fotos/(:segmento) ``eliminar($id = null)``
Eliminar (seguro para la web) POST fotos/eliminar/(:segmento) ``eliminar($id = null)````eliminar($id = null)``
================ ========= ======================= === ====================== ======================= ======= ================
