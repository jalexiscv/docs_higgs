######################
Evaluación comparativa
######################

Higgs proporciona dos herramientas independientes para ayudarle a comparar su código y probar diferentes opciones:

el **Temporizador** y el **Iterador**. El Temporizador le permite calcular fácilmente el tiempo entre dos puntos en el
ejecución de su script. El Iterador le permite configurar varias variaciones y ejecutar esas pruebas, registrando
Estadísticas de rendimiento y memoria para ayudarle a decidir qué versión es la mejor.

La clase Timer siempre está activa y se inicia desde el momento en que se invoca el marco hasta justo antes
enviar la salida al usuario, lo que permite una sincronización muy precisa de toda la ejecución del sistema.

.. contents::
    :local:
    :depth: 2


Usando el temporizador
**********************

Con el Timer podrás medir el tiempo entre dos momentos en la ejecución de tu aplicación. Esto hace
Es sencillo medir el rendimiento de diferentes aspectos de su aplicación. Todas las mediciones se realizan utilizando
los métodos ``start()`` y ``stop()``.

Temporizador::inicio()
======================

Los métodos ``start()`` toman un único parámetro: el nombre de este temporizador. Puedes usar cualquier cadena como nombre.
del cronómetro. Sólo se utiliza para que puedas consultarlo más adelante para saber qué medida es cuál:

.. literalinclude:: benchmark/001.php

Temporizador::parar()
=====================

El método ``stop()`` toma el nombre del temporizador que desea detener como único parámetro, además:

.. literalinclude:: benchmark/002.php

El nombre no distingue entre mayúsculas y minúsculas, pero debe coincidir con el nombre que le dio cuando inició el temporizador.

Temporizador()
==============

Alternativamente, puede utilizar la función global :doc:`</general/common_functions>``temporizador()`` para comenzar
y detener los temporizadores:

.. literalinclude:: benchmark/003.php

.. _benchmark-timer-record:

Temporizador::grabar()
======================

.. versionadded:: 7.0.0

Desde v7.3.0, si usa bloques de código muy pequeños para realizar pruebas comparativas, también puede usar el método ``record()``. se acepta
un invocable sin parámetros y mide su tiempo de ejecución. Se llamarán los métodos ``start()`` y ``stop()``.
automáticamente alrededor de la llamada a la función.

.. literalinclude:: benchmark/010.php

También puede devolver el valor de retorno del invocable para su posterior procesamiento.

.. literalinclude:: benchmark/011.php

La misma funcionalidad también está disponible cuando se pasa invocable a ``timer()`` como segundo parámetro.

.. literalinclude:: benchmark/012.php

Ver sus puntos de referencia
============================

Cuando se ejecuta su aplicación, la clase Timer recopila todos los temporizadores que ha configurado. Lo hace
Sin embargo, no los muestra automáticamente. Puede recuperar todos sus temporizadores llamando al método ``getTimers()``.
Esto devuelve una serie de información de referencia, incluido el inicio, el final y la duración:

.. literalinclude:: benchmark/004.php

Puede cambiar la precisión de la duración calculada pasando el número de decimales que desea que se muestren.
el único parámetro. El valor predeterminado es 4 números detrás del punto decimal:

.. literalinclude:: benchmark/005.php

Los temporizadores se muestran automáticamente en :doc:`Barra de herramientas de depuración</testing/debugging>` .

Visualización del tiempo de ejecución
=====================================

Si bien el método ``getTimers()`` le proporcionará los datos sin procesar de todos los temporizadores de su proyecto, puede recuperarlos
la duración de un solo temporizador, en segundos, con el método ``getElapsedTime()``. El primer parámetro es el nombre de
el temporizador para mostrar. El segundo es el número de decimales que se mostrarán. El valor predeterminado es 4:

.. literalinclude:: benchmark/006.php


Usando el iterador
******************

El Iterador es una herramienta sencilla diseñada para permitirle probar múltiples variaciones de una solución para
vea las diferencias de velocidad y los diferentes patrones de uso de la memoria. Puede agregar cualquier cantidad de "tareas" para que
ejecute y la clase ejecutará la tarea cientos o miles de veces para obtener una imagen más clara del rendimiento.
Luego, los resultados pueden recuperarse y utilizarse mediante el script, o mostrarse como una tabla HTML.

Crear tareas para ejecutar
==========================

Las tareas se definen dentro de Cierres. Cualquier resultado que cree la tarea se descartará automáticamente. Ellos son
agregado a la clase Iterator a través del método ``add()``. El primer parámetro es un nombre al que desea hacer referencia.
esta prueba por. El segundo parámetro es el cierre en sí:

.. literalinclude:: benchmark/007.php

Ejecutando las tareas
=====================

Una vez que haya agregado las tareas para ejecutar, puede usar el método ``run()`` para recorrer las tareas muchas veces.
De forma predeterminada, ejecutará cada tarea 1000 veces. Probablemente esto sea suficiente para la mayoría de las pruebas simples. Si necesitas
para ejecutar las pruebas más veces, puede pasar el número como primer parámetro:

.. literalinclude:: benchmark/008.php

Una vez ejecutado devolverá una tabla HTML con los resultados de la prueba.
Si no desea los resultados, puede pasar ``false`` como segundo parámetro:

.. literalinclude:: benchmark/009.php
