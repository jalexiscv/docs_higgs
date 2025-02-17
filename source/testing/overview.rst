#######
Pruebas
#######

Higgs se ha creado para que las pruebas tanto del marco como de la aplicación sean lo más sencillas posible.
Soporte para `PHPUnit<https://phpunit.de/>` __ está integrado y el marco proporciona una serie de prácticas
Métodos de ayuda para que probar cada aspecto de su aplicación sea lo más sencillo posible.

.. contents::
    :local:
    :depth: 3


Configuración del sistema
*************************

Instalación de PHPUnit
======================

Higgs usa `PHPUnit<https://phpunit.de/>` __ como base para todas sus pruebas. Hay dos formas de instalar
PHPUnit para usar dentro de su sistema.

Compositor
-----------

El método recomendado es instalarlo en su proyecto usando `Composer<https://getcomposer.org/>` __. Si bien es posible
Para instalarlo globalmente no lo recomendamos, ya que puede causar problemas de compatibilidad con otros proyectos en su
sistema a medida que pasa el tiempo.

Asegúrese de tener Composer instalado en su sistema. Desde la raíz del proyecto (el directorio que contiene el
directorios de aplicación y sistema) escriba lo siguiente desde la línea de comando:

.. code-block:: console

    el compositor requiere --dev phpunit/phpunit

Esto instalará la versión correcta para su versión actual de PHP. Una vez hecho esto, puede ejecutar todos los
pruebas para este proyecto escribiendo:

.. code-block:: console

    proveedor/bin/phpunit

Si está utilizando Windows, utilice el siguiente comando:

.. code-block:: console

    proveedor\bin\phpunit

far
----

La otra opción es descargar el archivo .phar desde `PHPUnit<https://phpunit.de/getting-started/phpunit-9.html>` __ sitio.
Este es un archivo independiente que debe colocarse dentro de la raíz de su proyecto.


Probando su aplicación
**********************

Configuración de PHPUnit
========================

En la raíz de su proyecto Higgs, se encuentra el archivo ``phpunit.xml.dist``. Este
controla las pruebas unitarias de su aplicación. Si proporciona su propio ``phpunit.xml``,
anulará esto.

De forma predeterminada, los archivos de prueba se colocan en el directorio **pruebas** en la raíz del proyecto.

La clase de prueba
==================

Para aprovechar las herramientas adicionales proporcionadas, sus pruebas deben extenderse
``Higgs\Prueba\CIUnitTestCase``.

No existen reglas sobre cómo se deben colocar los archivos de prueba. Sin embargo, recomendamos que
usted establece reglas de ubicación de antemano para que pueda comprender rápidamente dónde
se encuentran los archivos de prueba.

En este documento, colocaremos los archivos de prueba correspondientes a las clases en
el directorio **app** en el directorio **tests/app**. Para probar una nueva biblioteca,
**app/Libraries/Foo.php**, crearías un nuevo archivo en
**pruebas/app/Libraries/FooTest.php**:

.. literalinclude:: overview/001.php

Para probar uno de tus modelos, **app/Models/UserMode.php**, podrías terminar con
algo como esto en **tests/app/Models/UserModelTest.php**:

.. literalinclude:: overview/002.php

Puede crear cualquier estructura de directorio que se ajuste a sus necesidades/estilo de prueba. Al asignar espacios a los nombres de las clases de prueba,
Recuerde que el directorio **app** es la raíz del espacio de nombres ``App``, por lo que cualquier clase que utilice debe
tener el espacio de nombres correcto en relación con ``App``.

.. note:: Namespaces are not strictly required for test classes, but they are helpful to ensure no class names collide.

Al probar los resultados de la base de datos, debe utilizar :doc:`DatabaseTestTrait<database>`  en tu clase.

Puesta en escena
-------

La mayoría de las pruebas requieren cierta preparación para ejecutarse correctamente. ``TestCase`` de PHPUnit proporciona cuatro métodos
para ayudar con la puesta en escena y la limpieza::

    función estática pública setUpBeforeClass(): nula
    función estática pública tearDownAfterClass(): nula

    configuración de función protegida(): nula
    función protegida desgarro(): nulo

Los métodos estáticos ``setUpBeforeClass()`` y ``tearDownAfterClass()`` se ejecutan antes y después de todo el caso de prueba, mientras que los métodos protegidos ``setUp()`` y ``tearDown()`` se ejecutan.
entre cada prueba.

Si implementa alguna de estas funciones especiales, asegúrese de ejecutarlas
padre también para que los casos de prueba extendidos no interfieran con la puesta en escena:

.. literalinclude:: overview/003.php

.. _testing-overview-traits:

Rasgos
------

Una forma común de mejorar sus pruebas es utilizar rasgos para consolidar la puesta en escena en diferentes
Casos de prueba. ``CIUnitTestCase`` detectará cualquier rasgo de clase y buscará métodos de preparación
para ejecutar el nombre del rasgo en sí (es decir, `setUp{NameOfTrait}()` y `tearDown{NameOfTrait}()`).

