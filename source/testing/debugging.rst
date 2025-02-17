#######################
Depurando su aplicación
#######################

.. contents::
    :local:
    :depth: 2


Comprobación de registros
*************************

.. _Higgs-error-logs:

Registros de errores de Higgs
=============================

Higgs registra mensajes de error, de acuerdo con la configuración en **app/Config/Logger.php**.

La configuración predeterminada tiene archivos de registro diarios almacenados en **writable/logs**.
¡Sería una buena idea revisarlos si las cosas no funcionan como esperas!

Puede ajustar el umbral de error para ver más o menos mensajes. Ver
:ref:`Registro<logging-configuration>` para más detalles.

Registro de todas las consultas SQL
===================================

Se pueden registrar todas las consultas SQL emitidas por Higgs.
Ver :ref:`Eventos de base de datos<database-events-dbquery>` para más detalles.


Reemplazo de var_dump()
***********************

Si bien usar Xdebug y un buen IDE puede ser indispensable para depurar su aplicación,
a veces todo lo que necesitas es un rápido ``var_dump()``. Higgs hace que eso sea incluso
mejor al incluir el excelente `Kint<https://kint-php.github.io/kint/>` _
herramienta de depuración para PHP.

Esto va mucho más allá de su herramienta habitual y proporciona muchos datos alternativos,
como formatear marcas de tiempo en fechas reconocibles, mostrar códigos hexadecimales como colores,
muestra datos de matriz como una tabla para facilitar la lectura y mucho, mucho más.

Habilitando Kint
================

De forma predeterminada, Kint está habilitado en los entornos **desarrollo** y **pruebas** :doc:`</general/environments>` solamente.
Se habilitará siempre que la constante ``HIGGS_DEBUG`` esté definida y su valor sea verdadero.
Esto se define en los archivos de arranque (por ejemplo, **app/Config/Boot/development.php**).

Usando Kint
===========

d()
---

El método ``d()`` descarga todos los datos que conoce sobre el contenido pasado como único parámetro a la pantalla, y
permite que el script continúe ejecutándose:

.. literalinclude:: debugging/001.php
    :lines: 2-

dd()
----

Este método es idéntico a ``d()``, excepto que también ``die()`` y no se ejecuta ningún código adicional en esta solicitud.

rastro()
--------

Esto proporciona un rastreo hasta el punto de ejecución actual, con el giro único de Kint:

.. literalinclude:: debugging/002.php
    :lines: 2-

Para obtener más información, consulte la `página de Kint<https://kint-php.github.io/kint//>` _.

.. _the-debug-toolbar:


La barra de herramientas de depuración
**************************************

La barra de herramientas de depuración proporciona información de un vistazo sobre la solicitud de página actual, incluidos resultados de referencia,
consultas que ha ejecutado, datos de solicitudes y respuestas, y más. Todo esto puede resultar muy útil durante el desarrollo.
para ayudarle a depurar y optimizar.

.. note:: The Debug Toolbar is still under construction with several planned features not yet implemented.

Habilitar la barra de herramientas
==================================

La barra de herramientas está habilitada de forma predeterminada en cualquier :doc:`entorno</general/environments>`  *excepto* **producción**. Se mostrará siempre que el
La constante ``HIGGS_DEBUG`` está definida y su valor es verdadero. Esto se define en los archivos de arranque (p. ej.
**app/Config/Boot/development.php**) y se puede modificar allí para determinar qué entorno mostrar.

.. note:: The Debug Toolbar is not displayed when your ``baseURL`` setting (in **app/Config/App.php** or ``app.baseURL`` in **.env**) does not match your actual URL.

La barra de herramientas en sí se muestra como :doc:`Después del filtro</incoming/filters>` . Puedes detenerlo desde siempre
ejecutándolo eliminándolo de la propiedad ``$globals`` de **app/Config/Filters.php**.

Elegir qué mostrar
---------------------

Higgs viene con varios recopiladores que, como su nombre lo indica, recopilan datos para mostrarlos en la barra de herramientas. Tú
Puedes crear fácilmente el tuyo propio para personalizar la barra de herramientas. Para determinar qué coleccionistas se muestran, dirígete nuevamente a
el archivo de configuración **app/Config/Toolbar.php**:

.. literalinclude:: debugging/003.php

Comenta cualquier coleccionista que no quieras mostrar. Agregue coleccionistas personalizados aquí proporcionando el personal totalmente calificado
nombre de la clase. Los recopiladores exactos que aparecen aquí afectarán las pestañas que se muestran, así como la información que se muestra.
mostrado en la línea de tiempo.

.. note:: Some tabs, like Database and Logs, will only display when they have content to show. Otherwise, they
    se eliminan para ayudar en pantallas más pequeñas.

Los coleccionistas que se envían con Higgs son:

* **Temporizadores** recopila todos los datos de referencia, tanto del sistema como de su aplicación.
* **Base de datos** Muestra una lista de consultas que han realizado todas las conexiones de la base de datos y su tiempo de ejecución.
* **Registros** Cualquier información que se haya registrado se mostrará aquí. En sistemas de larga ejecución o sistemas en los que se registran muchos elementos, esto puede causar problemas de memoria y debe desactivarse.
* **Vistas** Muestra el tiempo de renderizado de las vistas en la línea de tiempo y muestra los datos pasados a las vistas en una pestaña separada.
* **Caché** Mostrará información sobre aciertos y errores de caché, y tiempos de ejecución.
* **Archivos** muestra una lista de todos los archivos que se han cargado durante esta solicitud.
* **Rutas** muestra información sobre la ruta actual y todas las rutas definidas en el sistema.
* **Eventos** muestra una lista de todos los eventos que se han cargado durante esta solicitud.

