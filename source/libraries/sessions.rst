######################
Biblioteca de sesiones
######################

La clase Session le permite mantener el "estado" de un usuario y realizar un seguimiento de su
actividad mientras navegan por su sitio.

Higgs viene con algunos controladores de almacenamiento de sesión, que puedes ver
en la última sección del índice:

.. contents::
    :local:
    :depth: 2

Usando la clase de sesión
*************************

Inicializando una sesión
========================

Las sesiones normalmente se ejecutarán globalmente con cada carga de página, por lo que la sesión
La clase debe inicializarse mágicamente.

Para acceder e inicializar la sesión:

.. literalinclude:: sessions/001.php

El parámetro ``$config`` es opcional: la configuración de su aplicación.
Si no se proporciona, el registro de servicios creará una instancia de su valor predeterminado.
uno.

Una vez cargado, el objeto de la biblioteca Sessions estará disponible usando::

    $sesión

Alternativamente, puede usar la función auxiliar que usará el valor predeterminado
opciones de configuración. Esta versión es un poco más amigable de leer,
pero no acepta ninguna opción de configuración.

.. literalinclude:: sessions/002.php

¿Cómo funcionan las sesiones?
=============================

Cuando se carga una página, la clase de sesión comprobará si hay una página válida.
La cookie de sesión es enviada por el navegador del usuario. Si una cookie de sesión no
**no** existe (o si no coincide con uno almacenado en el servidor o tiene
caducado) se creará y guardará una nueva sesión.

Si existe una sesión válida, su información se actualizará. Con cada
actualización, el ID de sesión puede regenerarse si está configurado para hacerlo.

Es importante que comprenda que una vez inicializada, la sesión
La clase se ejecuta automáticamente. No hay nada que debas hacer para causar el
comportamiento anterior para que suceda. Puedes, como verás a continuación, trabajar con sesión
datos, pero el proceso de lectura, escritura y actualización de una sesión es
automático.

.. note:: Under CLI, the Session library will automatically halt itself,
    ya que este es un concepto basado enteramente en el protocolo HTTP.

Una nota sobre la simultaneidad
------------------------

A menos que esté desarrollando un sitio web con un uso intensivo de AJAX, puede omitir esto
sección. Sin embargo, si es así y si está experimentando un rendimiento
problemas, entonces esta nota es exactamente lo que estás buscando.

Las sesiones en Higgs v2.x no implementaron el bloqueo,
lo que significaba que dos solicitudes HTTP usando la misma sesión podrían ejecutarse exactamente
al mismo tiempo. Para usar un término técnico más apropiado - las solicitudes fueron
sin bloqueo.

Sin embargo, las solicitudes sin bloqueo en el contexto de las sesiones también significan
No es seguro porque modifica los datos de la sesión (o la regeneración del ID de la sesión).
en una solicitud puede interferir con la ejecución de una segunda, concurrente
pedido. Este detalle fue la raíz de muchos problemas y la razón principal por la que
Higgs 3 tiene una biblioteca de sesiones completamente reescrita.

¿Por qué os contamos esto? Porque es probable que después de intentar
Si encuentra el motivo de sus problemas de rendimiento, puede concluir que bloquear
Ese es el problema y, por lo tanto, investiga cómo quitar las cerraduras...

¡NO HAGAS ESO! Quitar candados sería **incorrecto** y te provocará
¡mas problemas!

El bloqueo no es el problema, es una solución. Tu problema es que todavía
tener la sesión abierta, mientras ya la has procesado y por lo tanto no
ya no lo necesito. Entonces, lo que necesitas es cerrar la sesión por el
solicitud actual después de que ya no la necesite.

.. literalinclude:: sessions/003.php

¿Qué son los datos de sesión?
=============================

Los datos de la sesión son simplemente una matriz asociada con una ID de sesión particular.
(Galleta).