Por ejemplo, si necesitara agregar autenticación a algún
de sus casos de prueba, podría crear un rasgo de autenticación con un método de configuración para falsificar un
usuario registrado:

.. literalinclude:: overview/006.php

.. literalinclude:: overview/022.php

Afirmaciones adicionales
------------------------

``CIUnitTestCase`` proporciona afirmaciones de pruebas unitarias adicionales que pueden resultarle útiles.

afirmarLogged($nivel, $mensaje esperado)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Asegúrese de que algo que esperaba que se registrara se haya registrado realmente:

afirmarLogContains($nivel, $logMessage)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Asegúrese de que haya un registro en los registros que contenga una parte del mensaje.

.. literalinclude:: overview/007.php

afirmarEventoTriggered($nombredelevento)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Asegúrese de que el evento que esperaba que se desencadenara realmente fuera:

.. literalinclude:: overview/008.php

afirmarHeaderEmitted($encabezado, $ignoreCase = falso)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Asegúrese de que realmente se haya emitido un encabezado o cookie:

.. literalinclude:: overview/009.php

.. note:: the test case with this should be `run as a separate process
    en unidad PHP<https://docs.phpunit.de/en/9.6/annotations.html#runinseparateprocess>` _.

afirmarHeaderNotEmitted($encabezado, $ignoreCase = falso)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ^^

Asegúrese de que no se haya emitido un encabezado o cookie:

.. literalinclude:: overview/010.php

.. note:: the test case with this should be `run as a separate process
    en unidad PHP<https://docs.phpunit.de/en/9.6/annotations.html#runinseparateprocess>` _.

afirmarCloseEnough($esperado, $actual, $mensaje = '', $tolerancia = 1)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^^^^^

Para pruebas de tiempo de ejecución extendido, prueba que la diferencia absoluta
entre el tiempo esperado y el real está dentro de la tolerancia prescrita:

.. literalinclude:: overview/011.php

La prueba anterior permitirá que el tiempo real sea 660 o 661 segundos.

afirmarCloseEnoughString($esperado, $actual, $mensaje = '', $tolerancia = 1)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^^^^^^^^^^^

Para pruebas de tiempo de ejecución extendido, prueba que la diferencia absoluta
entre la hora esperada y la real, formateada como cadenas, está dentro de la tolerancia prescrita:

.. literalinclude:: overview/012.php

La prueba anterior permitirá que el tiempo real sea 660 o 661 segundos.

Acceso a propiedades protegidas/privadas
----------------------------------------

Al realizar pruebas, puede utilizar los siguientes métodos de establecimiento y obtención para acceder a métodos protegidos y privados y
propiedades en las clases que está probando.

getPrivateMethodInvoker($instancia, $método)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Le permite llamar a métodos privados desde fuera de la clase. Esto devuelve una función que se puede llamar. La primera
El parámetro es una instancia de la clase a probar. El segundo parámetro es el nombre del método que desea llamar.

.. literalinclude:: overview/013.php

getPrivateProperty($instancia, $propiedad)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Recupera el valor de una propiedad de clase privada/protegida de una instancia de una clase. El primer parámetro es un
instancia de la clase a probar. El segundo parámetro es el nombre de la propiedad.

.. literalinclude:: overview/014.php

setPrivateProperty($instancia, $propiedad, $valor)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Establezca un valor protegido dentro de una instancia de clase. El primer parámetro es una instancia de la clase a probar. El segundo
El parámetro es el nombre de la propiedad para establecer el valor. El tercer parámetro es el valor para establecerlo:

.. literalinclude:: overview/015.php

Servicios de burla
==================

A menudo encontrará que necesita simular uno de los servicios definidos en **app/Config/Services.php** para limitar
sus pruebas solo al código en cuestión, mientras simula varias respuestas de los servicios. Esto es especialmente
Es cierto al probar controladores y otras pruebas de integración. La clase **Servicios** proporciona los siguientes métodos
para simplificar esto.

Servicios::injectMock()
----------------------

Este método le permite definir la instancia exacta que devolverá la clase Servicios. Puedes usar esto para
establecer propiedades de un servicio para que se comporte de cierta manera, o reemplazar un servicio con una clase simulada.

.. literalinclude:: overview/016.php

El primer parámetro es el servicio que está reemplazando. El nombre debe coincidir con el nombre de la función en los Servicios.
clase exactamente. El segundo parámetro es la instancia con la que reemplazarlo.

Servicios::restablecer()
------------------------

Elimina todas las clases simuladas de la clase Servicios y la devuelve a su estado original.

También puede utilizar el método ``$this->resetServices()`` que proporciona ``CIUnitTestCase``.

.. note:: This method resets the all states of Services, and the ``RouteCollection``
    no tendrá rutas. Si desea utilizar sus rutas para cargar, debe
    llame al método ``loadRoutes()`` como ``Services::routes()->loadRoutes()``.

Servicios::resetSingle(cadena $nombre)
--------------------------------------

Elimina cualquier instancia simulada y compartida de un único servicio, por su nombre.

