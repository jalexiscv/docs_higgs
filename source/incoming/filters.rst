#######################
Filtros del controlador
#######################

.. contents::
    :local:
    :depth: 2

Los filtros de controlador le permiten realizar acciones antes o después de que se ejecuten los controladores. A diferencia de :doc:`eventos <../extending/events>`,
puede elegir los URI o rutas específicas a las que se aplicarán los filtros. Antes de que los filtros puedan
modificar la Solicitud, mientras que los filtros posteriores pueden actuar e incluso modificar la Respuesta, lo que permite mucha flexibilidad
y poder.

Algunos ejemplos comunes de tareas que se pueden realizar con filtros son:

* Realizar protección CSRF en las solicitudes entrantes
* Restringir áreas de su sitio según su función
* Realizar limitación de velocidad en ciertos puntos finales
* Mostrar una página "Inactivo por mantenimiento"
* Realizar negociación automática de contenidos.
* y más...


Creando un filtro
*****************

Los filtros son clases simples que implementan ``Higgs\Filters\FilterInterface``.
Contienen dos métodos: ``before()`` y ``after()`` que contienen el código que
se ejecutará antes y después del controlador respectivamente. Tu clase debe contener ambos métodos.
pero puede dejar los métodos vacíos si no son necesarios. Una clase de filtro de esqueleto se ve así:

.. literalinclude:: filters/001.php

Antes de los filtros
====================

Reemplazo de solicitud
-----------------

Desde cualquier filtro, puede devolver el objeto ``$request`` y reemplazará la Solicitud actual, permitiéndole
para realizar cambios que seguirán presentes cuando se ejecute el controlador.

Detener filtros posteriores
----------------------

Además, cuando tengas una serie de filtros es posible que también quieras
detener la ejecución de los filtros posteriores después de un determinado filtro. Puedes hacer esto fácilmente regresando
**cualquier resultado que no esté vacío**. Si el filtro anterior devuelve un resultado vacío, las acciones del controlador o el filtro posterior
Los filtros aún se ejecutarán.

Una excepción a la regla de resultado no vacío es la instancia ``Solicitud``.
Devolverlo en el filtro anterior no detendrá la ejecución sino que solo reemplazará el objeto ``$request`` actual.

Respuesta de retorno
------------------

Dado que antes de que se ejecuten los filtros antes de que se ejecute su controlador, es posible que en ocasiones desee detener el
que se produzcan acciones en el controlador.

Normalmente se utiliza para realizar redirecciones, como en este ejemplo:

.. literalinclude:: filters/002.php

Si se devuelve una instancia de ``Respuesta``, la respuesta se enviará de vuelta al cliente y se detendrá la ejecución del script.
Esto puede resultar útil para implementar la limitación de velocidad para las API. Consulte :doc:`Throttler <../libraries/throttler>` para obtener más información.
ejemplo.

.. _after-filters:

Después de los filtros
======================

Los filtros posteriores son casi idénticos a los filtros anteriores, excepto que solo puedes devolver el objeto ``$respuesta``,
y no puede detener la ejecución del script. Esto le permite modificar el resultado final, o simplemente hacer algo con
la salida final. Esto podría usarse para garantizar que ciertos encabezados de seguridad se configuraron de la manera correcta o para almacenar en caché
el resultado final, o incluso filtrar el resultado final con un filtro de malas palabras.


Configurar filtros
******************

Hay dos formas de configurar los filtros cuando se ejecutan. Uno se hace en
**app/Config/Filters.php**, el otro se realiza en **app/Config/Routes.php**.

Si desea especificar un filtro para una ruta específica, use **app/Config/Routes.php**
y vea :ref:`Enrutamiento URI<applying-filters>` .

Los filtros que se especifican para una ruta (en **app/Config/Routes.php**) son
ejecutado antes de los filtros especificados en **app/Config/Filters.php**.

.. Note:: The safest way to apply filters is to :ref:`disable auto-routing <use-defined-routes-only>`, and :ref:`set filters to routes <applying-filters>`.

El archivo **app/Config/Filters.php** contiene cuatro propiedades que le permiten
configurar exactamente cuándo se ejecutan los filtros.

.. Warning:: It is recommended that you should always add ``*`` at the end of a URI in the filter settings.
    Porque es posible que se pueda acceder a un método de controlador mediante URL diferentes de las que cree.
    Por ejemplo, cuando :ref:`auto-routing-legacy` está habilitado, si tiene ``Blog::index``,
    se puede acceder a él con ``blog``, ``blog/index`` y ``blog/index/1``, etc.

$alias
======

La matriz ``$aliases`` se utiliza para asociar un nombre simple con uno o más nombres de clase completos que son el
filtros para ejecutar:

.. literalinclude:: filters/003.php

Los alias son obligatorios y si intenta utilizar un nombre de clase completo más adelante, el sistema arrojará un error. Definirlos
de esta manera simplifica el cambio de la clase utilizada. Genial para cuando decidiste que necesitas cambiar a un
sistema de autenticación diferente ya que solo cambias la clase del filtro y listo.

Puede combinar varios filtros en un alias, lo que simplifica la aplicación de conjuntos complejos de filtros:

.. literalinclude:: filters/004.php

Debe definir tantos alias como necesite.

$globales
=========

La segunda sección le permite definir los filtros que deben aplicarse a cada solicitud válida realizada por el marco.

Debes tener cuidado con la cantidad que utilizas aquí, ya que tener demasiadas podría tener implicaciones en el rendimiento.
ejecutar en cada solicitud.