Si ha usado sesiones en PHP antes, debería estar familiarizado con PHP.
`$_SESSION superglobal<https://www.php.net/manual/en/reserved.variables.session.php>` _
(si no, lea el contenido de ese enlace).

Higgs da acceso a los datos de su sesión por el mismo medio, ya que
utiliza el mecanismo de controladores de sesión proporcionado por PHP. Usar datos de sesión es
tan simple como manipular (leer, configurar y desarmar valores) el ``$_SESSION``
formación.

.. note:: In general, it is bad practice to use global variables.
    Por lo tanto, no se recomienda utilizar el superglobal ``$_SESSION`` directamente.

Además, Higgs también proporciona 2 tipos especiales de datos de sesión.
que se explican con más detalle a continuación: `Flashdata`_ y `Tempdata`_.

.. note:: For historical reasons, we refer to session data excluding Flashdata and Tempdata as "userdata".

Recuperar datos de la sesión
============================

Cualquier información del conjunto de sesiones está disponible a través del
``$_SESSION`` superglobal:

.. literalinclude:: sessions/004.php

O mediante el método de acceso convencional:

.. literalinclude:: sessions/005.php

O a través del captador mágico:

.. literalinclude:: sessions/006.php

O incluso a través del método de ayuda de sesión:

.. literalinclude:: sessions/007.php

Donde ``item`` es la clave de matriz correspondiente al elemento que desea recuperar.
Por ejemplo, para asignar un elemento ``nombre`` previamente almacenado al elemento ``$nombre``
variable, harás esto:

.. literalinclude:: sessions/008.php

.. note:: The ``get()`` method returns null if the item you are trying
    para acceder no existe.

Si desea recuperar todos los datos de la sesión existente, simplemente puede
omita la clave del elemento (el captador mágico solo funciona para valores de propiedad individuales):

.. literalinclude:: sessions/009.php

.. important:: The ``get()`` method WILL return flashdata or tempdata items when
    recuperar un solo elemento por clave. No devolverá datos flash o datos temporales cuando
    Sin embargo, toma todos los datos de la sesión.

Agregar datos de sesión
=======================

Digamos que un usuario en particular inicia sesión en su sitio. Una vez autenticado, usted
podría agregar su nombre de usuario y dirección de correo electrónico a la sesión, haciendo que
datos globalmente disponibles para usted sin tener que ejecutar una consulta de base de datos cuando
lo necesita.

Simplemente puedes asignar datos a la matriz ``$_SESSION``, como con cualquier otro
variable. O como propiedad de ``$session``.

Puede pasar una matriz que contenga los datos de su nueva sesión al
Método ``set()``:

.. literalinclude:: sessions/010.php

Donde ``$array`` es una matriz asociativa que contiene sus nuevos datos. Aquí está
un ejemplo:

.. literalinclude:: sessions/011.php

Si desea agregar datos de sesión un valor a la vez, ``set()`` también
admite esta sintaxis:

.. literalinclude:: sessions/012.php

Si desea verificar que existe un valor de sesión, simplemente verifique con
``isset()``:

.. literalinclude:: sessions/013.php

O puedes llamar a ``has()``:

.. literalinclude:: sessions/014.php

Impulsar nuevo valor a los datos de la sesión
=============================================

El método ``push()`` se utiliza para insertar un nuevo valor en un valor de sesión que es una matriz.
Por ejemplo, si la clave ``hobbies`` contiene una serie de aficiones, puedes agregar un nuevo valor a la matriz de la siguiente manera:

.. literalinclude:: sessions/015.php

Eliminar datos de sesión
========================

Al igual que con cualquier otra variable, desarmar un valor en ``$_SESSION`` puede ser
hecho a través de ``unset()``:

.. literalinclude:: sessions/016.php

Además, así como ``set()`` se puede usar para agregar información a un
sesión, ``remove()`` se puede utilizar para eliminarlo, pasando el
clave de sesión. Por ejemplo, si desea eliminar ``algún_nombre`` de su
matriz de datos de sesión:

.. literalinclude:: sessions/017.php

Este método también acepta una serie de claves de elementos para desarmar:

.. literalinclude:: sessions/018.php

.. _sessions-flashdata:

datos flash
===========

Higgs admite "flashdata", o datos de sesión que sólo serán
disponible para la siguiente solicitud y luego se borra automáticamente.

Esto puede ser muy útil, especialmente para información puntual, error o
mensajes de estado (por ejemplo: "Registro 2 eliminado").

Cabe señalar que las variables flashdata son variables de sesión regulares,
administrado dentro del controlador de sesión de Higgs.

Para marcar un elemento existente como "flashdata":

.. literalinclude:: sessions/019.php

Si desea marcar varios elementos como datos flash, simplemente pase las claves como
formación:

.. literalinclude:: sessions/020.php

Para agregar datos flash:

.. literalinclude:: sessions/021.php

O alternativamente, usando el método ``setFlashdata()``:

.. literalinclude:: sessions/022.php

También puedes pasar una matriz a ``setFlashdata()``, de la misma manera que
``conjunto()``.

Leer variables de datos flash es lo mismo que leer datos de sesión normales.
a través de ``$_SESSION``:

.. literalinclude:: sessions/023.php

.. important:: The ``get()`` method WILL return flashdata items when
    recuperar un solo elemento por clave. No devolverá datos flash cuando
    Sin embargo, toma todos los datos de la sesión.

Sin embargo, si quiere estar seguro de que está leyendo "flashdata" (y no
cualquier otro tipo), también puedes usar el método ``getFlashdata()``:

.. literalinclude:: sessions/024.php

.. note:: The ``getFlashdata()`` method returns null if the item cannot be
    encontró.

O para obtener una matriz con todos los datos flash, simplemente omita el parámetro clave:

.. literalinclude:: sessions/025.php


Si descubre que necesita conservar una variable flashdata a través de un
solicitud adicional, puede hacerlo utilizando el método ``keepFlashdata()``.
Puede pasar un solo elemento o una serie de elementos de datos flash para conservar.

.. literalinclude:: sessions/026.php

datos temporales
================

Higgs también admite "tempdata", o datos de sesión con un
Tiempo de expiración. Después de que el valor expire, o la sesión expire o sea
eliminado, el valor se elimina automáticamente.

De manera similar a flashdata, las variables tempdata son administradas internamente por el
Manejador de sesión de Higgs.

Para marcar un elemento existente como "tempdata", simplemente pase su clave y su hora de caducidad.
(¡en segundos!) al método ``markAsTempdata()``:

.. literalinclude:: sessions/027.php

Puede marcar varios elementos como datos temporales de dos maneras, dependiendo de si
quieres que todos tengan el mismo tiempo de caducidad o no:

.. literalinclude:: sessions/028.php

Para agregar datos temporales:

.. literalinclude:: sessions/029.php

O alternativamente, usando el método ``setTempdata()``:

.. literalinclude:: sessions/030.php

También puedes pasar una matriz a ``setTempdata()``:

.. literalinclude:: sessions/031.php

.. note:: If the expiration is omitted or set to 0, the default
    Se utilizará un valor de tiempo de vida de 300 segundos (o 5 minutos).

Para leer una variable tempdata, nuevamente puede acceder a ella a través del
``$_SESSION`` matriz superglobal:

.. literalinclude:: sessions/032.php

.. important:: The ``get()`` method WILL return tempdata items when
    recuperar un solo elemento por clave. No devolverá tempdata cuando
    Sin embargo, toma todos los datos de la sesión.

O si quieres estar seguro de que estás leyendo "tempdata" (y no cualquier
otro tipo), también puedes usar el método ``getTempdata()``:

.. literalinclude:: sessions/033.php

.. note:: The ``getTempdata()`` method returns null if the item cannot be
    encontró.

Y, por supuesto, si desea recuperar todos los datos temporales existentes:

.. literalinclude:: sessions/034.php

Si necesita eliminar un valor de tempdata antes de que caduque, puede hacerlo directamente
desactívelo de la matriz ``$_SESSION``:

.. literalinclude:: sessions/035.php

Sin embargo, esto no eliminará el marcador que hace que este elemento específico sea
tempdata (se invalidará en la siguiente solicitud HTTP), por lo que si
tiene la intención de reutilizar esa misma clave en la misma solicitud, querrá usar
``eliminarTempdata()``:

.. literalinclude:: sessions/036.php

Cerrar una sesión
=================

.. _session-close:

cerca()
-------

.. versionadded:: 4.4.0

Para cerrar la sesión actual manualmente después de que ya no la necesite, utilice el
Método ``cerrar()``:

.. literalinclude:: sessions/044.php

No es necesario cerrar la sesión manualmente, PHP la cerrará automáticamente
después de que terminó su script. Pero como los datos de la sesión están bloqueados para evitar la concurrencia
escribe sólo una solicitud puede operar en una sesión en cualquier momento. puedes mejorar
el rendimiento de su sitio cerrando la sesión tan pronto como se realicen todos los cambios en la sesión
Los datos están hechos.

Este método funcionará exactamente de la misma manera que el de PHP.
`session_write_close()<https://www.php.net/session_write_close>` _ función.

Destruir una sesión
===================

.. _session-destroy:

destruir()
---------

Para borrar la sesión actual (por ejemplo, durante un cierre de sesión), puede
simplemente use el método ``destroy()`` de la biblioteca:

.. literalinclude:: sessions/037.php

Este método funcionará exactamente de la misma manera que el de PHP.
`session_destroy()<https://www.php.net/session_destroy>` _ función.

Esta debe ser la última operación relacionada con la sesión que realice durante la misma solicitud.
Todos los datos de la sesión (incluidos flashdata y tempdata) se destruirán permanentemente.

.. note:: You do not have to call this method from usual code. Cleanup session
    datos en lugar de destruir la sesión.

.. _session-stop:

detener()
------

.. deprecated:: 4.3.5

La clase de sesión también tiene el método ``stop()``.

.. warning:: Prior to v7.3.5, this method did not destroy the session due to a bug.

A partir de v7.3.5, este método se modificó para destruir la sesión.
Sin embargo, está en desuso porque es exactamente igual que ``destroy()``
método. Utilice el método ``destroy()`` en su lugar.

Acceder a los metadatos de la sesión
====================================

En Higgs 2, la matriz de datos de la sesión incluía 4 elementos
de forma predeterminada: 'id_sesión', 'dirección_ip', 'agente_usuario', 'última_actividad'.

Esto se debió a las características específicas de cómo funcionaban las sesiones, pero ahora ya no es así.
necesario con nuestra nueva implementación. Sin embargo, puede suceder que su
La aplicación se basó en estos valores, por lo que aquí hay métodos alternativos de
accediendo a ellos:

  - session_id: ``$session->session_id`` o ``session_id()`` (función integrada de PHP)
  - dirección_ip: ``$_SERVER['REMOTE_ADDR']``
  - user_agent: ``$_SERVER['HTTP_USER_AGENT']`` (no utilizado por sesiones)
  - last_activity: Depende del almacenamiento, no es una forma sencilla. ¡Lo siento!

Preferencias de sesión
**********************

Higgs normalmente hará que todo funcione de inmediato. Sin embargo,
Las sesiones son un componente muy sensible de cualquier aplicación, por lo que algunas
Se debe realizar una configuración cuidadosa. Por favor tómate tu tiempo para considerar
todas las opciones y sus efectos.

.. note:: Since v7.3.0, the new **app/Config/Session.php** has been added.
    Anteriormente, las Preferencias de sesión estaban en su archivo **app/Config/App.php**.