Establecer puntos de referencia
===============================

Para que Profiler recopile y muestre sus datos de referencia, debe nombrar sus puntos de marca utilizando una sintaxis específica.

Lea la información sobre cómo configurar puntos de referencia en :doc:`Biblioteca de referencia</testing/benchmark>` página.

Crear recopiladores personalizados
==================================

Crear recopiladores personalizados es una tarea sencilla. Creas una nueva clase, con espacio de nombres completo para que el autocargador
puede localizarlo, que extiende ``Higgs\Debug\Toolbar\Collectors\BaseCollector``. Esto proporciona una serie de métodos
que puede anular y tiene cuatro propiedades de clase requeridas que debe configurar correctamente dependiendo de cómo desee
el coleccionista a trabajar

.. literalinclude:: debugging/004.php

**$hasTimeline** debe establecerse en ``true`` para cualquier recopilador que desee mostrar información en la barra de herramientas.
línea de tiempo. Si esto es cierto, necesitarás implementar el método ``formatTimelineData()`` para formatear y devolver el
datos para su visualización.

**$hasTabContent** debe ser ``true`` si el recopilador desea mostrar su propia pestaña con contenido personalizado. Si esto
es cierto, necesitarás proporcionar un ``$title``, implementar el método ``display()`` para mostrar el contenido de la pestaña,
y es posible que necesite implementar el método ``getTitleDetails()`` si desea mostrar información adicional simplemente
a la derecha del título del contenido de la pestaña.

**$hasVarData** debe ser ``true`` si este recopilador desea agregar datos adicionales a la pestaña ``Vars``. Si esto
es cierto, necesitarás implementar el método ``getVarData()``.

**$título** se muestra en las pestañas abiertas.

Mostrar una pestaña de la barra de herramientas
-----------------------------------------------

Para mostrar una pestaña de la barra de herramientas debe:

1. Complete ``$title`` con el texto que se muestra tanto en el título de la barra de herramientas como en el encabezado de la pestaña.
2. Establezca ``$hasTabContent`` en ``true``.
3. Implemente el método ``display()``.
4. Opcionalmente, implemente el método ``getTitleDetails()``.

``display()`` crea el HTML que se muestra dentro de la propia pestaña. No necesita preocuparse por
el título de la pestaña, ya que eso lo maneja automáticamente la barra de herramientas. Debería devolver una cadena de HTML.

El método ``getTitleDetails()`` debería devolver una cadena que se muestra justo a la derecha del título de la pestaña.
se puede utilizar para proporcionar información general adicional. Por ejemplo, la pestaña Base de datos muestra el total
número de consultas en todas las conexiones, mientras que la pestaña Archivos muestra el número total de archivos.

Proporcionar datos de cronograma
--------------------------------

Para proporcionar información que se mostrará en la Línea de tiempo debe:

1. Establezca ``$hasTimeline`` en ``true``.
2. Implemente el método ``formatTimelineData()``.

El método ``formatTimelineData()`` debe devolver una matriz de matrices formateadas de manera que la línea de tiempo pueda usar
para ordenarlo correctamente y mostrar la información correcta. Las matrices internas deben incluir la siguiente información:

.. literalinclude:: debugging/005.php

Proporcionar Vars
-----------------

Para agregar datos a la pestaña Vars debes:

1. Establezca ``$hasVarData`` en ``true``
2. Implemente el método ``getVarData()``.

El método ``getVarData()`` debe devolver una matriz que contenga matrices de pares clave/valor para mostrar. El nombre de
La clave de la matriz exterior es el nombre de la sección en la pestaña Vars:

.. literalinclude:: debugging/006.php

.. _debug-toolbar-hot-reload:

recarga en caliente
===================

La barra de herramientas de depuración incluye una función llamada Recarga en caliente que le permite realizar cambios en el código de su aplicación y recargarlos automáticamente en el navegador sin tener que actualizar la página. Esto supone un gran ahorro de tiempo durante el desarrollo.

Para habilitar la recarga en caliente mientras desarrolla, puede hacer clic en el botón en el lado izquierdo de la barra de herramientas que parece un ícono de actualización. Esto habilitará la recarga en caliente para todas las páginas hasta que la desactive.

Hot Reloading funciona escaneando los archivos dentro del directorio **app** cada segundo y buscando cambios. Si encuentra alguno, enviará un mensaje al navegador para recargar la página. No escanea ningún otro directorio, por lo que si realiza cambios en archivos fuera del directorio **app**, deberá actualizar la página manualmente.

Si necesita observar archivos fuera del directorio **app**, o lo encuentra lento debido al tamaño de su proyecto, puede especificar los directorios para escanear y las extensiones de archivo para escanear en ``$watchedDirectories`` y propiedades ``$watchedExtensions`` del archivo de configuración **app/Config/Toolbar.php**.
