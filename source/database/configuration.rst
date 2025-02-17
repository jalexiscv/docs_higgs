##############################
Configuración de base de datos
##############################

.. contents::
    :local:
    :depth: 3

.. note::

    Consulte :ref:`requirements-supported-databases` para conocer los controladores de bases de datos actualmente compatibles.


Archivo de configuración
************************

Higgs tiene un archivo de configuración que te permite almacenar tu base de datos
valores de conexión (nombre de usuario, contraseña, nombre de la base de datos, etc.). La configuración
El archivo se encuentra en **app/Config/Database.php**. También puedes configurar
valores de conexión de la base de datos en el archivo **.env**. Consulte a continuación para obtener más detalles.

Configuración de la base de datos predeterminada
================================================

Los ajustes de configuración se almacenan en una propiedad de clase que es una matriz con este
prototipo:

.. literalinclude:: configuration/001.php

El nombre de la propiedad de clase es el nombre de la conexión y se puede utilizar
mientras se conecta para especificar un nombre de grupo.

.. note:: The default location of the SQLite3 database is in the **writable** folder.
    Si desea cambiar la ubicación, debe establecer la ruta completa a la nueva carpeta.

DSN
---

Algunos controladores de bases de datos (como Postgre, OCI8) requieren una cadena DSN completa para conectarse.
Pero si no especifica una cadena DSN para un controlador que la requiere, Higgs
Intentaremos construirlo con el resto de las configuraciones proporcionadas.

Si especifica un DSN, debe usar la opción de configuración ``'DSN'``, como si
estás usando la extensión PHP nativa subyacente del controlador, como esta:

.. literalinclude:: configuration/002.php
    :lines: 11-15

DSN de manera universal
^^^^^^^^^^^^^^^^^^^^^^^

También puede establecer un nombre de fuente de datos de manera universal (como una URL). En ese caso los DSN deben tener este prototipo:

.. literalinclude:: configuration/003.php
    :lines: 11-14

Para anular los valores de configuración predeterminados al conectarse con una versión universal de la cadena DSN,
agregue las variables de configuración como una cadena de consulta:

.. literalinclude:: configuration/004.php
    :lines: 11-15

.. literalinclude:: configuration/010.php
    :lines: 11-15

.. note:: If you provide a DSN string and it is missing some valid settings (e.g., the
    conjunto de caracteres de la base de datos), que están presentes en el resto de la configuración
    campos, Higgs los agregará.

Conmutaciones por error
---------

También puede especificar conmutación por error para la situación en la que la conexión principal no puede conectarse por algún motivo.
Estas conmutaciones por error se pueden especificar configurando la conmutación por error para una conexión como esta:

.. literalinclude:: configuration/005.php

Puede especificar tantas conmutaciones por error como desee.

Configuración de múltiples bases de datos
=========================================

Opcionalmente, puede almacenar varios conjuntos de conexiones.
valores. Si, por ejemplo, ejecuta varios entornos (desarrollo,
producción, prueba, etc.) bajo una sola instalación, puede configurar un
grupo de conexión para cada uno, luego cambie entre grupos según sea necesario. Para
Por ejemplo, para configurar un entorno de "prueba", haría esto:

.. literalinclude:: configuration/006.php

Luego, para decirle globalmente al sistema que use ese grupo, configuraría esto
variable ubicada en el archivo de configuración:

.. literalinclude:: configuration/007.php

.. note:: The name ``test`` is arbitrary. It can be anything you want. By
    Por defecto hemos usado la palabra ``predeterminado`` para la conexión principal,
    pero también se le puede cambiar el nombre a algo más relevante para su proyecto.

Cambiar bases de datos automáticamente
======================================

Puede modificar el archivo de configuración para detectar el entorno y automáticamente
actualice el valor ``defaultGroup`` al correcto agregando la lógica requerida
dentro del constructor de la clase:

.. literalinclude:: configuration/008.php

.. _database-config-with-env-file:


Configurando con el archivo .env
********************************

También puede guardar sus valores de configuración dentro de un archivo **.env** con el servidor actual.
configuración de la base de datos. Sólo necesita ingresar los valores que cambian de lo que está en el
ajustes de configuración predeterminados del grupo. Los valores deben ser nombre siguiendo este formato, donde
``predeterminado`` es el nombre del grupo::

    base de datos.default.nombre de usuario = 'raíz&#39;;
    base de datos.default.contraseña = '&#39;;
    base de datos.default.database = 'H4&#39;;

Pero no puede agregar una nueva propiedad estableciendo variables de entorno, ni cambiar una
valor escalar a una matriz. Consulte :ref:`env-var-replacements-for-data` para obtener más detalles.

Entonces, si quieres usar SSL con MySQL, necesitas un truco. Por ejemplo, establezca la matriz
valores como una cadena JSON en su archivo **.env**:

::

    base de datos.default.encrypt = {"ssl_verify":true,"ssl_ca":"/var/www/html/BaltimoreCyberTrustRoot.crt.pem"}

y decodificarlo en el constructor de la clase Config:

.. literalinclude:: configuration/009.php

.. _database-config-explanation-of-values:


Explicación de Valores:

***********************

================ =================================== ==================================================== ========================
 Nombre Configuración Descripción
================ =================================== ==================================================== ========================
**DSN** La cadena de conexión DSN (una secuencia de configuración todo en uno).
**nombre de host** El nombre de host de su servidor de base de datos. A menudo esto es "localhost".
**nombre de usuario** El nombre de usuario utilizado para conectarse a la base de datos. (``SQLite3`` no usa esto.)
**contraseña** La contraseña utilizada para conectarse a la base de datos. (``SQLite3`` no usa esto.)
**base de datos** El nombre de la base de datos a la que desea conectarse.

                 .. note:: Higgs doesn't support dots (``.``) in the database, table, and column names.
**DBDriver** El nombre del controlador de la base de datos. El caso debe coincidir con el nombre del conductor.
                 Puede configurar un nombre de clase completo para usar su controlador personalizado.
                 Controladores compatibles: ``MySQLi``, ``Postgre``, ``SQLite3``, ``SQLSRV`` y ``OCI8``.
**DBPrefix** Un prefijo de tabla opcional que se agregará al nombre de la tabla cuando se ejecute
                 :doc:`Creador de consultas<query_builder>`  consultas. Esto permite múltiples Higgs
                 instalaciones para compartir una base de datos.
**pConnect** verdadero/falso (booleano): si se debe utilizar una conexión persistente.
**DBDebug** verdadero/falso (booleano): si se deben generar excepciones o no cuando se producen errores en la base de datos.
**charset** El juego de caracteres utilizado para comunicarse con la base de datos.
**DBCollat** La intercalación de caracteres utilizada para comunicarse con la base de datos (sólo ``MySQLi``).
**swapPre** Un prefijo de tabla predeterminado que debe intercambiarse con ``DBPrefix``. Esto es útil para distribuido.
                 aplicaciones en las que puede ejecutar consultas escritas manualmente y necesita que el prefijo aún esté
                 personalizable por el usuario final.
**esquema** El esquema de la base de datos, el valor predeterminado varía según el controlador. (Usado por ``Postgre`` y ``SQLSRV``.)
**cifrar** Si se utiliza o no una conexión cifrada.
                 El controlador ``SQLSRV`` acepta verdadero/falso
                 El controlador ``MySQLi`` acepta una matriz con las siguientes opciones:

                 * ``ssl_key`` - Ruta al archivo de clave privada
                 * ``ssl_cert`` - Ruta al archivo del certificado de clave pública
                 * ``ssl_ca`` - Ruta al archivo de autoridad de certificación
                 * ``ssl_capath``: ruta a un directorio que contiene certificados de CA confiables en formato PEM
                 * ``ssl_cipher`` - Lista de cifrados *permitidos* que se utilizarán para el cifrado, separados por dos puntos (``:``)
                 * ``ssl_verify`` - verdadero/falso; Si se debe verificar el certificado del servidor o no (sólo ``MySQLi``)
**compress** Si se utiliza o no la compresión del cliente (sólo ``MySQLi``).
**strictOn** verdadero/falso (booleano): si se deben forzar conexiones en "modo estricto", bueno para garantizar SQL estricto
                 mientras desarrolla una aplicación (sólo ``MySQLi``).
**puerto** El número de puerto de la base de datos - Cadena vacía ``''`` para el puerto predeterminado (o puerto dinámico con ``SQLSRV``).
**foreignKeys** verdadero/falso (booleano): si se habilita o no la restricción de clave externa (solo ``SQLite3``).

                 .. important:: SQLite3 Foreign Key constraint is disabled by default.
                     Ver `documentación de SQLite<https://www.sqlite.org/pragma.html#pragma_foreign_keys>` _.
                     Para aplicar la restricción de clave externa, establezca este elemento de configuración en verdadero.
**busyTimeout** milisegundos (int): duerme durante un período de tiempo específico cuando una tabla está bloqueada (solo ``SQLite3``).
**numberNative** verdadero/falso (booleano): si se habilita o no MYSQLI_OPT_INT_AND_FLOAT_NATIVE (solo ``MySQLi``).
================ =================================== ==================================================== ========================

.. note:: Depending on what database driver you are using (``MySQLi``, ``Postgre``,
    etc.) no se necesitarán todos los valores. Por ejemplo, al utilizar ``SQLite3``
    No será necesario proporcionar un nombre de usuario o contraseña, y el nombre de la base de datos.
    será la ruta a su archivo de base de datos.
