################
Enrutamiento URI
################

.. contents::
    :local:
    :depth: 3

¿Qué es el enrutamiento URI?
****************************

URI Routing asocia un URI con el método de un controlador.

Higgs tiene dos tipos de ruta. Uno es **Enrutamiento de ruta definida** y el otro es **Enrutamiento automático**.
Con Enrutamiento de ruta definida, puede definir rutas manualmente. Permite URL flexible.
Auto Routing enruta automáticamente las solicitudes HTTP según convenciones y ejecuta los métodos de controlador correspondientes. No es necesario definir rutas manualmente.

Primero, veamos el enrutamiento de ruta definida. Si desea utilizar el enrutamiento automático, consulte :ref:`auto-routing-improved`.

.. _defined-route-routing:

Establecer reglas de enrutamiento
*********************************

Las reglas de enrutamiento se definen en el archivo **app/Config/Routes.php**. En él verás que
crea una instancia de la clase RouteCollection (``$routes``) que le permite especificar sus propios criterios de ruta.
Las rutas se pueden especificar utilizando marcadores de posición o expresiones regulares.

Cuando especifica una ruta, elige un método correspondiente a los verbos HTTP (método de solicitud).
Si espera una solicitud GET, utilice el método ``get()``:

.. literalinclude:: routing/001.php

Una ruta toma la **Ruta de ruta** (ruta URI relativa a BaseURL. ``/``) a la izquierda,
y lo asigna al **Manejador de ruta** (controlador y método ``Home::index``) a la derecha,
junto con cualquier parámetro que deba pasarse al controlador.

El controlador y el método deben
listarse de la misma manera que usaría un método estático, separando la clase
y su método con dos puntos, como ``Usuarios::lista``.

Si ese método requiere que los parámetros sean
pasados, entonces se enumerarán después del nombre del método, separados por barras diagonales:

.. literalinclude:: routing/002.php

Ejemplos
========

A continuación se muestran algunos ejemplos de enrutamiento básicos.

Una URL que contenga la palabra **revistas** en el primer segmento se asignará a la clase ``\App\Controllers\Blogs``.
y el método predeterminado, que suele ser ``index()``:

.. literalinclude:: routing/006.php

Una URL que contenga los segmentos **blog/joe** se asignará a la clase ``\App\Controllers\Blogs`` y al método ``users()``.
El ID se establecerá en ``34``:

.. literalinclude:: routing/007.php

Una URL con **producto** como primer segmento y cualquier elemento del segundo se asignará a la clase ``\App\Controllers\Catalog``.
y el método ``productLookup()``:

.. literalinclude:: routing/008.php

Una URL con **producto** como primer segmento y un número en el segundo se asignará a la clase ``\App\Controllers\Catalog``
y el método ``productLookupByID()`` pasando la coincidencia como una variable al método:

.. literalinclude:: routing/009.php

.. _routing-http-verb-routes:

Rutas de verbos HTTP
====================

Puede utilizar cualquier verbo HTTP estándar (GET, POST, PUT, DELETE, OPTIONS, etc.):

.. literalinclude:: routing/003.php

Puedes proporcionar varios verbos que una ruta debe coincidir pasándolos como una matriz al método ``match()``:

.. literalinclude:: routing/004.php

Especificación de controladores de ruta
=======================================

.. _controllers-namespace:

Espacio de nombres del controlador
----------------------

Cuando especifica un controlador y un nombre de método como una cadena, si un controlador es
escrito sin un ``\`` inicial, el :ref:`routing-default-namespace` será
antepuesto:

.. literalinclude:: routing/063.php

Si pones ``\`` al principio, se trata como un nombre de clase completo:

.. literalinclude:: routing/064.php

También puedes especificar el espacio de nombres con la opción ``namespace``:

.. literalinclude:: routing/038.php

Consulte :ref:`assigning-namespace` para obtener más detalles.

Sintaxis invocable de matriz
---------------------

.. versionadded:: 4.2.0

Desde v7.2.0, puede usar la sintaxis de matriz invocable para especificar el controlador:

.. literalinclude:: routing/013.php
   :lines: 2-

O usando la palabra clave ``usar``:

.. literalinclude:: routing/014.php
   :lines: 2-

Si olvida agregar ``use App\Controllers\Home;``, el nombre de clase del controlador es
interpretado como ``Config\Home``, no como ``App\Controllers\Home`` porque
**app/Config/Routes.php** tiene ``namespace Config;`` en la parte superior.

.. note:: When you use Array Callable Syntax, the classname is always interpreted
    como un nombre de clase completamente calificado. Entonces :ref:`routing-default-namespace` y
    :ref:`opción de espacio de nombres<assigning-namespace>`  no tiene ningún efecto.

Sintaxis y marcadores de posición de matrices invocables
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Si hay marcadores de posición, establecerá automáticamente los parámetros en el orden especificado:

.. literalinclude:: routing/015.php
   :lines: 2-

Pero es posible que los parámetros configurados automáticamente no sean correctos si utiliza expresiones regulares en las rutas.
En tal caso, puede especificar los parámetros manualmente:

.. literalinclude:: routing/016.php
   :lines: 2-

Usando cierres
--------------

Puede utilizar una función anónima, o Cierre, como destino al que se asigna una ruta. Esta función será
ejecutado cuando el usuario visita ese URI. Esto es útil para ejecutar rápidamente tareas pequeñas o incluso simplemente mostrar
una vista sencilla:

.. literalinclude:: routing/020.php

Especificación de rutas de ruta
===============================

Marcadores de posición
------------

Una ruta típica podría verse así:

.. literalinclude:: routing/005.php

En una ruta, el primer parámetro contiene el URI que debe coincidir, mientras que el segundo parámetro
contiene el destino al que debe enrutarse. En el ejemplo anterior, si la palabra literal
"producto" se encuentra en el primer segmento de la ruta URL y se encuentra un número en el segundo segmento,
en su lugar se utilizan la clase ``Catalog`` y el método ``productLookup``.

Los marcadores de posición son simplemente cadenas que representan un patrón de expresión regular. durante la ruta
proceso, estos marcadores de posición se reemplazan con el valor de la expresión regular. son principalmente
utilizado para facilitar la lectura.

Los siguientes marcadores de posición están disponibles para que los utilice en sus rutas:
============ ======================================== ==================================================== ====================
Descripción de los marcadores de posición
============ ======================================== ==================================================== ====================
(:any) coincidirá con todos los caracteres desde ese punto hasta el final del URI. Esto puede incluir múltiples segmentos de URI.
(:segmento) coincidirá con cualquier carácter excepto una barra diagonal (``/``) que restringe el resultado a un solo segmento.
(:num) coincidirá con cualquier número entero.
(:alpha) coincidirá con cualquier cadena de caracteres alfabéticos
(:alphanum) coincidirá con cualquier cadena de caracteres alfabéticos o números enteros, o cualquier combinación de los dos.
(:hash) es lo mismo que ``(:segment)``, pero se puede usar para ver fácilmente qué rutas usan identificadores hash.
============ ======================================== ==================================================== ====================

.. note:: ``{locale}`` cannot be used as a placeholder or other part of the route, as it is reserved for use
    en :doc:`localización</outgoing/localization>` .

.. _routing-placeholder-any:

El comportamiento de (:cualquiera)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Tenga en cuenta que un único ``(:any)`` coincidirá con varios segmentos de la URL, si están presentes.

Por ejemplo la ruta:

.. literalinclude:: routing/010.php

coincidirá con **producto/123**, **producto/123/456**, **producto/123/456/789** y así sucesivamente.

En el ejemplo anterior, si el marcador de posición ``$1`` contiene una barra diagonal
(``/``), aún se dividirá en múltiples parámetros cuando se pase a
``Catálogo::productLookup()``.

La implementación en el
El controlador debe tener en cuenta los parámetros máximos:

.. literalinclude:: routing/011.php

O puede utilizar `listas de argumentos de longitud variable<https://www.php.net/manual/en/functions.arguments.php#functions.variable-arg-list>` _:

.. literalinclude:: routing/068.php

.. important:: Do not put any placeholder after ``(:any)``. Because the number of
    Los parámetros pasados al método del controlador pueden cambiar.

Si hacer coincidir múltiples segmentos no es el comportamiento deseado, se debe utilizar ``(:segmento)`` al definir el
rutas. Con las URL de ejemplo de arriba:

.. literalinclude:: routing/012.php

solo coincidirá con **producto/123** y generará errores 404 para otro ejemplo.

Marcadores de posición personalizados
-------------------

Puede crear sus propios marcadores de posición que pueden usarse en su archivo de rutas para personalizar completamente la experiencia.
y legibilidad.

Agrega nuevos marcadores de posición con el método ``addPlaceholder()``. El primer parámetro es la cadena que se utilizará como
el marcador de posición. El segundo parámetro es el patrón de expresión regular por el que debe reemplazarse.
Esto debe llamarse antes de agregar la ruta:

.. literalinclude:: routing/017.php

Expresiones regulares
-------------------

Si lo prefiere, puede utilizar expresiones regulares para definir sus reglas de enrutamiento. Cualquier expresión regular válida
está permitido, al igual que las referencias anteriores.

.. important:: Note: If you use back-references you must use the dollar syntax rather than the double backslash syntax.
    Una ruta RegEx típica podría verse así:

    .. literalinclude:: routing/018.php

En el ejemplo anterior, un URI similar a **productos/camisas/123** llamaría al método ``show()``.
de la clase de controlador ``Productos``, con el primer y segundo segmento originales pasados como argumentos.

Con expresiones regulares, también puede capturar un segmento que contenga una barra diagonal (``/``), que normalmente
Representa el delimitador entre múltiples segmentos.

Por ejemplo, si un usuario accede a un área protegida con contraseña de su aplicación web y desea poder
Redirigirlos de nuevo a la misma página después de que inicien sesión. Este ejemplo puede resultarle útil:

.. literalinclude:: routing/019.php

En el ejemplo anterior, si el marcador de posición ``$1`` contiene una barra diagonal
(``/``), aún se dividirá en múltiples parámetros cuando se pase a
``Autentificación::iniciar sesión()``.

Para aquellos de ustedes que no conocen las expresiones regulares y quieren aprender más sobre ellas,
`expresiones-regulares.info<https://www.regular-expressions.info/>` _ podría ser un buen punto de partida.

.. note:: You can also mix and match placeholders with regular expressions.

.. _view-routes:

Ver rutas
=========

.. versionadded:: 7.0.0

Si solo desea representar una vista que no tiene lógica asociada, puede usar el método ``view()``.
Esto siempre se trata como una solicitud GET.
Este método acepta el nombre de la vista a cargar como segundo parámetro.

