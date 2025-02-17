#############################
Migraciones de bases de datos
#############################

Las migraciones son una forma conveniente de modificar su base de datos de una manera
manera estructurada y organizada. Podrías editar fragmentos de SQL a mano.
pero luego serías responsable de decirles a otros desarrolladores que
Necesito ir y ejecutarlos. También tendrías que realizar un seguimiento de los cambios
debe ejecutarse en las máquinas de producción la próxima vez que realice la implementación.

La tabla de base de datos **migraciones** rastrea qué migraciones ya se han realizado.
ejecutar, así que todo lo que tienes que hacer es asegurarte de que tus migraciones estén en su lugar y
ejecute el comando ``spark chose`` para actualizar la base de datos a la versión más reciente
estado. También puedes usar ``spark migrar --all`` para
incluir migraciones de todos los espacios de nombres.

.. contents::
    :local:
    :depth: 2


Nombres de archivos de migración
********************************

Cada migración se ejecuta en orden numérico hacia adelante o hacia atrás dependiendo del
método adoptado. Cada migración se numera utilizando la marca de tiempo en la que se realizó la migración.
se creó, en formato **AAAA-MM-DD-HHIISS** (por ejemplo, **2012-10-31-100537**). Este ayuda a prevenir
conflictos de numeración cuando se trabaja en un entorno de equipo.

Anteponga a sus archivos de migración el número de migración seguido de un guión bajo.
y un nombre descriptivo para la migración. El año, mes y fecha se pueden separar.
entre sí mediante guiones, guiones bajos o ninguno. Por ejemplo:

* 2012-10-31-100538_AlterBlogTrackViews.php
* 2012_10_31_100539_AlterBlogAddTranslations.php
* 20121031100537_AddBlog.php

.. warning::
   En Higgs, las migraciones siguen un formato específico para garantizar que se apliquen en el orden correcto. Aunque Higgs es un framework bastante flexible, es importante seguir las convenciones establecidas para evitar problemas. Por ejemplo si no se usa el guión bajo en el nombre del archivo no se considerara una migracion valida por lo tanto simplemente no se ejecutara.



Crear una migración
*******************

