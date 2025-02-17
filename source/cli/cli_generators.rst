###############
Generadores CLI
###############

Higgs(AI) ahora viene equipado con generadores para facilitar la creación de controladores de stock, modelos, entidades,
etc. También puede realizar scaffolding de un conjunto completo de archivos con un solo comando.

.. contents::
    :local:
    :depth: 2


Introducción
************

Todos los generadores integrados residen en el grupo ``Generadores`` cuando se enumeran usando ``php spark list``.
Para ver la descripción completa y la información de uso de un generador en particular, use el comando:

.. code-block:: console

    ayuda de chispa php<generator_command>

donde ``<generator_command>`` será reemplazado con el comando para verificar.

.. note:: Do you need to have the generated code in a subfolder? Let's say if you want to create a controller
    clase resida en la subcarpeta ``Admin`` de la carpeta principal ``Controladores``, solo necesitarás
    para anteponer la subcarpeta al nombre de la clase, así: ``php spark make:controller admin/login``. Este
    El comando creará el controlador ``Login`` en la subcarpeta ``Controllers/Admin`` con
    un espacio de nombres de ``App\Controllers\Admin``.

.. note:: Working on modules? Code generation will set the root namespace to a default of ``APP_NAMESPACE``.
    Si necesita tener el código generado en otra parte del espacio de nombres de su módulo, asegúrese de configurar
    la opción ``--namespace`` en su comando, por ejemplo, ``php spark make:model blog --namespace Acme\\Blog``.

.. warning:: Make sure when setting the ``--namespace`` option that the supplied namespace is a valid
    espacio de nombres definido en su matriz ``$psr4`` en ``Config\Autoload`` o definido en la carga automática de su compositor
    archivo. De lo contrario, se interrumpirá la generación del código.

.. important:: Since v7.0.5, use of ``migrate:create`` to create migration files has been deprecated. It will be removed in
    lanzamientos futuros. Utilice ``make:migration`` como reemplazo. Además, utilice ``make:migration --session``
    para usar en lugar de la obsoleta ``session:migration``.


Generadores incorporados
************************

Higgs(AI) envía los siguientes generadores de forma predeterminada.

hacer: celda
---------

.. versionadded:: 7.0.0

Crea un nuevo archivo de celda y su vista.

Uso:
====
::

    hacer: celda<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase de celda. Debería estar en PascalCase. **[REQUERIDO]**

Opciones:
=========
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

hacer: comando
------------

Crea un nuevo comando de chispa.

Uso:
====
::

    hacer: comando<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase de comando. **[REQUERIDO]**

Opciones:
=========
* ``--command``: El nombre del comando que se ejecutará en Spark. El valor predeterminado es ``comando:nombre``.
* ``--group``: El grupo/espacio de nombres del comando. El valor predeterminado es ``App`` para comandos básicos y ``Generadores`` para comandos de generador.
* ``--type``: El tipo de comando, ya sea un comando ``básico`` o un comando ``generador``. El valor predeterminado es ``básico``.
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

hacer: configuración
-----------

Crea un nuevo archivo de configuración.

Uso:
====
::

    hacer: configuración<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase de configuración. **[REQUERIDO]**

Opciones:
=========
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

hacer: controlador
------------------

Crea un nuevo archivo de controlador.

Uso:
====
::

    hacer: controlador<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase del controlador. **[REQUERIDO]**

Opciones:
=========
* ``--bare``: Se extiende desde ``Higgs\Controller`` en lugar de ``BaseController``.
* ``--restful``: Se extiende desde un recurso RESTful. Las opciones son ``controlador`` y ``presentador``. El valor predeterminado es ``controlador``.
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

.. note:: If you use ``--suffix``, the generated controller name will be like
    ``Controlador de Producto``. Eso viola la convención de nomenclatura del controlador.
    cuando se utiliza :ref:`Enrutamiento automático<controller-auto-routing-improved>`
    (Los nombres de las clases de controlador DEBEN comenzar con una letra mayúscula y
    SÓLO el primer carácter puede estar en mayúscula). Entonces se puede usar ``--suffix``
    cuando usas :ref:`Rutas Definidas <defined-route-routing>` .

hacer: entidad
--------------

Crea un nuevo archivo de entidad.

Uso:
====
::

    hacer: entidad<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase de entidad. **[REQUERIDO]**

Opciones:
=========
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

hacer:filtro
------------