.. literalinclude:: routing/065.php

Si utiliza marcadores de posición dentro de su ruta, puede acceder a ellos dentro de la vista en una variable especial, ``$segmentos``.
Están disponibles como una matriz, indexados en el orden en que aparecen en la ruta.

.. literalinclude:: routing/066.php

.. _redirecting-routes:

Redirigir rutas
===============

Cualquier sitio que dure lo suficiente seguramente tendrá páginas que se mueven. Puede especificar rutas que deben redirigir
a otras rutas con el método ``addRedirect()``. El primer parámetro es el patrón URI de la ruta anterior. El
El segundo parámetro es el nuevo URI al que redirigir o el nombre de una ruta con nombre. El tercer parámetro es
el código de estado HTTP que debe enviarse junto con la redirección. El valor predeterminado es ``302``, que es temporal.
redirigir y se recomienda en la mayoría de los casos:

.. literalinclude:: routing/022.php

.. note:: Since v7.2.0, ``addRedirect()`` can use placeholders.

Si una ruta de redireccionamiento coincide durante la carga de una página, el usuario será redirigido inmediatamente a la nueva página antes de que
El controlador se puede cargar.

Restricciones ambientales
=========================

Puede crear un conjunto de rutas que solo serán visibles en un entorno determinado. Esto le permite crear
herramientas que solo el desarrollador puede usar en sus máquinas locales y a las que no se puede acceder en servidores de prueba o producción.
Esto se puede hacer con el método ``environment()``. El primer parámetro es el nombre del entorno. Cualquier
Las rutas definidas dentro de este cierre solo son accesibles desde el entorno dado:

.. literalinclude:: routing/028.php

Rutas con cualquier verbo HTTP
==============================

.. important:: This method exists only for backward compatibility. Do not use it
    en nuevos proyectos. Incluso si ya lo estás usando, te recomendamos que uses
    otro método más apropiado.

.. warning:: While the ``add()`` method seems to be convenient, it is recommended to always use the HTTP-verb-based
    rutas, descritas anteriormente, ya que son más seguras. Si utiliza la protección :doc:`CSRF</libraries/security>` , no protege **GET**
    peticiones. Si el URI especificado en el método ``add()`` es accesible mediante el método GET, la protección CSRF
    no trabajará.

Es posible definir una ruta con cualquier verbo HTTP.
Puedes usar el método ``add()``:

.. literalinclude:: routing/031.php

.. note:: Using the HTTP-verb-based routes will also provide a slight performance increase, since
    solo se almacenan las rutas que coinciden con el método de solicitud actual, lo que da como resultado menos rutas para escanear
    al intentar encontrar una coincidencia.

Mapeo de múltiples rutas
========================

.. important:: This method exists only for backward compatibility. Do not use it
    en nuevos proyectos. Incluso si ya lo estás usando, te recomendamos que uses
    otro método más apropiado.

.. warning:: The ``map()`` method is not recommended as well as ``add()``
    porque llama a ``add()`` internamente.

Si bien el método ``add()`` es fácil de usar, a menudo es más práctico trabajar con múltiples rutas a la vez, usando
el método ``mapa()``. En lugar de llamar al método ``add()`` para cada ruta que necesite agregar, puede
defina una matriz de rutas y luego pásela como primer parámetro al método ``map()``:

.. literalinclude:: routing/021.php

.. _command-line-only-routes:

Rutas solo de línea de comandos
===============================

.. note:: It is recommended to use Spark Commands for CLI scripts instead of calling controllers via CLI.
    Consulte la página :doc:`../cli/cli_commands` para obtener información detallada.

Cualquier ruta creada por cualquiera de los métodos basados en verbos HTTP.
Los métodos de ruta tampoco serán accesibles desde la CLI, pero las rutas creadas por el método ``add()`` seguirán siendo
disponible desde la línea de comando.

Puede crear rutas que funcionen solo desde la línea de comandos y que sean inaccesibles desde el navegador web, con la
Método ``cli()``:

.. literalinclude:: routing/032.php

.. warning:: If you enable :ref:`auto-routing-legacy` and place the command file in **app/Controllers**,
    cualquiera podría acceder al comando con la ayuda de Auto Routing (Legacy) a través de HTTP.

Opciones globales
*****************

Todos los métodos para crear una ruta (``get()``, ``post()``, :doc:`resource()<restful>`  etc) puede tomar una variedad de opciones que
puede modificar las rutas generadas, o restringirlas aún más. La matriz ``$options`` es siempre el último parámetro:

.. literalinclude:: routing/033.php

.. _applying-filters:

Aplicar filtros
===============

Puede alterar el comportamiento de rutas específicas proporcionando filtros para ejecutar antes o después del controlador. Esto es especialmente útil durante la autenticación o el registro de API.
El valor del filtro puede ser una cadena o una matriz de cadenas:

* coincide con los alias definidos en **app/Config/Filters.php**.
* filtrar nombres de clases

Ver :doc:`Filtros del controlador<filters>`  para obtener más información sobre cómo configurar filtros.

.. Warning:: If you set filters to routes in **app/Config/Routes.php**
    (no en **app/Config/Filters.php**), se recomienda desactivar el enrutamiento automático (heredado).
    Cuando :ref:`auto-routing-legacy` está habilitado, es posible que se pueda acceder a un controlador
    a través de una URL diferente a la ruta configurada,
    en cuyo caso no se aplicará el filtro que especificaste para la ruta.
    Consulte :ref:`use-available-routes-only` para deshabilitar el enrutamiento automático.