Encontrarás las siguientes preferencias relacionadas con la sesión en tu
Archivo **app/Config/Session.php**:
======================= ============================ ================= ================================== ================ =================================== ==================================================== ========
Preferencia Opciones predeterminadas Descripción
======================= ============================ ================= ================================== ================ =================================== ==================================================== ========
**controlador** Higgs\\Session\\Handlers\\FileHandler Higgs\\Session\\Handlers\\FileHandler El controlador de almacenamiento de sesión que se utilizará.
                                                                     Higgs\\Sesión\\Handlers\\DatabaseHandler
                                                                     Higgs\\Sesión\\Handlers\\MemcachedHandler
                                                                     Higgs\\Sesión\\Handlers\\RedisHandler
                                                                     Higgs\\Sesión\\Handlers\\ArrayHandler
**cookieName** HIGGS_session [A-Za-z\_-] solo caracteres El nombre utilizado para la cookie de sesión.
**expiración** 7200 (2 horas) Tiempo en segundos (entero) La cantidad de segundos que desea que dure la sesión.
                                                                                                                       Si desea una sesión que no expire (hasta que se cierre el navegador), establezca el valor en cero: 0
**savePath** null Ninguno Especifica la ubicación de almacenamiento; depende del controlador que se utilice.
**matchIP** falso verdadero/falso (booleano) Si se valida la dirección IP del usuario al leer la cookie de sesión.
                                                                                                                       Tenga en cuenta que algunos ISP cambian dinámicamente la IP, por lo que si desea una sesión que no expire, puede
                                                                                                                       probablemente establecerá esto en falso.
**timeToUpdate** 300 Tiempo en segundos (entero) Esta opción controla la frecuencia con la que la clase de sesión se regenerará y creará una nueva
                                                                                                                       ID de sesión. Establecerlo en 0 deshabilitará la regeneración de ID de sesión.
**regenerateDestroy** falso verdadero/falso (booleano) Si se deben destruir los datos de la sesión asociados con el ID de la sesión anterior durante la regeneración automática
                                                                                                                       la identificación de la sesión. Cuando se establece en falso, el recolector de basura eliminará posteriormente los datos.
======================= ============================ ================= ================================== ================ =================================== ==================================================== ========

.. note:: As a last resort, the Session library will try to fetch PHP's
    configuraciones INI relacionadas con la sesión, así como configuraciones de Higgs 3 como
    'sess_expire_on_close' cuando alguno de los anteriores no está configurado.
    Sin embargo, nunca debes confiar en este comportamiento ya que puede causar
    resultados inesperados o ser modificados en el futuro. Por favor configure
    todo correctamente.

.. note:: If ``expiration`` is set to ``0``, the ``session.gc_maxlifetime``
    La configuración establecida por PHP en la gestión de sesiones se utilizará tal cual
    (a menudo el valor predeterminado de ``1440``). Esto debe cambiarse en
    ``php.ini`` o mediante ``ini_set()`` según sea necesario.

Además de los valores anteriores, la cookie de sesión utiliza el
siguientes valores de configuración en su archivo **app/Config/Cookie.php**:
============== =============== ====================== ==================================================== ====
Preferencia Descripción predeterminada
============== =============== ====================== ==================================================== ====
**dominio** '' El dominio al que se aplica la sesión
**ruta** / La ruta a la que se aplica la sesión
**seguro** falso Si se debe crear la cookie de sesión solo en conexiones cifradas (HTTPS)
**sameSite** Lax La configuración de SameSite para la cookie de sesión
============== =============== ====================== ==================================================== ====

.. note:: The ``httponly`` setting doesn't have an effect on sessions.
    En cambio, el parámetro HttpOnly siempre está habilitado, por seguridad.
    razones. Además, la configuración ``Config\Cookie::$prefix`` está completamente
    ignorado.

Controladores de sesión
***********************

