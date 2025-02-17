**********************
Clase de solicitud CLI
**********************

Si una solicitud proviene de una invocación de línea de comando, el objeto de solicitud es en realidad un
``Solicitud CLI``. Se comporta igual que una :doc:`solicitud convencional</incoming/request>`
pero agrega algunos métodos de acceso para mayor comodidad.


Accesorios adicionales
======================

obtenerSegmentos()
-------------

Devuelve una matriz de argumentos de la línea de comando que se consideran parte de una ruta:

.. literalinclude:: cli_request/001.php

obtenerRuta()
---------

Devuelve la ruta reconstruida como una cadena:

.. literalinclude:: cli_request/002.php

obtenerOpciones()
------------

Devuelve una matriz de argumentos de la línea de comando considerados opciones:

.. literalinclude:: cli_request/003.php

getOption($cuál)
-----------------

Devuelve el valor de un argumento de línea de comando específico que se considera una opción:

.. literalinclude:: cli_request/004.php

getOptionString()
-----------------

Devuelve la cadena de línea de comando reconstruida para las opciones:

.. literalinclude:: cli_request/005.php

Al pasar ``true`` al primer argumento se intentará escribir opciones largas usando dos guiones:

.. literalinclude:: cli_request/006.php
