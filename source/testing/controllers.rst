#######################
Controladores de prueba
#######################

Probar sus controladores se hace más conveniente con un par de nuevas clases y rasgos de ayuda. Al probar los controladores,
puede ejecutar el código dentro de un controlador, sin ejecutar primero todo el proceso de arranque de la aplicación.
Muchas veces, usando las :doc:`Herramientas de prueba de funciones<feature>` será más simple, pero esta funcionalidad está aquí en
caso que lo necesites.

.. note:: Because the entire framework has not been bootstrapped, there will be times when you cannot test a controller
    Por aquí.

.. contents::
    :local:
    :depth: 2

El rasgo del ayudante
=====================

Para habilitar las pruebas de controlador, necesita usar el rasgo ``ControllerTestTrait`` dentro de sus pruebas:

.. literalinclude:: controllers/001.php

Una vez que se ha incluido el rasgo, puede comenzar a configurar el entorno, incluidas las clases de solicitud y respuesta,
el cuerpo de la solicitud, URI y más. Usted especifica el controlador a usar con el método ``controller()``, pasando el
nombre de clase completo de su controlador. Finalmente, llame al método ``execute()`` con el nombre del método.
para ejecutar como parámetro:

.. literalinclude:: controllers/002.php

Métodos auxiliares
==================

controlador($clase)
-------------------

Especifica el nombre de clase del controlador a probar. El primer parámetro debe ser un nombre de clase completo.
(es decir, incluya el espacio de nombres):

.. literalinclude:: controllers/003.php

ejecutar(cadena $método, ...$parámetros)
----------------------------------------

Ejecuta el método especificado dentro del controlador. El primer parámetro es el nombre del método a ejecutar:

.. literalinclude:: controllers/004.php

Al especificar el segundo parámetro y los siguientes, puede pasarlos al método del controlador.

Esto devuelve una nueva clase auxiliar que proporciona una serie de rutinas para comprobar la respuesta misma. Vea abajo
para detalles.

con configuración ($ configuración)
-----------------------------------

Le permite pasar una versión modificada de **app/Config/App.php** para probar con diferentes configuraciones:

.. literalinclude:: controllers/005.php

Si no proporciona uno, se utilizará el archivo de configuración de la aplicación de la aplicación.

withRequest($solicitud)
-------------------------

Le permite proporcionar una instancia **IncomingRequest** adaptada a sus necesidades de prueba:

.. literalinclude:: controllers/006.php

Si no proporciona uno, se pasará una nueva instancia de IncomingRequest con los valores predeterminados de la aplicación.
en su controlador.

withResponse($respuesta)
------------------------

Le permite proporcionar una instancia de **Respuesta**:

.. literalinclude:: controllers/007.php

Si no proporciona una, se pasará una nueva instancia de respuesta con los valores predeterminados de la aplicación.
en su controlador.

withLogger($logger)
-------------------

Le permite proporcionar una instancia de **Logger**:

.. literalinclude:: controllers/008.php

Si no proporciona uno, se pasará una nueva instancia de Logger con los valores de configuración predeterminados.
en su controlador.

withURI(cadena $uri)
--------------------

Le permite proporcionar un nuevo URI que simule la URL que visitaba el cliente cuando se ejecutó este controlador.
Esto es útil si necesita verificar segmentos de URI dentro de su controlador. El único parámetro es una cadena.
representando un URI válido:

.. literalinclude:: controllers/009.php

Es una buena práctica proporcionar siempre el URI durante las pruebas para evitar sorpresas.

.. note:: Since v7.4.0, this method creates a new Request instance with the URI.
    Porque la instancia de Solicitud debería tener la instancia de URI. También si el nombre de host
    en la cadena URI no es válida con ``Config\App``, el nombre de host válido será
    colocar.

withBody($cuerpo)
-----------------

Le permite proporcionar un cuerpo personalizado para la solicitud. Esto puede resultar útil al probar controladores API donde
debe establecer un valor JSON como cuerpo. El único parámetro es una cadena que representa el cuerpo de la solicitud:

.. literalinclude:: controllers/010.php

Comprobando la respuesta
========================

``ControllerTestTrait::execute()`` devuelve una instancia de ``TestResponse``. Ver :doc:`Respuestas de prueba<response>`  en
cómo utilizar esta clase para realizar afirmaciones y verificaciones adicionales en sus casos de prueba.

Prueba de filtro
================