Como ya se mencionó, la biblioteca Session viene con 4 controladores o almacenamiento
motores, que puedes utilizar:

  - Higgs\\Sesión\\Handlers\\FileHandler
  - Higgs\\Sesión\\Handlers\\DatabaseHandler
  - Higgs\\Sesión\\Handlers\\MemcachedHandler
  - Higgs\\Sesión\\Handlers\\RedisHandler
  - Higgs\\Sesión\\Handlers\\ArrayHandler

De forma predeterminada, el controlador ``FileHandler`` se utilizará cuando se inicialice una sesión.
porque es la opción más segura y se espera que funcione en todas partes
(prácticamente todos los entornos tienen un sistema de archivos).

Sin embargo, se puede seleccionar cualquier otro controlador a través del ``controlador $público``.
línea en su archivo **app/Config/Session.php**, si decide hacerlo.
Sin embargo, tenga en cuenta que cada conductor tiene diferentes advertencias, así que asegúrese de
familiarícese con ellos (a continuación) antes de tomar esa decisión.

.. note:: The ArrayHandler is used during testing and stores all data within
    una matriz PHP, evitando al mismo tiempo que los datos persistan.

Controlador FileHandler (el predeterminado)
===========================================

El controlador 'FileHandler' utiliza su sistema de archivos para almacenar datos de sesión.

Se puede decir con seguridad que funciona exactamente como la sesión predeterminada de PHP.
implementación, pero en caso de que este sea un detalle importante para usted, téngalo
Tenga en cuenta que, de hecho, no es el mismo código y tiene algunas limitaciones.
(y ventajas).

Para ser más específico, no es compatible con el nivel y modo de directorio de PHP.
formatos utilizados en session.save_path
<https://www.php.net/manual/en/session.configuration.php#ini.session.save-path>`_,
y tiene la mayoría de las opciones codificadas por seguridad. En cambio, sólo
Se admiten rutas absolutas para ``cadena pública $savePath``.

Otra cosa importante que debes saber es asegurarte de que
No utilice un directorio compartido o legible públicamente para almacenar su sesión.
archivos. Asegúrate de que *solo tú* tengas acceso para ver el contenido de tu
directorio *savePath* elegido. De lo contrario, cualquiera que pueda hacer eso, puede
también robar cualquiera de las sesiones actuales (también conocido como "fijación de sesión"
ataque).

En sistemas operativos tipo UNIX, esto generalmente se logra configurando el
0700 permisos de modo en ese directorio a través del comando `chmod`, que
permite que sólo el propietario del directorio realice operaciones de lectura y escritura en
él. Pero tenga cuidado porque el usuario del sistema que *ejecuta* el script suele ser
no el tuyo, sino algo así como 'www-data', por lo que solo configura esos
Los permisos probablemente dañarán su aplicación.

En su lugar, deberías hacer algo como esto, dependiendo de tu entorno:

.. code-block:: console

    mkdir /<path to your application directory> /escribible/sesiones/
    chmod 0700 /<path to your application directory> /escribible/sesiones/
    chown www-datos /<path to your application directory> /escribible/sesiones/

Consejo adicional
---------

Algunos de ustedes probablemente optarán por elegir otro controlador de sesión porque
El almacenamiento de archivos suele ser más lento. Esto es sólo una verdad a medias.

Una prueba muy básica probablemente le hará creer que un SQL
La base de datos es más rápida, pero en el 99% de los casos, esto sólo es cierto mientras
Sólo tengo algunas sesiones actuales. A medida que las sesiones cuentan y el servidor se carga
aumento - que es el momento en el que importa - el sistema de archivos
superan consistentemente a casi todas las configuraciones de bases de datos relacionales.

Además, si el rendimiento es su única preocupación, es posible que desee buscar
en el uso de `tmpfs<https://eddmann.com/posts/storing-php-sessions-file-caches-in-memory-using-tmpfs/>` _,
(advertencia: recurso externo), lo que puede hacer que sus sesiones sean increíblemente rápidas.

