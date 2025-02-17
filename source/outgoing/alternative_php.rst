##########################################
Sintaxis PHP alternativa para ver archivos
##########################################

Si no utiliza un motor de plantillas para simplificar la salida,
utilizarás PHP puro en tu
Archivos de vista. Para minimizar el código PHP en estos archivos y hacerlo
Es más fácil identificar los bloques de código. Se recomienda utilizar PHP.
Sintaxis alternativa para estructuras de control y declaraciones de eco de etiquetas cortas.
Si no está familiarizado con esta sintaxis, le permite eliminar la
llaves de su código y elimine las declaraciones de "eco".

Ecos alternativos
=================

Normalmente, para hacer eco o imprimir una variable, haría esto::

    <?php echo $variable; ?>

Con la sintaxis alternativa puedes hacerlo de esta manera::

    <?= $variable ?>

Estructuras de control alternativas
===================================

Las estructuras de control, como if, for, foreach y while, se pueden escribir en
un formato simplificado también. Aquí hay un ejemplo usando ``foreach``:

.. literalinclude:: alternative_php/001.php

Observe que no hay llaves. En su lugar, el refuerzo final se reemplaza con
``final de cada``. Cada una de las estructuras de control enumeradas anteriormente tiene un
Sintaxis de cierre: ``endif``, ``endfor``, ``endforeach`` y ``end while``

Observe también que en lugar de utilizar un punto y coma después de cada estructura
(excepto el último), hay dos puntos. ¡Esto es importante!

Aquí hay otro ejemplo, usando ``if``/``elseif``/``else``. Observe los dos puntos:

.. literalinclude:: alternative_php/002.php