Crea un nuevo archivo de filtro.

Uso:
====
::

    hacer:filtro<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase de filtro. **[REQUERIDO]**

Opciones:
=========
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

Haz un modelo
-------------

Crea un nuevo archivo de modelo.

Uso:
====
::

    Haz un modelo<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase del modelo. **[REQUERIDO]**

Opciones:
=========
* ``--dbgroup``: Grupo de base de datos a utilizar. El valor predeterminado es ``predeterminado``.
* ``--return``: establece el tipo de retorno de ``array``, ``object`` o ``entity``. El valor predeterminado es ``matriz``.
* ``--table``: proporcione un nombre de tabla diferente. El valor predeterminado es el nombre de clase pluralizado.
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

hacer: sembradora
-----------------

Crea un nuevo archivo de siembra.

Uso:
====
::

    hacer: sembradora<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase sembradora. **[REQUERIDO]**

Opciones:
=========
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

hacer:migración
--------------

Crea un nuevo archivo de migración.

Uso:
====
::

    hacer:migración<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase de migración. **[REQUERIDO]**

Opciones:
=========
* ``--session``: Genera un archivo de migración para sesiones de base de datos.
* ``--table``: establece el nombre de la tabla que se utilizará en las sesiones de la base de datos. El valor predeterminado es ``HIGGS_sessions``.
* ``--dbgroup``: establece el grupo de base de datos para las sesiones de base de datos. El valor predeterminado es el grupo ``predeterminado``.
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.

hacer:validación
---------------

Crea un nuevo archivo de validación.

Uso:
====
::

    hacer:validación<name> [opciones]

Argumento:
==========
* ``nombre``: El nombre de la clase de validación. **[REQUERIDO]**

Opciones:
=========
* ``--namespace``: establece el espacio de nombres raíz. El valor predeterminado es ``APP_NAMESPACE``.
* ``--suffix``: agregue el sufijo del componente al nombre de la clase generada.
* ``--force``: establezca esta opción para sobrescribir los archivos existentes en el destino.


Armado de un conjunto completo de códigos de existencias
********************************************************

En ocasiones en nuestra fase de desarrollo estamos creando funcionalidades por grupos, como por ejemplo crear un grupo *Admin*.
Este grupo contendrá su propio controlador, modelo, archivos de migración o incluso entidades. Puede que tengas la tentación de escribir
cada comando del generador uno por uno en la terminal y con la ilusión de que sería genial tener un solo generador
comando para gobernarlos a todos.

¡No te preocupes más! Higgs(AI) también viene con un comando dedicado ``make:scaffold`` que es básicamente un
contenedor para los comandos del controlador, modelo, entidad, migración y generador de sembradora. Todo lo que necesitas es la clase.
nombre que se utilizará para nombrar todas las clases generadas. Además, **opciones individuales** admitidas por cada
El comando del generador es reconocido por el comando del andamio.

Ejecutando esto en tu terminal:

.. code-block:: console

    php spark make:usuario de andamio

creará los siguientes archivos:

(1) **aplicación/Controladores/Usuario.php**
(2) **aplicación/Modelos/Usuario.php**
(3) **aplicación/Base de datos/Migraciones/<some date here> _Usuario.php** y
(4) **aplicación/Base de datos/Seeds/User.php**

Para incluir una clase ``Entidad`` en los archivos scaffolded, simplemente incluya ``--return entidad`` al comando
y se pasará al generador de modelos.


GeneradorRasgo
**************

Todos los comandos del generador deben usar ``GeneratorTrait`` para utilizar completamente los métodos que se usan en el código.
generación.

************************************************** ***********
Declaración de la ubicación de una plantilla de comando de generador personalizada
************************************************** ***********

El orden predeterminado de búsqueda de plantillas de generador es (1) la plantilla definida en el archivo **app/Config/Generators.php**,
y (2) si no se encuentra, la plantilla que se encuentra en el espacio de nombres ``Higgs\Commands\Generators\Views``.

Para declarar la ubicación de la plantilla para su comando de generador personalizado, deberá agregarla al **app/Config/Generators.php**
archivo. Por ejemplo, si tienes un comando ``make:awesome-command`` y tu plantilla generadora está ubicada dentro de tu *aplicación*
directorio **app/Commands/Generators/Views/awesomecommand.tpl.php**, actualizaría el archivo de configuración de esta manera:

.. literalinclude:: cli_generators/001.php