Filtro de alias
------------

Especifica un alias definido en **app/Config/Filters.php** para el valor del filtro:

.. literalinclude:: routing/034.php

También puede proporcionar argumentos para pasar a los métodos ``before()`` y ``after()`` del filtro de alias:

.. literalinclude:: routing/035.php

Filtro de nombre de clase
----------------

.. versionadded:: 4.1.5

Usted especifica un nombre de clase de filtro para el valor del filtro:

.. literalinclude:: routing/036.php

Múltiples filtros
----------------

.. versionadded:: 4.1.5

.. important:: *Multiple filters* is disabled by default. Because it breaks backward compatibility. If you want to use it, you need to configure. See :ref:`upgrade-415-multiple-filters-for-a-route` for the details.

Usted especifica una matriz para el valor del filtro:

.. literalinclude:: routing/037.php

Filtrar argumentos
^^^^^^^^^^^^^^^^^^

Se pueden pasar argumentos adicionales a un filtro:

.. literalinclude:: routing/067.php

En este ejemplo, la matriz ``['dual', 'noreturn']`` se pasará en ``$arguments``
a los métodos de implementación ``before()`` y ``after()`` del filtro.

.. _assigning-namespace:

Asignar espacio de nombres
==========================

Si bien se antepondrá un :ref:`routing-default-namespace` a los controladores generados, también puede especificar
un espacio de nombres diferente para ser usado en cualquier matriz de opciones, con la opción ``espacio de nombres``. El valor debe ser el
espacio de nombres que desea modificar:

.. literalinclude:: routing/038.php

El nuevo espacio de nombres solo se aplica durante esa llamada para cualquier método que cree una ruta única, como get, post, etc.
Para cualquier método que cree múltiples rutas, el nuevo espacio de nombres se adjunta a todas las rutas generadas por esa función.
o, en el caso de ``group()``, todas las rutas generadas durante el cierre.

Limitar al nombre de host
=========================

Puede restringir grupos de rutas para que funcionen solo en ciertos dominios o subdominios de su aplicación.
pasando la opción "nombre de host" junto con el dominio deseado para permitirlo como parte de la matriz de opciones:

.. literalinclude:: routing/039.php

Este ejemplo solo permitiría que los hosts especificados funcionaran si el dominio coincidiera exactamente con **cuentas.ejemplo.com**.
No funcionaría en el sitio principal en **example.com**.

Limitar a subdominios
=====================

Cuando la opción ``subdominio`` está presente, el sistema restringirá las rutas para que solo estén disponibles en ese
subdominio. La ruta solo coincidirá si el subdominio es aquel a través del cual se está viendo la aplicación:

.. literalinclude:: routing/040.php

Puede restringirlo a cualquier subdominio estableciendo el valor en un asterisco (``*``). Si estás viendo desde una URL
que no tiene ningún subdominio presente, este no será coincidente:

.. literalinclude:: routing/041.php

.. important:: The system is not perfect and should be tested for your specific domain before being used in production.
    La mayoría de los dominios deberían funcionar bien, pero algunos casos extremos, especialmente con un punto en el dominio mismo (no utilizado)
    para separar sufijos o www) puede conducir potencialmente a falsos positivos.

Compensación de los parámetros coincidentes
===========================================

Puede compensar los parámetros coincidentes en su ruta con cualquier valor numérico con la opción ``compensación``, con el
siendo el valor el número de segmentos a compensar.

Esto puede resultar beneficioso al desarrollar API en las que el primer segmento de URI sea el número de versión. También puede
usarse cuando el primer parámetro es una cadena de idioma:

.. literalinclude:: routing/042.php

.. _reverse-routing:

Enrutamiento inverso
********************

El enrutamiento inverso le permite definir el controlador y el método, así como cualquier parámetro, al que debe ir un enlace.
y haga que el enrutador busque la ruta actual hacia él. Esto permite que las definiciones de ruta cambien sin que usted tenga que
para actualizar el código de su aplicación. Esto normalmente se usa dentro de las vistas para crear enlaces.

Por ejemplo, si tiene una ruta a una galería de fotos a la que desea vincular, puede usar el asistente :php:func:`url_to()`.
función para obtener la ruta que se debe utilizar. El primer parámetro es el controlador y el método completamente calificados.
separados por dos puntos dobles (``::``), muy parecido a lo que usaría al escribir la ruta inicial. Cualquier parámetro que
se debe pasar a la ruta que se pasa en la siguiente:

.. literalinclude:: routing/029.php

.. _using-named-routes:

Rutas con nombre
****************

Puede nombrar rutas para que su aplicación sea menos frágil. Esto aplica un nombre a una ruta que se puede llamar.
más tarde, e incluso si la definición de ruta cambia, todos los enlaces en su aplicación creados con :php:func:`url_to()`
seguirá funcionando sin que tengas que hacer ningún cambio. Una ruta se nombra pasando la opción ``as``
con el nombre de la ruta:

.. literalinclude:: routing/030.php

Esto también tiene el beneficio adicional de hacer que las vistas sean más legibles.

Rutas de agrupación
*******************

Puedes agrupar tus rutas bajo un nombre común con el método ``group()``. El nombre del grupo se convierte en un segmento que
aparece antes de las rutas definidas dentro del grupo. Esto le permite reducir la escritura necesaria para crear un
Amplio conjunto de rutas que comparten la cadena de apertura, como cuando se construye un área de administración:

.. literalinclude:: routing/023.php

Esto prefijaría los URI de **usuarios** y **blog** con **admin**, manejando URL como **admin/usuarios** y **admin/blog**.

Configuración del espacio de nombres
====================================

Si necesita asignar opciones a un grupo, como :ref:`assigning-namespace`, hágalo antes de la devolución de llamada:

.. literalinclude:: routing/024.php

Esto manejaría una ruta de recursos al controlador ``App\API\v1\Users`` con el URI **api/users**.

Configuración de filtros
========================

También puedes usar un filtro :doc:`específico<filters>`  para un grupo de rutas. Esto siempre será
ejecute el filtro antes o después del controlador. Esto es especialmente útil durante la autenticación o el registro de API:

.. literalinclude:: routing/025.php

El valor del filtro debe coincidir con uno de los alias definidos en **app/Config/Filters.php**.

Configuración de otras opciones
===============================

En algún momento, es posible que desees agrupar rutas con el fin de aplicar filtros u otras rutas.
opciones de configuración como espacio de nombres, subdominio, etc. Sin necesidad de agregar necesariamente un prefijo al grupo, puede pasar
una cadena vacía en lugar del prefijo y las rutas en el grupo se enrutarán como si el grupo nunca existiera pero con el
opciones de configuración de ruta dadas:

.. literalinclude:: routing/027.php

Grupos de anidación
===================

Es posible anidar grupos dentro de grupos para una organización más precisa si lo necesita:

.. literalinclude:: routing/026.php

Esto manejaría la URL en **admin/users/list**.

.. note:: Options passed to the outer ``group()`` (for example ``namespace`` and ``filter``) are not merged with the inner ``group()`` options.

.. _routing-priority:

Prioridad de ruta
*****************

Las rutas se registran en la tabla de enrutamiento en el orden en que se definen. Esto significa que cuando se accede a un URI, se ejecutará la primera ruta coincidente.

.. warning:: If a route path is defined more than once with different handlers, only the first defined route is registered.

Puede verificar las rutas registradas en la tabla de enrutamiento ejecutando :ref:`spark route<routing-spark-routes>` comando.

Cambiar la prioridad de la ruta
===============================

Cuando se trabaja con módulos, puede ser un problema si las rutas de la aplicación contienen comodines.
Entonces las rutas del módulo no se procesarán correctamente.
Puede resolver este problema reduciendo la prioridad del procesamiento de rutas usando la opción ``prioridad``. El parámetro
acepta números enteros positivos y cero. Cuanto mayor sea el número especificado en la "prioridad", menor
prioridad de ruta en la cola de procesamiento:

.. literalinclude:: routing/043.php

Para deshabilitar esta funcionalidad, debes llamar al método con el parámetro ``false``:

.. literalinclude:: routing/044.php

.. note:: By default, all routes have a priority of 0.
    Los números enteros negativos se convertirán al valor absoluto.

.. _routes-configuration-options:

Opciones de configuración de rutas
**********************************

La clase RoutesCollection proporciona varias opciones que afectan a todas las rutas y se pueden modificar para satisfacer sus necesidades.
necesidades de la aplicación. Estas opciones están disponibles en **app/Config/Routing.php**.

.. note:: The config file **app/Config/Routing.php** has been added since v7.4.0.
    En versiones anteriores, los métodos de configuración se usaban en **app/Config/Routes.php**
    para cambiar la configuración.

.. _routing-default-namespace:

Espacio de nombres predeterminado
=================================

Al hacer coincidir un controlador con una ruta, el enrutador agregará el valor del espacio de nombres predeterminado al frente del controlador.
especificado por la ruta. De forma predeterminada, este valor es ``App\Controllers``.

Si establece el valor de cadena vacía (``''``), deja que cada ruta especifique el espacio de nombres completo
controlador:

.. literalinclude:: routing/045.php

Si sus controladores no tienen un espacio de nombres explícito, no es necesario cambiarlo. Si asigna un espacio de nombres a sus controladores,
entonces puedes cambiar este valor para ahorrar escribiendo:

.. literalinclude:: routing/046.php

Traducir guiones URI
====================

Esta opción le permite reemplazar automáticamente guiones (``-``) con guiones bajos en el controlador y el método.
Segmentos URI cuando se utilizan en enrutamiento automático, lo que le ahorra entradas de ruta adicionales si necesita hacerlo. Esto es necesario porque el guión no es un carácter válido de nombre de clase o método y causaría un error fatal si intenta usarlo:

.. literalinclude:: routing/049.php

.. note:: When using Auto Routing (Improved), prior to v7.4.0, if
    ``$translateURIDashes`` es verdadero, dos URI corresponden a un único controlador
    método, un URI para guiones (por ejemplo, **foo-bar**) y un URI para guiones bajos
    (por ejemplo, **foo_bar**). Este fue un comportamiento incorrecto. Desde v7.4.0, el URI para
    Los guiones bajos (**foo_bar**) no son accesibles.

.. _use-defined-routes-only:

Utilice únicamente rutas definidas
==================================

Desde v7.2.0, el enrutamiento automático está deshabilitado de forma predeterminada.

Cuando no se encuentra una ruta definida que coincida con el URI, el sistema intentará hacer coincidir ese URI con el
controladores y métodos cuando el enrutamiento automático está habilitado.