.. _sessions-databasehandler-driver:

Controlador del controlador de base de datos
============================================

.. important:: Only MySQL and PostgreSQL databases are officially
    apoyado, debido a la falta de mecanismos de bloqueo de asesoramiento en otros
    plataformas. El uso de sesiones sin bloqueos puede provocar todo tipo de problemas.
    problemas, especialmente con el uso intensivo de AJAX, y no lo haremos
    apoyar tales casos. Utilice el método :ref:`session-close` después de haber
    terminado de procesar los datos de la sesión si está teniendo rendimiento
    asuntos.

El controlador 'DatabaseHandler' utiliza una base de datos relacional como MySQL o
PostgreSQL para almacenar sesiones. Esta es una opción popular entre muchos usuarios,
porque permite al desarrollador acceder fácilmente a los datos de la sesión dentro
una aplicación: es simplemente otra tabla en su base de datos.

Sin embargo, hay algunas condiciones que deben cumplirse:

  - NO puedes utilizar una conexión persistente.

Configurar el controlador de Base de datos
------------------------------

Nombre de la tabla de configuración
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Para utilizar el controlador de sesión 'DatabaseHandler', también debe crear este
tabla que ya mencionamos y luego configúrala como tu
Valor ``$savePath``.
Por ejemplo, si desea utilizar 'HIGGS_sessions' como nombre de su tabla,
harías esto:

.. literalinclude:: sessions/039.php

Crear tabla de base de datos
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Y luego por supuesto, crear la tabla de la base de datos...

Para MySQL::

    CREAR TABLA SI NO EXISTE `HIGGS_sessions` (
        `id` varchar(128) NO nulo,
        `dirección_ip` varchar(45) NO nulo,
        `marca de tiempo` marca de tiempo DEFAULT CURRENT_TIMESTAMP NO nulo,
        blob `datos` NO nulo,
        CLAVE `HIGGS_sessions_timestamp` (`marca de tiempo`)
    );

Para PostgreSQL::

    CREAR TABLA "HIGGS_sessions" (
        "id" varchar(128) NO NULO,
        "dirección_ip" inet NO NULO,
        "marca de tiempo" marca de tiempo DEFAULT CURRENT_TIMESTAMP NOT NULL,
        "datos" bytea DEFAULT '' NO NULO
    );

    CREAR ÍNDICE "HIGGS_sessions_timestamp" EN "HIGGS_sessions" ("marca de tiempo");

.. note:: The ``id`` value contains the session cookie name (``Config\Session::$cookieName``)
    y el ID de sesión y un delimitador. Se debe aumentar según sea necesario, por ejemplo,
    cuando se utilizan ID de sesión largas.

Agregar clave principal
^^^^^^^^^^^^^^^^^^^^^^^

También necesitarás agregar una CLAVE PRIMARIA **dependiendo de tu $matchIP
configuración**. Los siguientes ejemplos funcionan tanto en MySQL como en PostgreSQL::

    // Cuando $matchIP = verdadero
    ALTERAR TABLA HIGGS_sessions AÑADIR CLAVE PRIMARIA (id, dirección_ip);

    // Cuando $matchIP = falso
    ALTERAR TABLA HIGGS_sessions AÑADIR CLAVE PRIMARIA (id);

    // Para eliminar una clave principal creada previamente (úsela al cambiar la configuración)
    ALTER TABLA HIGGS_sessions DROP PRIMARY KEY;

.. important:: If you don't add the correct primary key, the following error
    puede ocurrir::

        mysqli_sql_exception no detectado: entrada duplicada 'HIGGS_session:***' para la clave 'HIGGS_sessions.PRIMARY'

Cambiar grupo de base de datos
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

El grupo de base de datos predeterminado se utiliza de forma predeterminada.
Puede cambiar el grupo de base de datos a utilizar cambiando la propiedad ``$DBGroup``
en el archivo **app/Config/Session.php** al nombre del grupo a usar:

.. literalinclude:: sessions/040.php

Configurar la tabla de la base de datos con el comando
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Si prefiere no hacer todo esto a mano, puede usar el comando ``make:migration --session``
desde el cli para generar un archivo de migración para usted:

.. code-block:: console

  php spark make:migración --sesión
  migración de chispa php

Este comando tendrá en cuenta las configuraciones ``$savePath`` y ``$matchIP``
cuando genera el código.

.. _sessions-redishandler-driver:

Controlador RedisHandler
========================

.. note:: Since Redis doesn't have a locking mechanism exposed, locks for
    este controlador se emula mediante un valor separado que se mantiene hasta
    a 300 segundos. Con ``v7.3.2`` o superior, puede conectar ``Redis`` con el protocolo **TLS**.

Redis es un motor de almacenamiento que normalmente se usa para almacenamiento en caché y es popular porque
de su alto rendimiento, que probablemente también sea su razón para utilizar el
Controlador de sesión 'RedisHandler'.

La desventaja es que no es tan omnipresente como las bases de datos relacionales y
requiere el `phpredis<https://github.com/phpredis/phpredis>` _PHP
extensión que se instalará en su sistema y esa no viene
incluido con PHP.
Lo más probable es que solo esté utilizando el controlador RedisHandler si ya está
ambos familiarizados con Redis y usándolo para otros fines.

Configurar RedisHandler
----------------------

Al igual que con los controladores 'FileHandler' y 'DatabaseHandler', también debes configurar
la ubicación de almacenamiento de sus sesiones a través del
Configuración ``$savePath``.
El formato aquí es un poco diferente y complicado al mismo tiempo. Es
se explica mejor con el archivo README de la extensión *phpredis*, por lo que simplemente
te enlace a el:

    https://github.com/phpredis/phpredis

.. important:::: Higgs's Session library does NOT use the actual 'redis'
    ``session.save_handler``. Tome nota **sólo** del formato de ruta en
    el enlace de arriba.

Sin embargo, para el caso más común, se debe utilizar un par simple ``host:puerto``.
suficiente:

.. literalinclude:: sessions/041.php

.. _sessions-memcachedhandler-driver:

Controlador MemcachedHandler
============================

.. note:: Since Memcached doesn't have a locking mechanism exposed, locks
    para este controlador se emula mediante un valor separado que se conserva para
    hasta 300 segundos.

El controlador 'MemcachedHandler' es muy similar al 'RedisHandler' en todos sus
propiedades, excepto quizás por la disponibilidad, porque `Memcached de PHP
<https://www.php.net/memcached>`_ la extensión se distribuye a través de PECL y algunos
Las distribuciones de Linux lo ponen a disposición como un paquete fácil de instalar.

Aparte de eso, y sin ningún sesgo intencional hacia Redis, hay
No hay mucha diferencia que decir sobre Memcached: también es un popular
Producto que normalmente se utiliza para el almacenamiento en caché y es famoso por su velocidad.

Sin embargo, cabe señalar que la única garantía que ofrece Memcached
es que configurar el valor X para que caduque después de Y segundos resultará en que se
eliminado después de que hayan pasado Y segundos (pero no necesariamente que no
caducan antes de esa fecha). Esto sucede muy raramente, pero debe ser
considerado ya que puede resultar en la pérdida de sesiones.

Configurar MemcachedHandler
--------------------------

El formato ``$savePath`` es bastante sencillo aquí,
siendo sólo un par ``host:puerto``:

.. literalinclude:: sessions/042.php

Consejo adicional
---------

Configuración multiservidor con un parámetro opcional *peso* como
También se admite el tercer valor separado por dos puntos (``:peso``), pero tenemos
Cabe señalar que no hemos probado si eso es confiable.

Si desea experimentar con esta función (bajo su propio riesgo), simplemente
separe las múltiples rutas del servidor con comas:

.. literalinclude:: sessions/043.php
