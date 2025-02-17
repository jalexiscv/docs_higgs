#########
Servicios
#########

.. contents::
    :local:
    :depth: 2

Introducción
************

¿Qué son los servicios?
=======================

Los **Servicios** en Higgs proporcionan la funcionalidad para crear y compartir nuevas instancias de clase.
Se implementa como la clase ``Config\Services``.

Todas las clases principales de Higgs se proporcionan como "servicios". Esto simplemente significa que, en lugar de
de codificar un nombre de clase para cargar, las clases a llamar se definen dentro de un
archivo de configuración. Este archivo actúa como un tipo de fábrica para crear nuevas instancias de la clase requerida.

¿Por qué utilizar los Servicios?
================================

Un ejemplo rápido probablemente aclarará las cosas, así que imagina que necesitas extraer una instancia
de la clase Temporizador. El método más sencillo sería simplemente crear una nueva instancia de esa clase:

.. literalinclude:: services/001.php

Y esto funciona muy bien. Hasta que decida que desea utilizar una clase de temporizador diferente en su lugar.
Quizás este tenga algunos informes avanzados que el temporizador predeterminado no proporciona. Para hacer esto,
ahora debe ubicar todas las ubicaciones en su aplicación en las que utilizó la clase de temporizador.
Dado que es posible que los haya dejado en su lugar para mantener un registro de rendimiento de su aplicación constantemente
en ejecución, esta podría ser una manera de manejar esto que requiere mucho tiempo y es propensa a errores. Ahí es donde los servicios
Ser util.

En lugar de crear la instancia nosotros mismos, dejamos que una clase central cree una instancia del
clase para nosotros. Esta clase se mantiene muy simple. Solo contiene un método para cada clase que queramos.
para utilizar como servicio. El método normalmente devuelve una **instancia compartida** de esa clase, pasando cualquier dependencia
podría tener en ello. Luego, reemplazaríamos nuestro código de creación del temporizador con un código que llame a esta nueva clase:

.. literalinclude:: services/002.php

Cuando necesite cambiar la implementación utilizada, puede modificar el archivo de configuración de servicios y
el cambio ocurre automáticamente en toda su aplicación sin que usted tenga que hacer nada. Ahora
sólo necesita aprovechar cualquier funcionalidad nueva y listo. Muy simple y
resistente a errores.

.. note:: It is recommended to only create services within controllers. Other files, like models and libraries should have the dependencies either passed into the constructor or through a setter method.

Cómo obtener un servicio
************************

Como muchas clases de Higgs se brindan como servicios, puede obtenerlas de la siguiente manera:

.. literalinclude:: services/013.php

``$typography`` es una instancia de la clase Typography, y si llamas a ``\Config\Services::typography()`` nuevamente, obtendrás exactamente la misma instancia.

Los Servicios normalmente devuelven una **instancia compartida** de la clase. El siguiente código crea una instancia ``CURLRequest`` en la primera llamada. Y la segunda llamada devuelve exactamente la misma instancia.

.. literalinclude:: services/015.php

Por lo tanto, el parámetro ``$options2`` para ``$client2`` no funciona. Simplemente se ignora.

Obtener una nueva instancia
===========================

Si desea obtener una nueva instancia de la clase Typography, debe pasar ``false`` al argumento ``$getShared``:

.. literalinclude:: services/014.php

Funciones de conveniencia
=========================

Se han proporcionado dos funciones para obtener un servicio. Estas funciones están siempre disponibles.

servicio()
---------

El primero es ``servicio()`` que devuelve una nueva instancia del servicio solicitado. El único
El parámetro requerido es el nombre del servicio. Este es el mismo que el nombre del método dentro de los Servicios.
El archivo siempre devuelve una instancia COMPARTIDA de la clase, por lo que llamar a la función varias veces debería
siempre devuelve la misma instancia:

.. literalinclude:: services/003.php

Si el método de creación requiere parámetros adicionales, se pueden pasar después del nombre del servicio:

.. literalinclude:: services/004.php

servicio_único()
----------------

La segunda función, ``single_service()`` funciona igual que ``service()`` pero devuelve una nueva instancia de
la clase:

.. literalinclude:: services/005.php

Definición de servicios
***********************

Para que los servicios funcionen bien, debe poder confiar en que cada clase tenga una API constante, o
`interfaz<https://www.php.net/manual/en/language.oop5.interfaces.php>` _, usar. Casi todo de
Las clases de Higgs proporcionan una interfaz a la que se adhieren. Cuando desea ampliar o reemplazar
clases principales, solo necesita asegurarse de cumplir con los requisitos de la interfaz y saber que
Las clases son compatibles.

Por ejemplo, la clase ``RouteCollection`` implementa ``RouteCollectionInterface``. Cuando usted
Si desea crear un reemplazo que proporcione una forma diferente de crear rutas, solo necesita
cree una nueva clase que implemente ``RouteCollectionInterface``:

.. literalinclude:: services/006.php

Finalmente, agregue el método ``routes()`` a **app/Config/Services.php** para crear una nueva instancia de ``MyRouteCollection``
en lugar de ``Higgs\Router\RouteCollection``:

.. literalinclude:: services/007.php

Permitir parámetros
===================

En algunos casos, querrás tener la opción de pasar una configuración a la clase durante la creación de instancias.
Dado que el archivo de servicios es una clase muy simple, es fácil hacer que esto funcione.

Un buen ejemplo es el servicio ``renderizador``. Por defecto, queremos que esta clase pueda
para encontrar las vistas en ``APPPATH. 'vistas/'``. Queremos que el desarrollador tenga la opción de
Sin embargo, cambiarán ese camino si sus necesidades así lo requieren. Entonces la clase acepta ``$viewPath``
como parámetro del constructor. El método de servicio se ve así:

.. literalinclude:: services/008.php

Esto establece la ruta predeterminada en el método constructor, pero permite cambiar fácilmente
la ruta que utiliza:

.. literalinclude:: services/009.php

Clases compartidas
==================

Hay ocasiones en las que es necesario exigir que solo se ejecute una única instancia de un servicio.
es creado. Esto se maneja fácilmente con el método ``getSharedInstance()`` que se llama desde dentro del
método de fábrica. Esto se encarga de comprobar si se ha creado y guardado una instancia.
dentro de la clase y, si no, crea una nueva. Todos los métodos de fábrica proporcionan una
Valor ``$getShared = true`` como último parámetro. También debes seguir el método:

.. literalinclude:: services/010.php

Descubrimiento de servicios
***************************

Higgs puede descubrir automáticamente cualquier archivo **Config/Services.php** que haya creado dentro de cualquier espacio de nombres definido.
Esto permite un uso sencillo de cualquier archivo de servicios de módulo. Para que se descubran archivos de servicios personalizados, deben
cumplir con estos requisitos:

- Su espacio de nombres debe estar definido en **app/Config/Autoload.php**
- Dentro del espacio de nombres, el archivo debe encontrarse en **Config/Services.php**
- Debe extender ``Higgs\Config\BaseService``

Un pequeño ejemplo debería aclarar esto.

Imagine que ha creado un nuevo directorio, **Blog** en el directorio raíz de su proyecto. Esto contendrá un **módulo de blog** con controladores,
modelos, etc., y le gustaría que algunas de las clases estén disponibles como servicio. El primer paso es crear un nuevo archivo:

**Blog/Config/Services.php**. El esqueleto del archivo debería ser:

.. literalinclude:: services/011.php

Ahora puede utilizar este archivo como se describe anteriormente. Cuando quieras tomar el servicio de publicaciones desde cualquier controlador,
simplemente usaría la clase ``Config\Services`` del framework para obtener su servicio:

.. literalinclude:: services/012.php

.. note:: If multiple Services files have the same method name, the first one found will be the instance returned.
