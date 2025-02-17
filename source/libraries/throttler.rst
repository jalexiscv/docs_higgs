##########
acelerador
##########

.. contents::
    :local:
    :depth: 2

La clase Throttler proporciona una forma muy sencilla de limitar la realización de una actividad a un determinado número de intentos.
dentro de un período de tiempo determinado. Esto se utiliza con mayor frecuencia para limitar la velocidad de las API o restringir el número
de intentos que un usuario puede realizar contra un formulario para ayudar a prevenir ataques de fuerza bruta. La clase en sí se puede utilizar.
para cualquier cosa que necesite acelerar en función de acciones dentro de un intervalo de tiempo establecido.


Descripción general
*******************

El Throttler implementa una versión simplificada del `Token Bucket<https://en.wikipedia.org/wiki/Token_bucket>` _
algoritmo. Básicamente, esto trata cada acción que desea como un depósito. Cuando llamas al método ``check()``,
usted le dice qué tan grande es el depósito, cuántas fichas puede contener y el intervalo de tiempo. Cada llamada ``check()`` utiliza
1 de los tokens disponibles, por defecto. Veamos un ejemplo para aclarar esto.

Digamos que queremos que ocurra una acción una vez por segundo. La primera llamada al Throttler sería similar a la siguiente.
El primer parámetro es el nombre del depósito, el segundo parámetro, la cantidad de tokens que contiene el depósito y
el tercero es la cantidad de tiempo que tarda el balde en volver a llenarse:

.. literalinclude:: throttler/001.php

Aquí estamos usando una de las :doc:`constantes globales</general/common_functions>`  por el momento, para hacerlo un poco
más legible. Esto dice que el depósito permite 60 acciones por minuto, o 1 acción por segundo.

Digamos que un script de terceros intentaba acceder a una URL repetidamente. Al principio, podría utilizar los 60
de esos tokens en menos de un segundo. Sin embargo, después de eso, el Throttler solo permitiría una acción por segundo.
potencialmente ralentizando las solicitudes lo suficiente como para que el ataque ya no valga la pena.

.. note:: For the Throttler class to work, the Cache library must be set up to use a handler other than dummy.
            Para obtener el mejor rendimiento, se recomienda una caché en memoria, como Redis o Memcached.


Limitación de tasa
******************

La clase Throttler no limita la velocidad ni solicita aceleración por sí sola, pero es la clave para hacer
una obra. Un ejemplo :doc:`Filtro</incoming/filters>`  se proporciona que implementa un límite de tasa muy simple en
una solicitud por segundo por dirección IP. Aquí explicaremos cómo funciona y cómo puede configurarlo y
comience a usarlo en su aplicación.

El código
=========

Puedes crear tu propio filtro Throttler, en **app/Filters/Throttle.php**,
en la línea de:

.. literalinclude:: throttler/002.php

Cuando se ejecuta, este método primero toma una instancia del acelerador. A continuación, utiliza la dirección IP como nombre del depósito,
y establece cosas para limitarlas a una solicitud por segundo. Si el acelerador rechaza la verificación y devuelve falso,
luego devolvemos una respuesta con el código de estado establecido en 429 - Demasiados intentos y la ejecución del script finaliza
antes de que llegue al controlador. Este ejemplo acelerará en función de una única dirección IP en todas las solicitudes.
realizados al sitio, no por página.

Aplicar el filtro
=================

No necesariamente necesitamos limitar cada página del sitio. Para muchas aplicaciones web, esto tiene más sentido.
para aplicarse solo a solicitudes POST, aunque es posible que las API deseen limitar cada solicitud realizada por un usuario. Con el fin de aplicar
esto para las solicitudes entrantes, debe editar **app/Config/Filters.php** y primero agregar un alias al
filtrar:

.. literalinclude:: throttler/003.php

A continuación, lo asignamos a todas las solicitudes POST realizadas en el sitio:

.. literalinclude:: throttler/004.php

.. Warning:: If you use ``$methods`` filters, you should :ref:`disable Auto Routing (Legacy) <use-defined-routes-only>`
    porque :ref:`auto-routing-legacy` permite que cualquier método HTTP acceda a un controlador.
    Acceder al controlador con un método inesperado podría pasar por alto el filtro.

Y eso es todo. Ahora todas las solicitudes POST realizadas en el sitio tendrán que tener una tarifa limitada.


Referencia de clase
*******************

.. php:method:: check(string $key, int $capacity, int $seconds[, int $cost = 1])

    :param  string $key: el nombre del depósito
    :param int $capacidad: la cantidad de tokens que contiene el depósito
    :param int $segundos: el número de segundos que tarda un depósito en llenarse por completo
    :param int $cost: La cantidad de tokens que se gastan en esta acción
    :returns: verdadero si se puede realizar la acción, falso si no
    :rtype: booleano

    Comprueba si quedan fichas dentro del depósito o si hay demasiadas.
    sido utilizado dentro del límite de tiempo asignado. Durante cada comprobación los tokens disponibles
    se reducen en $cost si tienen éxito.

.. php:method:: getTokentime()

    :returns: el número de segundos hasta que otro token esté disponible.
    :rtype: entero

    Después de ejecutar ``check()`` y devolver falso, se puede utilizar este método
    para determinar el tiempo hasta que un nuevo token esté disponible y la acción pueda ser
    intentó de nuevo. En este caso, el tiempo de espera mínimo obligatorio es de un segundo.

.. php:method:: remove(string $key) : self

    :param  string $key: el nombre del depósito
    :devuelve: $esto
    :rtype: yo

    Elimina y reinicia el cubo.
    No fallará si el depósito no existe.