Similar a Controller Testing, el marco proporciona herramientas para ayudar a crear pruebas para
personalizado :doc:`Filtros</incoming/filters>`  y sus proyectos los utilizan en el enrutamiento.

El rasgo del ayudante
---------------------

Al igual que con el Probador del controlador, debe incluir ``FilterTestTrait`` en su prueba.
casos para habilitar estas características:

.. literalinclude:: controllers/011.php

Configuración
-------------

Debido a la superposición lógica con las pruebas del controlador, ``FilterTestTrait`` está diseñado para
trabaje junto con ``ControllerTestTrait`` si necesita ambos en la misma clase.
Una vez que se haya incluido el rasgo, ``CIUnitTestCase`` detectará su método ``setUp`` y
Prepare todos los componentes necesarios para sus pruebas. Si necesita una configuración especial
puede modificar cualquiera de las propiedades antes de llamar a los métodos de soporte:

* ``$request`` Una versión preparada del servicio predeterminado ``IncomingRequest``
* ``$response`` Una versión preparada del servicio predeterminado ``ResponseInterface``
* ``$filtersConfig`` La configuración predeterminada ``Config\Filters`` (nota: el descubrimiento lo manejan ``Filters``, por lo que esto no incluirá los alias de los módulos)
* ``$filters`` Una instancia de ``Higgs\Filters\Filters`` usando los tres componentes anteriores
* ``$collection`` Una versión preparada de ``RouteCollection`` que incluye el descubrimiento de ``Config\Routes``

La configuración predeterminada generalmente será la mejor para sus pruebas, ya que emula mejor
un proyecto "en vivo", pero (por ejemplo) si desea simular un filtro que se activa accidentalmente
en una ruta sin filtrar, puede agregarla a la configuración:

.. literalinclude:: controllers/012.php

Comprobación de rutas
---------------------

El primer método auxiliar es ``getFiltersForRoute()`` que simulará la ruta proporcionada.
y devolver una lista de todos los filtros (por su alias) que se habrían ejecutado para la posición dada
("antes" o "después"), sin ejecutar realmente ningún controlador o código de enrutamiento. Esto tiene
una gran ventaja de rendimiento sobre el controlador y las pruebas HTTP.

.. php:function:: getFiltersForRoute($route, $position)

    :param string $route: El URI a verificar
    :param string $position: El método de filtro a verificar, "antes" o "después"
    :devuelve: Alias para cada filtro que se habría ejecutado
    :rtype: cadena[]

    Ejemplo de uso:

    .. literalinclude:: controllers/013.php

Llamar a métodos de filtro
--------------------------

Las propiedades descritas en Configuración están configuradas para garantizar el máximo rendimiento sin
interferencias o interferencias de otras pruebas. El siguiente método auxiliar devolverá un invocable
método que utiliza estas propiedades para probar su código de filtro de forma segura y verificar los resultados.

.. php:function:: getFilterCaller($filter, $position)

    :param FilterInterface|string $filter: la instancia, clase o alias del filtro
    :param string $position: El método de filtro a ejecutar, "antes" o "después"
    :returns: Un método invocable para ejecutar el evento Filter simulado
    :tipo: Cierre

    Ejemplo de uso:

    .. literalinclude:: controllers/014.php

    Observe cómo el ``Cierre`` puede tomar parámetros de entrada que se pasan a su método de filtro.

Afirmaciones
------------

Además de los métodos auxiliares anteriores, ``FilterTestTrait`` también viene con algunas afirmaciones.
para optimizar sus métodos de prueba.

afirmarfiltro()
^^^^^^^^^^^^^^^

El método ``assertFilter()`` comprueba que la ruta dada en la posición utilice el filtro (por su alias):

.. literalinclude:: controllers/015.php

afirmarNotFilter()
^^^^^^^^^^^^^^^^^^

El método ``assertNotFilter()`` comprueba que la ruta dada en la posición no utilice el filtro (por su alias):

.. literalinclude:: controllers/016.php

afirmarHasFilters()
^^^^^^^^^^^^^^^^^^^

El método ``assertHasFilters()`` comprueba que la ruta dada en la posición tenga al menos un conjunto de filtros:

.. literalinclude:: controllers/017.php

afirmarNotHasFilters()
^^^^^^^^^^^^^^^^^^^^^^

El método ``assertNotHasFilters()`` comprueba que la ruta dada en la posición no tenga filtros establecidos:

.. literalinclude:: controllers/018.php
