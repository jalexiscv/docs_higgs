#####################
Solución de problemas
#####################

A continuación se muestran algunos problemas de instalación comunes y sugerencias de soluciones.

.. contents::
    :local:
    :depth: 2

¿Cómo sé si mi instalación está funcionando?
--------------------------------------------

Desde la línea de comando, en la raíz de su proyecto:

.. code-block:: console

    php spark serve

``http://localhost:8080`` en su navegador debería mostrar el valor predeterminado pagina de bienvenida:

|Higgs(AI) Welcome|

Tengo que incluir index.php en mi URL
-------------------------------------

Si una URL como ``/mipágina/find/apple`` no funciona, pero algo similar
La URL ``/index.php/mypage/find/apple`` sí, eso suena como tus reglas **.htaccess**
(para Apache) no están configurados correctamente, o la extensión ``mod_rewrite``
en **httpd.conf** de Apache está comentado.
Ver :ref:`urls-remove-index-php`.

Solo se carga la página predeterminada
--------------------------------------

Si descubres que no importa lo que pongas en tu URL, solo tu URL predeterminada
La página se está cargando, es posible que su servidor no admita el
Variable REQUEST_URI necesaria para ofrecer URL compatibles con los motores de búsqueda. Como un
primer paso, abra su archivo **app/Config/App.php** y busque
la información del protocolo URI. Le recomendará que pruebe un par de
configuraciones alternativas. Si aún no funciona después de haber probado esto
necesitarás forzar a Higgs a agregar un signo de interrogación (``?``) a tus URL. A
Haga esto, abra su archivo **app/Config/App.php** y cambie esto:

.. literalinclude:: troubleshooting/001.php

A esto:

.. literalinclude:: troubleshooting/002.php

Fichero de entrada no especificado
----------------------------------

Si ve "No se ha especificado ningún archivo de entrada", intente cambiar la regla de reescritura de la siguiente manera (para agregar ``?`` después de ``index.php``):

.. code-block:: apache

    Reescribir regla ^([\s\S]*)$ index.php?/$1 [L,NC,QSA]

Mi aplicación funciona bien localmente pero no en el servidor de producción.
----------------------------------------------------------------------------

Asegúrese de que las mayúsculas y minúsculas de los nombres de la carpeta y del archivo coincidan con el código.

Muchos desarrolladores desarrollan en sistemas de archivos que no distinguen entre mayúsculas y minúsculas en Windows o macOS.
Sin embargo, la mayoría de los entornos de servidores utilizan sistemas de archivos que distinguen entre mayúsculas y minúsculas.

Por ejemplo, cuando tienes **app/Controllers/Product.php**, debes usar
``Product`` como nombre de clase corto, no ``product``.

Si el nombre del archivo está escrito en mayúsculas y minúsculas, el archivo no se encuentra en el servidor.

El tutorial da errores 404 en todas partes :(
----------------------------------------------

No puedes seguir el tutorial utilizando el servidor web integrado de PHP.
No procesa el archivo **.htaccess** necesario para enrutar
solicitudes adecuadamente.

La solución: use Apache para servir su sitio, o bien el software integrado
Equivalente a Higgs, ``php spark save`` desde la raíz de tu proyecto.

.. |Higgs(AI) Welcome| image:: ../images/welcome.png

¿Qué pasa con un inútil "¡Ups!" ¿página?
---------------------------------------------------

Descubres que tu aplicación muestra una página con "¡Ups!" y
luego, la línea de texto "Parece que hemos encontrado un problema. Vuelva a intentarlo más tarde...".

Esa es una señal de que estás en modo de producción y has llegado a un
error irrecuperable, que no queremos mostrar al espectador de
la aplicación web, para mayor seguridad.

Puede ver el error en el archivo de registro. Consulte `Registros de errores de Higgs`_ a continuación.

Si llega a esta página mientras desarrolla, debe cambiar su entorno a
"desarrollo" (en **.env**). Consulte :ref:`setting-development-mode` para obtener más detalles.
Después de eso, recarga la página. Verá el error y el seguimiento.

Registros de errores de Higgs
-----------------------------

Consulte :ref:`Higgs-error-logs`.