.. note:: The ``Cache``, ``Email`` and ``Session`` services are mocked by default to prevent intrusive testing behavior. To prevent these from mocking remove their method callback from the class property: ``$setUpMethods = ['mockEmail', 'mockSession'];``

Burlarse de instancias de fábrica
=================================

De manera similar a Servicios, es posible que necesite proporcionar una instancia de clase preconfigurada
durante las pruebas que se utilizarán con ``Factories``. Utilice las mismas ``Factories::injectMock()`` y ``Factories::reset()``
métodos estáticos como **Servicios**, pero toman un parámetro anterior adicional para el
Nombre del componente:

.. literalinclude:: overview/017.php

.. note:: All component Factories are reset by default between each test. Modify your test case's ``$setUpMethods`` if you need instances to persist.

Pruebas y tiempo
================

Probar código que depende del tiempo puede ser un desafío. Sin embargo, al utilizar el
:doc:`Clase Hora <../libraries/time>`, la hora actual se puede fijar o cambiar
a voluntad durante la prueba.

A continuación se muestra un código de prueba de muestra que fija la hora actual:

.. literalinclude:: overview/021.php

Puede fijar la hora actual con el método ``Time::setTestNow()``.
Opcionalmente, puede especificar una configuración regional como segundo parámetro.

No olvide restablecer la hora actual después de la prueba llamándola sin
parámetros.

.. _testing-cli-output:

Prueba de salida CLI
====================

StreamFilterRasgo
-----------------

.. versionadded:: 7.0.0

**StreamFilterTrait** proporciona una alternativa a estos métodos auxiliares.

Es posible que necesite probar cosas que son difíciles de probar. A veces, capturar una secuencia, como el propio STDOUT o STDERR de PHP,
podría ser útil. ``StreamFilterTrait`` le ayuda a capturar el resultado de la secuencia de su elección.

**Resumen de métodos**

- ``StreamFilterTrait::getStreamFilterBuffer()`` Obtiene los datos capturados del búfer.
- ``StreamFilterTrait::resetStreamFilterBuffer()`` Restablecer los datos capturados.

Un ejemplo que demuestra esto dentro de uno de sus casos de prueba:

.. literalinclude:: overview/018.php

El ``StreamFilterTrait`` tiene un configurador que se llama automáticamente.
Ver :ref:`Prueba de rasgos<testing-overview-traits>` .

Si anula los métodos ``setUp()`` o ``tearDown()`` en su prueba, entonces debe llamar a ``parent::setUp()`` y
Métodos ``parent::tearDown()`` respectivamente para configurar ``StreamFilterTrait``.

CITestStreamFilter
------------------

**CITestStreamFilter** para uso manual/único.

Si necesita capturar transmisiones en una sola prueba, en lugar de usar el rasgo StreamFilterTrait, puede hacerlo manualmente.
agregar un filtro a las transmisiones.

**Resumen de métodos**

- ``CITestStreamFilter::registration()`` Registro de filtro.
- ``CITestStreamFilter::addOutputFilter()`` Agregar un filtro al flujo de salida.
- ``CITestStreamFilter::addErrorFilter()`` Agregando un filtro al flujo de errores.
- ``CITestStreamFilter::removeOutputFilter()`` Eliminando un filtro del flujo de salida.
- ``CITestStreamFilter::removeErrorFilter()`` Eliminando un filtro de la secuencia de errores.

.. literalinclude:: overview/020.php

.. _testing-cli-input:

Prueba de entrada CLI
=====================

PHPStreamWrapper
----------------

.. versionadded:: 7.0.0

**PhpStreamWrapper** proporciona una forma de escribir pruebas para métodos que requieren la entrada del usuario.
como ``CLI::prompt()``, ``CLI::wait()`` y ``CLI::input()``.

.. note:: The PhpStreamWrapper is a stream wrapper class.
    Si no conoce el contenedor de flujo de PHP,
    ver `La clase streamWrapper<https://www.php.net/manual/en/class.streamwrapper.php>` _
    en el manual de PHP.

**Resumen de métodos**

- ``PhpStreamWrapper::register()`` Registre ``PhpStreamWrapper`` en el protocolo ``php``.
- ``PhpStreamWrapper::restore()`` Restaura el contenedor del protocolo php nuevamente al contenedor integrado de PHP.
- ``PhpStreamWrapper::setContent()`` Establece los datos de entrada.

.. important:: The PhpStreamWrapper is intended for only testing ``php://stdin``.
    Pero cuando lo registras, maneja todo el protocolo `php<https://www.php.net/manual/en/wrappers.php.php>` _ corrientes,
    como ``php://stdout``, ``php://stderr``, ``php://memory``.
    Por lo tanto, se recomienda encarecidamente registrar o cancelar el registro de ``PhpStreamWrapper``.
    sólo cuando sea necesario. De lo contrario, interferirá con otras secuencias PHP integradas.
    mientras está registrado.

Un ejemplo que demuestra esto dentro de uno de sus casos de prueba:

.. literalinclude:: overview/019.php