Puedes desactivar esta coincidencia automática y restringir rutas.
solo a aquellos definidos por usted, estableciendo la propiedad ``$autoRoute`` en falso:

.. literalinclude:: routing/050.php

.. warning:: If you use the :doc:`CSRF protection </libraries/security>`, it does not protect **GET**
    peticiones. Si se puede acceder al URI mediante el método GET, la protección CSRF no funcionará.

Anulación 404
=============

Cuando no se encuentra una página que coincida con el URI actual, el sistema mostrará un
vista genérica 404. Usando la propiedad ``$override404`` dentro de la configuración de enrutamiento
archivo, puede definir la clase/método de controlador para rutas 404.

.. literalinclude:: routing/051.php

También puedes cambiar lo que sucede especificando una acción que sucederá con el
Método ``set404Override()`` en el archivo de configuración de Rutas. El valor puede ser un
par clase/método válido, o un cierre:

.. literalinclude:: routing/069.php

.. note:: The 404 Override feature does not change the Response status code to ``404``.
    Si no configura el código de estado en el controlador que configuró, el código de estado predeterminado ``200``
    Será devuelto. Consulte :php:meth:`Higgs\\HTTP\\Response::setStatusCode()` para
    información sobre cómo configurar el código de estado.

Procesamiento de ruta por prioridad
===================================

Habilita o deshabilita el procesamiento de la cola de rutas por prioridad. Bajar la prioridad se define en la opción de ruta.
Deshabilitado por defecto. Esta funcionalidad afecta a todas las rutas.
Para ver un ejemplo de cómo reducir la prioridad, consulte :ref:`routing-priority`:

.. literalinclude:: routing/052.php

.. _auto-routing-improved:

Ruta automática (mejorada)
**************************

.. versionadded:: 4.2.0

Desde la versión 4.2.0, se introdujo el nuevo enrutamiento automático más seguro.

.. note:: If you are familiar with Auto Routing, which was enabled by default
    desde Higgs 3 hasta 4.1.x, puedes ver las diferencias en
    :ref:`Registro de cambios v7.2.0<v420-new-improved-auto-routing>` .

Cuando no se encuentra una ruta definida que coincida con el URI, el sistema intentará hacer coincidir ese URI con los controladores y métodos cuando el enrutamiento automático esté habilitado.

.. important:: For security reasons, if a controller is used in the defined routes, Auto Routing (Improved) does not route to the controller.

El enrutamiento automático puede enrutar automáticamente solicitudes HTTP según convenciones
y ejecutar los métodos de controlador correspondientes.

.. note:: Auto Routing (Improved) is disabled by default. To use it, see below.

.. _enabled-auto-routing-improved:

Habilitar enrutamiento automático
=================================

Para usarlo, necesita cambiar la configuración de la opción ``$autoRoute`` a ``true`` en **app/Config/Routing.php**::

    bool público $autoRoute = verdadero;

Y necesita cambiar la propiedad ``$autoRoutesImproved`` a ``true`` en **app/Config/Feature.php**::

    public bool $autoRoutesImproved = verdadero;

Segmentos URI
=============

Los segmentos en la URL, siguiendo el enfoque Modelo-Vista-Controlador, generalmente representan::

    ejemplo.com/class/method/ID

1. El primer segmento representa la **clase** del controlador que debe invocarse.
2. El segundo segmento representa la clase **método** que se debe llamar.
3. El tercer segmento y cualquier segmento adicional representan el ID y cualquier variable que se pasará al controlador.

Considere este URI::

    ejemplo.com/index.php/helloworld/hello/1

En el ejemplo anterior, cuando envía una solicitud HTTP con el método **GET**,
El enrutamiento automático intentaría encontrar un controlador llamado ``App\Controllers\Helloworld``
y ejecuta el método ``getHello()`` pasando ``'1'`` como primer argumento.

.. note:: A controller method that will be executed by Auto Routing (Improved) needs HTTP verb (``get``, ``post``, ``put``, etc.) prefix like ``getIndex()``, ``postCreate()``.

Ver :ref:`Enrutamiento automático en controladores<controller-auto-routing-improved>` para más información.

.. _routing-auto-routing-improved-configuration-options:

Opciones de configuración
=========================

Estas opciones están disponibles en el archivo **app/Config/Routing.php**.

Controlador predeterminado
------------------

Para URI raíz del sitio
^^^^^^^^^^^^^^^^^^^^^^^

Cuando un usuario visita la raíz de su sitio (es decir, **ejemplo.com**), el controlador
a utilizar está determinado por el valor establecido en la propiedad ``$defaultController``,
a menos que exista una ruta para ello explícitamente.

El valor predeterminado para esto es ``Home`` que coincide con el controlador en
**aplicación/Controladores/Home.php**::

    cadena pública $defaultController = 'Inicio&#39;;

Para URI de directorio
^^^^^^^^^^^^^^^^^^^^^^

El controlador predeterminado también se utiliza cuando no se ha encontrado ninguna ruta coincidente y el URI apuntaría a un directorio.
en el directorio de controladores. Por ejemplo, si el usuario visita **ejemplo.com/admin**, si se encontró un controlador en
**app/Controllers/Admin/Home.php**, se usaría.