Los filtros se pueden especificar agregando su alias a la matriz ``antes`` o ``después``:

.. literalinclude:: filters/005.php

Excepto por algunos URI
---------------------

Hay ocasiones en las que desea aplicar un filtro a casi todas las solicitudes, pero hay algunas que deben dejarse como están.
Un ejemplo común es si necesita excluir algunos URI del filtro de protección CSRF para permitir solicitudes de
sitios web de terceros para acceder a uno o dos URI específicos, manteniendo el resto protegidos.

Para hacer esto, agregue
una matriz con la clave ``except`` y una ruta URI (relativa a BaseURL) para que coincida como valor junto con el alias:

.. literalinclude:: filters/006.php

En cualquier lugar donde pueda usar una ruta URI (relativa a BaseURL) en la configuración del filtro, puede usar una expresión regular o, como en este ejemplo, usar
un asterisco (``*``) como comodín que coincidirá con todos los caracteres posteriores. En este ejemplo, cualquier ruta URI que comience con ``api/``
estaría exento de la protección CSRF, pero todos los formularios del sitio estarían protegidos.

Si necesita especificar varios
Rutas de URI, puede utilizar una variedad de patrones de rutas de URI:

.. literalinclude:: filters/007.php

$métodos
========

.. Warning:: If you use ``$methods`` filters, you should :ref:`disable Auto Routing (Legacy) <use-defined-routes-only>`
    porque :ref:`auto-routing-legacy` permite que cualquier método HTTP acceda a un controlador.
    Acceder al controlador con un método inesperado podría pasar por alto el filtro.

Puede aplicar filtros a todas las solicitudes de un determinado método HTTP, como POST, GET, PUT, etc. En esta matriz,
especifique el nombre del método en **minúsculas**. Su valor sería una serie de filtros para ejecutar:

.. literalinclude:: filters/008.php

.. note:: Unlike the ``$globals`` or the
    Propiedades ``$filters``, estas solo se ejecutarán como los filtros anteriores.

Además de los métodos HTTP estándar, esto también admite un caso especial: ``cli``. El método ``cli`` se aplicaría a
todas las solicitudes que se ejecutaron desde la línea de comando.

$filtros
========

Esta propiedad es una matriz de alias de filtro. Para cada alias, puede especificar matrices ``antes`` y ``después`` que contengan
una lista de patrones de ruta de URI (relativos a BaseURL) a los que se debe aplicar el filtro:

.. literalinclude:: filters/009.php

.. _filters-filters-filter-arguments:

Filtrar argumentos
----------------

.. versionadded:: 4.4.0

Al configurar ``$filters``, se pueden pasar argumentos adicionales a un filtro:

.. literalinclude:: filters/012.php

En este ejemplo, cuando el URI coincide con ``admin/*'``, la matriz ``['admin', 'superadmin']``
se pasará en ``$argumentos`` a los métodos ``before()`` del filtro ``group``.
Cuando el URI coincide con ``admin/users/*'``, la matriz ``['users.manage']``
se pasará en ``$argumentos`` a los métodos ``before()`` del filtro ``permiso``.


Confirmación de filtros
***********************

Higgs tiene el siguiente :doc:`comando <../cli/spark_commands>` para verificar los filtros de una ruta.

.. _spark-filter-check:

filtro: comprobar
=================

.. versionadded:: 7.0.0

Por ejemplo, verifique los filtros para la ruta ``/`` con el método **GET**:

.. code-block:: console

    filtro de chispa php: marque obtener /

El resultado es como el siguiente:

.. code-block:: none

    +--------+-------+----------------+--------------- +
    | Método | Ruta | Antes de los filtros | Después de los filtros |
    +--------+-------+----------------+--------------- +
    | OBTENER | / | | barra de herramientas |
    +--------+-------+----------------+--------------- +

También puedes ver las rutas y filtros con el comando ``spark route``,
pero es posible que no muestre filtros precisos cuando utilice expresiones regulares para las rutas.
Ver :ref:`Enrutamiento URI<routing-spark-routes>` para más detalles.


Filtros proporcionados
**********************

Los filtros incluidos con Higgs(AI) son: :doc:`Honeypot <../libraries/honeypot>`, :ref:`CSRF<cross-site-request-forgery>` , ``InvalidChars``, ``SecureHeaders`` y :ref:`DebugToolbar<the-debug-toolbar>` .

.. note:: The filters are executed in the order defined in the config file. However, if enabled, ``DebugToolbar`` is always executed last because it should be able to capture everything that happens in the other filters.

.. _invalidchars:

caracteres no válidos
=====================

Este filtro prohíbe que los datos de entrada del usuario (``$_GET``, ``$_POST``, ``$_COOKIE``, ``php://input``) contengan los siguientes caracteres:

- caracteres UTF-8 no válidos
- caracteres de control excepto salto de línea y código de tabulación

.. _secureheaders:

Encabezados seguros
===================

Este filtro agrega encabezados de respuesta HTTP que su aplicación puede usar para aumentar la seguridad de su aplicación.

Si desea personalizar los encabezados, extienda ``Higgs\Filters\SecureHeaders`` y anule la propiedad ``$headers``. Y cambie la propiedad ``$aliases`` en **app/Config/Filters.php**:

.. literalinclude:: filters/011.php

Si desea obtener información sobre encabezados seguros, consulte el `Proyecto de encabezados seguros OWASP<https://owasp.org/www-project-secure-headers/>` _.