Esta será la primera migración para un nuevo sitio que tiene un blog. Todo
Las migraciones van en el directorio **app/Database/Migrations/** y tienen nombres como
como **2022-01-31-013057_AddBlog.php**.

.. literalinclude:: migration/001.php

La conexión de la base de datos y la clase Forge de la base de datos están disponibles a través de
``$this->db`` y ``$this->forge``, respectivamente.

Alternativamente, puede utilizar una llamada de línea de comandos para generar un archivo de migración esqueleto.
Consulte **make:migration** en :ref:`command-line-tools` para obtener más detalles.

.. note:: Since the migration class is a PHP class, the classname must be unique in every migration file.

Llaves extranjeras
==================

Cuando sus tablas incluyen claves externas, las migraciones a menudo pueden causar problemas al intentar eliminar tablas y columnas.
Para omitir temporalmente las comprobaciones de clave externa mientras ejecuta migraciones, use ``disableForeignKeyChecks()`` y
Métodos ``enableForeignKeyChecks()`` en la conexión de la base de datos.

.. literalinclude:: migration/002.php

Grupos de bases de datos
========================

Una migración solo se ejecutará en un único grupo de bases de datos. Si tiene varios grupos definidos en
**app/Config/Database.php**, luego, de forma predeterminada, se ejecutará en el ``$defaultGroup`` como se especifica
en ese mismo archivo de configuración.

Puede haber ocasiones en las que necesite diferentes esquemas para diferentes
grupos de bases de datos. Quizás tenga una base de datos que se utilice para toda la información general del sitio, mientras
Se utiliza otra base de datos para datos de misión crítica.

Puede asegurarse de que las migraciones se ejecuten únicamente
contra el grupo adecuado configurando la propiedad ``$DBGroup`` en su migración. Este nombre debe
coincidir exactamente con el nombre del grupo de bases de datos:

.. literalinclude:: migration/003.php

.. note:: The **migrations** table that tracks which migrations have already been
    run siempre se creará en el grupo de base de datos predeterminado.

Espacios de nombres
===================

La biblioteca de migración puede escanear automáticamente todos los espacios de nombres que haya definido dentro
**app/Config/Autoload.php** o cargado desde una fuente externa como Composer, usando
la propiedad ``$psr4`` para hacer coincidir nombres de directorio. Incluirá todas las migraciones.
se encuentra en **Base de datos/Migraciones**.

Cada espacio de nombres tiene su propia secuencia de versiones, esto le ayudará a actualizar y degradar cada módulo (espacio de nombres) sin afectar otros espacios de nombres.

Por ejemplo, supongamos que tenemos los siguientes espacios de nombres definidos en nuestro Autoload
archivo de configuración:

.. literalinclude:: migration/004.php

Esto buscará cualquier migración ubicada tanto en **APPPATH/Database/Migrations** como en
**ROOTPATH/MiEmpresa/Base de datos/Migraciones**. Esto simplifica la inclusión de migraciones en su
conjuntos de códigos modulares y reutilizables.

.. _command-line-tools:


Herramientas de línea de comandos
*********************************

Higgs se envía con varios :doc:`comandos</cli/spark_commands>`  que están disponibles desde la línea de comando para ayudar
trabajas con migraciones. Estas herramientas facilitan las cosas para aquellos de ustedes
que deseen utilizarlos. Las herramientas brindan principalmente acceso a los mismos métodos que están disponibles dentro de la clase MigrationRunner.

emigrar
=======

Migra un grupo de bases de datos con todas las migraciones disponibles:

.. code-block:: console

    migración de chispa php

Puede utilizar (migrar) con las siguientes opciones:

- ``-g`` - para especificar el grupo de base de datos. Si se especifica, solo se ejecutarán las migraciones para el grupo de bases de datos especificado. Si no se especifica, se ejecutarán todas las migraciones.
- ``-n`` - para elegir el espacio de nombres; de lo contrario, se utilizará el espacio de nombres ``App``.
- ``--all`` - para migrar todos los espacios de nombres a la última migración.

Este ejemplo migrará el espacio de nombres ``Acme\Blog`` con cualquier nueva migración en el grupo de bases de datos de prueba:

Para Unix:

.. code-block:: console

    php spark migrar -g prueba -n Acme\\Blog

Para ventanas:

.. code-block:: console

    php spark migrar -g prueba -n Acme\Blog

Al usar la opción ``--all``, escaneará todos los espacios de nombres intentando encontrar cualquier migración que tenga
no se ha ejecutado. Todos estos se recopilarán y luego se ordenarán como un grupo por fecha de creación. esto debería ayudar
para minimizar cualquier conflicto potencial entre la aplicación principal y cualquier módulo.

Retroceder
==========

Revierte todas las migraciones a una pizarra en blanco, efectivamente migración 0:

.. code-block:: console

  php spark migrar: revertir

Puede utilizar (revertir) con las siguientes opciones:

- ``-b`` - para elegir un lote: los números naturales especifican el lote.
- ``-f``: para forzar una pregunta de confirmación de omisión, solo se hace en un entorno de producción.

actualizar
==========

Actualiza el estado de la base de datos deshaciendo primero todas las migraciones y luego migrando todas:

.. code-block:: console

  php spark migrar: actualizar

Puede usar (actualizar) con las siguientes opciones:

- ``-g`` - para especificar el grupo de base de datos. Si se especifica, solo se ejecutarán las migraciones para el grupo de bases de datos especificado. Si no se especifica, se ejecutarán todas las migraciones.
- ``-n`` - para elegir el espacio de nombres; de lo contrario, se utilizará el espacio de nombres ``App``.
- ``--all`` - para actualizar todos los espacios de nombres.
- ``-f``: para forzar una pregunta de confirmación de omisión, solo se hace en un entorno de producción.

estado
======

Muestra una lista de todas las migraciones y la fecha y hora en que se ejecutaron, o '--' si no se ejecutaron:

.. code-block:: console

  php spark migrar: estado

  ...

  +----------------------+-------------------+-----------------------+---------+---------------------+-------+
  | Namespace            | Version           | Filename              | Group   | Migrated On         | Batch |
  +----------------------+-------------------+-----------------------+---------+---------------------+-------+
  | App                  | 2022-04-06-234508 | CreateCiSessionsTable | default | 2022-04-06 18:45:14 | 2     |
  | CodeIgniter\Settings | 2021-07-04-041948 | CreateSettingsTable   | default | 2022-04-06 01:23:08 | 1     |
  | CodeIgniter\Settings | 2021-11-14-143905 | AddContextColumn      | default | 2022-04-06 01:23:08 | 1     |
  +----------------------+-------------------+-----------------------+---------+---------------------+-------+

Puede utilizar (estado) con las siguientes opciones:

- ``-g`` - para especificar el grupo de base de datos. Si se especifica, solo se verificarán las migraciones para el grupo de bases de datos especificado. Si no se especifica, se verificarán todas las migraciones.

hacer:migración
===============

Crea un archivo de migración esqueleto en **app/Database/Migrations**.
Automáticamente antepone la marca de tiempo actual. La clase lo nombra
create es la versión en caso Pascal del nombre del archivo.

.. code-block:: console

  php spark hacer:migración<class> [opciones]

Puede utilizar (``make:migration``) con las siguientes opciones:

- ``--namespace`` - Establece el espacio de nombres raíz. Valor predeterminado: ``APP_NAMESPACE``.
- ``--suffix``: agrega el título del componente al nombre de la clase.

Las siguientes opciones también están disponibles para generar el archivo de migración para
sesiones de base de datos:

- ``--session`` - Genera el archivo de migración para las sesiones de la base de datos.
- ``--table``: nombre de la tabla que se utilizará en las sesiones de la base de datos. Predeterminado: ``HIGGS_sessions``.
- ``--dbgroup`` - Grupo de base de datos que se utilizará para las sesiones de base de datos. Predeterminado: ``predeterminado``.


Preferencias de migración
*************************

La siguiente es una tabla de todas las opciones de configuración para migraciones, disponible en **app/Config/Migrations.php**.

==================== =============== ============= ======================================================================
Preferencia          Predeterminado  Opciones      Descripción
==================== =============== ============= ======================================================================
**enabled**          true            true / false  Habilitar o deshabilitar las migraciones.
**table**            migrations      None          El nombre de la tabla para almacenar el número de versión del esquema.
                                                   Esta tabla siempre se crea en el grupo de base de datos predeterminado
                                                   (``$defaultGroup``).
**timestampFormat**  Y-m-d-His\_                   El formato a usar para las marcas de tiempo al crear una migración.
==================== =============== ============= ======================================================================



Referencia de clase
*******************

.. php:namespace:: Higgs\Database

.. php:class:: MigrationRunner

    .. php:method:: findMigrations()

        :returns: una serie de archivos de migración
        :rtype: matriz

        Se devuelve una serie de nombres de archivos de migración que se encuentran en la propiedad ``path``.

    .. php:method:: latest($group)

        :param mixed $grupo: nombre del grupo de base de datos, si es nulo se utilizará el grupo de base de datos predeterminado.
        :returns: ``true`` en caso de éxito, ``false`` en caso de error
        :rtype: booleano

        Esto localiza las migraciones para un espacio de nombres (o todos los espacios de nombres), determina qué migraciones
        aún no se han ejecutado y los ejecuta en orden de versión (espacios de nombres entremezclados).

    .. php:method:: regress($targetBatch, $group)

        :param int $targetBatch: lote anterior al que migrar; 1+ especifica el lote, 0 revierte todo, negativo se refiere al lote relativo (por ejemplo, -3 significa "tres lotes atrás")
        :param ?string $group: nombre del grupo de base de datos, si es nulo se utilizará el grupo de base de datos predeterminado.
        :returns: ``true`` en caso de éxito, ``false`` en caso de error o si no se encuentran migraciones
        :rtype: booleano

        La regresión se puede utilizar para revertir los cambios a un estado anterior, lote por lote.

        .. literalinclude:: migration/006.php

    .. php:method:: force($path, $namespace, $group)

        :param Mixed $path: ruta a un archivo de migración válido.
        :param mixed $namespace: espacio de nombres de la migración proporcionada.
        :param mixed $grupo: nombre del grupo de base de datos, si es nulo se utilizará el grupo de base de datos predeterminado.
        :returns: ``true`` en caso de éxito, ``false`` en caso de error
        :rtype: booleano

        Esto obliga a migrar un único archivo independientemente del orden o los lotes. El método ``up()`` o ``down()`` se detecta en función de si ya se ha migrado.

        .. note:: This method is recommended only for testing and could cause data consistency issues.

    .. php:method:: setNamespace($namespace)

        :param  string|null $namespace: espacio de nombres de la aplicación. ``null`` son todos espacios de nombres.
        :returns: La instancia actual de MigrationRunner
        :rtype: Higgs\\Base de datos\\MigrationRunner

        Establece el espacio de nombres que la biblioteca debe buscar en los archivos de migración:

        .. literalinclude:: migration/007.php

        .. note:: If you set ``null``, it looks for migration files in all namespaces.

    .. php:method:: setGroup($group)

        :param  string $grupo: nombre del grupo de base de datos.
        :returns: La instancia actual de MigrationRunner
        :rtype: Higgs\\Base de datos\\MigrationRunner

        Establece el grupo en el que la biblioteca debe buscar archivos de migración:

        .. literalinclude:: migration/008.php