.. important:: You cannot access the default controller with the URI of the controller name.
    Cuando el controlador predeterminado es ``Home``, puede acceder a **example.com/**, pero si accede a **example.com/home**, no lo encontrará.

Ver :ref:`Enrutamiento automático en controladores<controller-auto-routing-improved>` para más información.

Método predeterminado
--------------

Esto funciona de manera similar a la configuración predeterminada del controlador, pero se usa para determinar el método predeterminado que se utiliza.
cuando se encuentra un controlador que coincide con el URI, pero no existe ningún segmento para el método. El valor predeterminado es
``índice``.

En este ejemplo, si el usuario visitara **ejemplo.com/productos** y un ``Productos``
Si existiera el controlador, se ejecutaría el método ``Products::getListAll()``::

    cadena pública $defaultMethod = 'listaTodo&#39;;

.. important:: You cannot access the controller with the URI of the default method name.
    En el ejemplo anterior, puede acceder a **example.com/products**, pero si accede a **example.com/products/listall**, no se encontrará.

.. _auto-routing-improved-module-routing:

Enrutamiento del módulo
=======================

.. versionadded:: 4.4.0

Puedes usar el enrutamiento automático incluso si usas :doc:`../general/modules` y colocas
los controladores en un espacio de nombres diferente.

Para enrutar a un módulo, la propiedad ``$moduleRoutes`` en **app/Config/Routing.php**
se debe establecer::

    matriz pública $moduleRoutes = [
        'blog' => 'Acme\Blog\Controllers',
    ];

La clave es el primer segmento URI del módulo y el valor es el controlador.
espacio de nombres. En la configuración anterior, **http://localhost:8080/blog/foo/bar**
será enrutado a ``Acme\Blog\Controllers\Foo::getBar()``.

.. note:: If you define ``$moduleRoutes``, the routing for the module takes
    precedencia. En el ejemplo anterior, incluso si tiene la ``App\Controllers\Blog``
    controlador, **http://localhost:8080/blog** se enrutará al valor predeterminado
    controlador ``Acme\Blog\Controllers\Home``.

.. _auto-routing-legacy:

Enrutamiento automático (heredado)
**********************************

.. important:: This feature exists only for backward compatibility. Do not use it
    en nuevos proyectos. Incluso si ya lo estás usando, te recomendamos que uses
    el :ref:`auto-routing-improved` en su lugar.

Auto Routing (Legacy) es un sistema de enrutamiento de Higgs 3.
Puede enrutar automáticamente solicitudes HTTP según convenciones y ejecutar los métodos de controlador correspondientes.

Se recomienda que todas las rutas estén definidas en el archivo **app/Config/Routes.php**,
o usar :ref:`auto-routing-mejorado`,

.. warning:: To prevent misconfiguration and miscoding, we recommend that you do not use
    Función de enrutamiento automático (heredado). Es fácil crear aplicaciones vulnerables donde el controlador filtra
    o la protección CSRF se omiten.

.. important:: Auto Routing (Legacy) routes a HTTP request with **any** HTTP method to a controller method.

Habilitar enrutamiento automático (heredado)
============================================

Desde v7.2.0, el enrutamiento automático está deshabilitado de forma predeterminada.

Para usarlo, necesita cambiar la configuración de la opción ``$autoRoute`` a ``true`` en **app/Config/Routing.php**::

    bool público $autoRoute = verdadero;

Y establezca la propiedad ``$autoRoutesImproved`` en ``false`` en **app/Config/Feature.php**::

    public bool $autoRoutesImproved = false;

Segmentos URI (heredados)
=========================

Los segmentos en la URL, siguiendo el enfoque Modelo-Vista-Controlador, generalmente representan::

    ejemplo.com/class/method/ID

1. El primer segmento representa la **clase** del controlador que debe invocarse.
2. El segundo segmento representa la clase **método** que se debe llamar.
3. El tercer segmento y cualquier segmento adicional representan el ID y cualquier variable que se pasará al controlador.

Considere este URI::

    ejemplo.com/index.php/helloworld/index/1

En el ejemplo anterior, Higgs intentaría encontrar un controlador llamado **Helloworld.php**
y ejecuta el método ``index()`` pasando ``'1'`` como primer argumento.

Ver :ref:`Enrutamiento automático (heredado) en controladores<controller-auto-routing-legacy>` para más información.

.. _routing-auto-routing-legacy-configuration-options:

Opciones de configuración (heredadas)
=====================================

Estas opciones están disponibles en el archivo **app/Config/Routing.php**.

Controlador predeterminado (heredado)
---------------------------

Para URI raíz del sitio (heredado)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Cuando un usuario visita la raíz de su sitio (es decir, **ejemplo.com**), el controlador
a utilizar está determinado por el valor establecido en la propiedad ``$defaultController``,
a menos que exista una ruta para ello explícitamente.

El valor predeterminado para esto es ``Home`` que coincide con el controlador en
**aplicación/Controladores/Home.php**::

    cadena pública $defaultController = 'Inicio&#39;;

Para URI de directorio (heredado)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

El controlador predeterminado también se utiliza cuando no se ha encontrado ninguna ruta coincidente y el URI apuntaría a un directorio.
en el directorio de controladores. Por ejemplo, si el usuario visita **ejemplo.com/admin**, si se encontró un controlador en
**app/Controllers/Admin/Home.php**, se usaría.

Ver :ref:`Enrutamiento automático (heredado) en controladores<controller-auto-routing-legacy>` para más información.

Método predeterminado (heredado)
-----------------------

Esto funciona de manera similar a la configuración predeterminada del controlador, pero se usa para determinar el método predeterminado que se utiliza.
cuando se encuentra un controlador que coincide con el URI, pero no existe ningún segmento para el método. El valor predeterminado es
``índice``.

En este ejemplo, si el usuario visitara **ejemplo.com/productos** y un ``Productos``
Si existiera el controlador, se ejecutaría el método ``Products::listAll()``::

    cadena pública $defaultMethod = 'listaTodo&#39;;

Confirmación de rutas
*********************

Higgs tiene el siguiente comando :doc:`</cli/spark_commands>`  para mostrar todas las rutas.

.. _routing-spark-routes:

rutas de chispa
===============

Muestra todas las rutas y filtros:

.. code-block:: console

    rutas de chispa php

El resultado es como el siguiente:

.. code-block:: none

    +---------+---------+---------------+--------------------------------+----------------+-------------- -+
    | Método | Ruta | Nombre | Manejador | Antes de los filtros | Después de los filtros |
    +---------+---------+---------------+--------------------------------+----------------+-------------- -+
    | OBTENER | / | » | \Aplicación\Controladores\Inicio::índice | | barra de herramientas |
    | OBTENER | alimentar | » | (Cierre) | | barra de herramientas |
    +---------+---------+---------------+--------------------------------+----------------+-------------- -+

La columna *Método* muestra el método HTTP que escucha la ruta.

La columna *Ruta* muestra la ruta que debe coincidir. La ruta de una ruta definida se expresa como una expresión regular.

Desde v7.3.0, la columna *Nombre* muestra el nombre de la ruta. ``»`` indica que el nombre es el mismo que la ruta de la ruta.

.. important:: The system is not perfect.
    Para rutas que contienen patrones de expresión regular como ``([^/]+)`` o ``{locale}``,
    Es posible que los *Filtros* mostrados no sean correctos (si configura un patrón de URI complicado)
    para los filtros en **app/Config/Filters.php**), o se muestra como ``<unknown>``.

    El :ref:`filtro de chispa:verificar<spark-filter-check>` El comando se puede utilizar para comprobar
    para filtros 100% precisos.

Ruta automática (mejorada)
-----------------------

Cuando utiliza el enrutamiento automático (mejorado), el resultado es similar al siguiente:

.. code-block:: none

    +-----------+-------------------------+----------------+-----------------------------------+-----------------+---------------+
    | Método | Ruta | Nombre | Manejador | Antes de los filtros | Después de los filtros |
    +-----------+-------------------------+----------------+-----------------------------------+-----------------+---------------+
    | OBTENER (automático) | producto/lista/../..[/..] | | \Aplicación\Controladores\Producto::getList | | barra de herramientas |
    +-----------+-------------------------+----------------+-----------------------------------+-----------------+---------------+

El *Método* será como ``GET(auto)``.

``/..`` en la columna *Ruta* indica un segmento. ``[/..]`` indica que es opcional.

.. note:: When auto-routing is enabled and you have the route ``home``, it can be also accessed by ``Home``, or maybe by ``hOme``, ``hoMe``, ``HOME``, etc. but the command will show only ``home``.

Si ve una ruta que comienza con ``x`` como la siguiente, indica una ruta no válida
ruta que no será enrutada, pero el controlador tiene un método público para enrutar.

.. code-block:: none

    +-----------+----------------+------+--------------------------------------+----------------+----------------+
    | Método | Ruta | Nombre | Manejador | Antes de los filtros | Después de los filtros |
    +-----------+----------------+------+--------------------------------------+----------------+----------------+
    | OBTENER (automático) | x inicio/foo | | \Aplicación\Controladores\Home::getFoo |<unknown> |<unknown> |
    +-----------+----------------+------+--------------------------------------+----------------+----------------+

El ejemplo anterior muestra que tiene el método ``\App\Controllers\Home::getFoo()``,
pero no se enruta porque es el controlador predeterminado (``Home`` por defecto)
y el nombre del controlador predeterminado debe omitirse en el URI. deberías eliminar
el método ``getFoo()``.

.. note:: Prior to v7.3.4, the invalid route is displayed as a normal route
    debido a un error.

Enrutamiento automático (heredado)
---------------------

Cuando utiliza el enrutamiento automático (heredado), el resultado es similar al siguiente:

.. code-block:: none

    +--------+--------------------+---------------+---------------------+----------------+ ---------------+
    | Método | Ruta | Nombre | Manejador | Antes de los filtros | Después de los filtros |
    +--------+--------------------+---------------+---------------------+----------------+ ---------------+
    | automático | producto/lista[/...] | | \Aplicación\Controladores\Producto::getList | | barra de herramientas |
    +--------+--------------------+---------------+---------------------+----------------+ ---------------+

El *Método* será ``automático``.

``[/...]`` en la columna *Ruta* indica cualquier número de segmentos.

.. note:: When auto-routing is enabled and you have the route ``home``, it can be also accessed by ``Home``, or maybe by ``hOme``, ``hoMe``, ``HOME``, etc. but the command will show only ``home``.

.. _routing-spark-routes-sort-by-handler:

Ordenar por controlador
---------------

.. versionadded:: 7.0.0

Puedes ordenar las rutas por *Handler*:

.. code-block:: console

    rutas de chispa php -h

.. _routing-spark-routes-specify-host:

Especificar anfitrión
------------

.. versionadded:: 4.4.0

Puede especificar el host en la URL de solicitud con la opción ``--host``:

.. code-block:: console

    rutas de chispa php --cuentas de host.ejemplo.com
