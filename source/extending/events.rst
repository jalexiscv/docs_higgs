Eventos
#######

La función Eventos de Higgs proporciona un medio para aprovechar y modificar el funcionamiento interno del marco sin piratear
archivos principales. Cuando Higgs se ejecuta, sigue un proceso de ejecución específico. Sin embargo, puede haber casos en los que
le gustaría provocar que se lleve a cabo alguna acción en una etapa particular del proceso de ejecución. Por ejemplo, es posible que desee ejecutar
un script justo antes de que se carguen sus controladores, o inmediatamente después, o tal vez desee activar uno de sus propios scripts
en algún otro lugar.

Los eventos funcionan con un patrón *publicación/suscripción*, donde un evento se activa en algún momento durante la ejecución del script.
Otros scripts pueden "suscribirse" a ese evento registrándose en la clase Eventos para informarle que quieren realizar un
acción cuando se desencadena ese evento.

.. contents::
    :local:
    :depth: 2

Habilitación de eventos
=======================

Los eventos siempre están habilitados y están disponibles globalmente.

Definición de un evento
=======================

La mayoría de los eventos se definen en el archivo **app/Config/Events.php**. Puedes suscribir una acción a un evento con
el método ``on()`` de la clase ``Eventos``. El primer parámetro es el nombre del evento al que suscribirse. El segundo parámetro es
un invocable que se ejecutará cuando se active ese evento:

.. literalinclude:: events/001.php

En este ejemplo, cada vez que se ejecuta el evento ``pre_system``, se crea una instancia de ``MyClass`` y el
Se ejecuta el método ``myFunction()``. Tenga en cuenta que el segundo parámetro puede ser *cualquier* forma de
`invocable<https://www.php.net/manual/en/function.is-callable.php>` _ que PHP reconoce:

.. literalinclude:: events/002.php

Estableciendo prioridades
------------------

Dado que se pueden suscribir varios métodos a un solo evento, necesitará una forma de definir en qué orden esos métodos
son llamados. Puede hacer esto pasando un valor de prioridad como tercer parámetro del método ``on()``. Valores más bajos
se ejecutan primero, teniendo un valor de 1 la prioridad más alta y no habiendo límite para los valores más bajos:

.. literalinclude:: events/003.php

Todos los suscriptores con la misma prioridad se ejecutarán en el orden en que fueron definidos.

Desde v7.2.0, se definen tres constantes de clase para su uso, que establecen algunos rangos útiles en los valores. No es necesario que utilice estos
pero es posible que ayuden a la legibilidad:

.. literalinclude:: events/004.php

.. important:: The constants ``EVENT_PRIORITY_LOW``, ``EVENT_PRIORITY_NORMAL`` and ``EVENT_PRIORITY_HIGH`` are deprecated, and the definitions are moved to ``app/Config/Constants.php``. These will be removed in future releases.

Una vez ordenados, todos los suscriptores se ejecutan en orden. Si algún suscriptor devuelve un valor booleano falso, entonces la ejecución de
los suscriptores se detendrán.

Publicar tus propios eventos
============================

La biblioteca de Eventos también le facilita la creación de eventos en su propio código. Para utilizar esta función, simplemente
Necesitas llamar al método ``trigger()`` en la clase **Eventos** con el nombre del evento:

.. literalinclude:: events/005.php

Puede pasar cualquier cantidad de argumentos a los suscriptores agregándolos como parámetros adicionales. Los suscriptores serán
dados los argumentos en el mismo orden definido:

.. literalinclude:: events/006.php

Simulación de eventos
=====================

Durante las pruebas, es posible que no desee que los eventos se activen realmente, ya que enviar cientos de correos electrónicos al día es lento.
y contraproducente. Puede indicarle a la clase Eventos que solo simule la ejecución de eventos con el método ``simulate()``.
Cuando **verdadero**, se omitirán todos los eventos durante el método de activación. Sin embargo, todo lo demás funcionará normalmente.

.. literalinclude:: events/007.php

Puedes detener la simulación pasando falso:

.. literalinclude:: events/008.php

.. _event-points:

Puntos de evento
================

La siguiente es una lista de puntos de eventos disponibles dentro del código central de Higgs:

* **pre_system** Llamado temprano durante la ejecución del sistema. El URI, la solicitud y
  Se ha creado una instancia de respuesta, pero la verificación, el enrutamiento y la ejecución de la caché de la página
  de los filtros del controlador "antes" aún no se han producido.
* **post_controller_constructor** Se llama inmediatamente después de que se crea una instancia de su controlador, pero antes de que se realice cualquier llamada a un método.
* **post_system** Se llama justo antes de que la página final renderizada se envíe al navegador.
  al final de la ejecución del sistema, después de la ejecución de los filtros del controlador "después".
* **correo electrónico** Se llama después de que un correo electrónico se envió exitosamente desde ``Higgs\Email\Email``. Recibe una matriz de propiedades de la clase ``Email`` como parámetro.
* **DBQuery** Se llama después de una consulta de base de datos, ya sea exitosa o no. Recibe el objeto ``Query``.
* **migrate** Se llama después de una llamada de migración exitosa a ``latest()`` o ``regress()``. Recibe las propiedades actuales de ``MigrationRunner`` así como el nombre del método.
