*******************************
Crear clases de sistema central
*******************************

Cada vez que se ejecuta Higgs, hay varias clases base que se inicializan automáticamente como parte del núcleo.
estructura. Sin embargo, es posible intercambiar cualquiera de las clases principales del sistema con su propia versión o incluso simplemente ampliarlas.
las versiones principales.

**La mayoría de los usuarios nunca necesitarán hacer esto, pero existe la opción de reemplazarlos o ampliarlos para aquellos
que quisieran alterar significativamente el núcleo de Higgs.**

.. important:: Messing with a core system class has a lot of implications, so make sure you know what you are doing before
    intentarlo.

.. contents::
    :local:
    :depth: 2

Lista de clases del sistema
===========================

La siguiente es una lista de las clases principales del sistema que se invocan cada vez que se ejecuta Higgs:

* ``Higgs\Autocargador\Autocargador``
* ``Higgs\Autocargador\FileLocator``
* ``Higgs\Cache\CacheFactory``
* ``Higgs\Cache\Handlers\BaseHandler``
* ``Higgs\Cache\Handlers\FileHandler``
* ``Higgs\Cache\ResponseCache``
* ``Higgs\Higgs``
* ``Higgs\Config\BaseService``
* ``Higgs\Config\DotEnv``
* ``Higgs\Config\Factories``
* ``Higgs\Config\Servicios``
* ``Higgs\Controlador``
* ``Higgs\Cookie\Cookie``
* ``Higgs\Cookie\CookieStore``
* ``Higgs\Depuración\Excepciones``
* ``Higgs\Depuración\Temporizador``
* ``Higgs\Eventos\Eventos``
* ``Higgs\Filtros\Filtros``
* ``Higgs\HTTP\CLIRequest`` (si se inicia solo desde la línea de comando)
* ``Higgs\HTTP\ContentSecurityPolicy``
* ``Higgs\HTTP\Encabezado``
* ``Higgs\HTTP\IncomingRequest`` (si se inicia a través de HTTP)
* ``Higgs\HTTP\Mensaje``
* ``Higgs\HTTP\OutgoingRequest``
* ``Higgs\HTTP\Solicitud``
* ``Higgs\HTTP\Respuesta``
* ``Higgs\HTTP\SiteURI``
* ``Higgs\HTTP\SiteURIFactory``
* ``Higgs\HTTP\URI``
* ``Higgs\HTTP\UserAgent`` (si se inicia a través de HTTP)
* ``Higgs\Log\Logger``
* ``Higgs\Log\Handlers\BaseHandler``
* ``Higgs\Log\Handlers\FileHandler``
* ``Higgs\Enrutador\RouteCollection``
* ``Higgs\Enrutador\Enrutador``
* ``Higgs\Superglobales``
* ``Higgs\Ver\Ver``

Reemplazo de clases principales
===============================

Para utilizar una de sus propias clases de sistema en lugar de una predeterminada, asegúrese de:

    1. el :doc:`Autoloader <../concepts/autoloader>` puede encontrar tu clase,
    2. su nueva clase implementa la interfaz adecuada,
    3. y modifique el :doc:`Service <../concepts/services>` apropiado para cargar su clase en lugar de la clase principal.

Creando tu clase
-------------------

Por ejemplo, si tiene una nueva clase ``App\Libraries\RouteCollection`` que le gustaría usar en lugar de
la clase central del sistema, crearía su clase de esta manera:

.. literalinclude:: core_classes/001.php

Agregar el servicio
------------------

Luego agregarías el servicio ``rutas`` en **app/Config/Services.php** para cargar tu clase:

.. literalinclude:: core_classes/002.php

Ampliación de las clases básicas
================================

Si todo lo que necesita es agregar alguna funcionalidad a una biblioteca existente (tal vez agregar uno o dos métodos), entonces es excesivo
para recrear toda la biblioteca. En este caso, es mejor simplemente ampliar la clase. Ampliar la clase es casi
idéntico a `Reemplazar clases principales`_ con una excepción:

* La declaración de clase debe extender la clase padre.

Por ejemplo, para extender la clase nativa ``RouteCollection``, declararías tu clase con:

.. literalinclude:: core_classes/003.php

Si necesita utilizar un constructor en su clase, asegúrese de extender el constructor principal:

.. literalinclude:: core_classes/004.php

**Consejo:** Se utilizarán todas las funciones de su clase que tengan nombres idénticos a los métodos de la clase principal.
en lugar de los nativos (esto se conoce como "método anulado"). Esto le permite alterar sustancialmente el núcleo de Higgs.
