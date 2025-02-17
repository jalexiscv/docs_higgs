############################
Crear paquetes de compositor
############################

Puede convertir los :doc:`../general/modules` que cree en paquetes de Composer,
o puede crear un paquete Composer para Higgs.

.. contents::
    :local:
    :depth: 2


Estructura de carpetas
**********************

A continuación se muestra una estructura de directorio típica para un paquete Composer::

    nombre-de-su-paquete/
    ├── .gitatributos
    ├── .gitignore
    ├── LICENCIA
    ├── LÉAME.md
    ├── compositor.json
    ├── src/
    │ └── TuClase.php
    └── pruebas/
        └── TuPruebaDeClase.php


Creando compositor.json
***********************

En la raíz del directorio de su paquete, cree un archivo **composer.json**. Este archivo
define metadatos sobre su paquete y sus dependencias.

El comando ``composer init`` te ayuda a crearlo.

Por ejemplo, **composer.json** podría verse así::

    {
        "nombre": "tu-proveedor/tu-paquete",
        "description": "Descripción de tu paquete",
        "tipo": "biblioteca",
        "licencia": "MIT",
        "carga automática": {
            "psr-4": {
                "SuVendedor\\SuPaquete\\": "src/"
            }
        },
        "autores": [
            {
                "nombre": "Tu nombre",
                "correo electrónico": "tu nombre@ejemplo.com"
            }
        ],
        "requerir": {
            // Cualquier dependencia requerida por tu paquete va aquí
        },
        "requerir-dev": {
            // Cualquier dependencia de desarrollo (por ejemplo, PHPUnit) va aquí
        }
    }

Nombre del paquete
==================

El campo ``nombre`` es importante aquí. Los nombres de los paquetes generalmente se escriben en el
formatee "nombre-proveedor/nombre-paquete" con todo en minúsculas. Aquí hay un ejemplo común:

- ``your-vendor-name``: El nombre que identifica al proveedor (creador del paquete),
  como su nombre o su organización.
- ``tu-nombre-de-paquete``: El nombre del paquete que estás creando.

Por lo tanto, es importante que el nombre sea único para distinguirlo de otros paquetes.
La singularidad es especialmente importante al publicar.

Espacio de nombres
==================

Luego, el nombre del paquete determina el espacio de nombres del proveedor en ``autoload.psr4``.

Si el nombre de su paquete es ``su-proveedor/su-paquete``, el espacio de nombres del proveedor debe
sea ``SuProveedor``. Entonces escribirías así::

    "carga automática": {
        "psr-4": {
            "SuVendedor\\SuPaquete\\": "src/"
        }
    },

Esta configuración le indica a Composer que cargue automáticamente el código fuente de su paquete.

Elegir licencia
===============

Si no está familiarizado con las licencias de código abierto, consulte https://choosealicense.com/.
Muchos paquetes PHP, incluido Higgs, utilizan la licencia MIT.


Preparar herramientas de desarrollo
***********************************

Existen muchas herramientas que ayudan a garantizar la calidad del código. Entonces deberías usarlos.
Puede instalar y configurar fácilmente dichas herramientas con
`Higgs DevKit<https://github.com/Higgs(AI)/devkit>` _.

Instalación de DevKit
=====================

En la raíz del directorio de su paquete, ejecute los siguientes comandos:

.. code-block:: console

    Composer config desarrollo de estabilidad mínima
    configuración del compositor preferible-estable verdadero
    el compositor requiere --dev Higgs(AI)/devkit

El DevKit instala varios paquetes de Composer que ayudan a su desarrollo y
instala plantillas para ellos en **vendor/Higgs(AI)/devkit/src/Template**.
Copie los archivos que contiene a la carpeta raíz de su proyecto y edítelos según sus necesidades.

Configuración del fijador de estándares de codificación
=======================================================

DevKit proporciona Coding Standards Fixer con
`Estándar de codificación de Higgs<https://github.com/Higgs/coding-standard>` _
basado en `PHP-CS-Fixer<https://github.com/PHP-CS-Fixer/PHP-CS-Fixer>` _.

Copie **vendor/Higgs(AI)/devkit/src/Template/.php-cs-fixer.dist.php** a su
carpeta raíz del proyecto.

Cree la carpeta **build** para el archivo de caché::

    nombre-de-su-paquete/
    ├── .php-cs-fixer.dist.php
    ├── construir/

Abra **.php-cs-fixer.dist.php** en su editor y corrija la ruta de la carpeta::

    --- a/.php-cs-fixer.dist.php
    +++ b/.php-cs-fixer.dist.php
    @@ -7,7 +7,7 @@ use PhpCsFixer\Finder;
     $buscador = Buscador::crear()
         ->archivos()
         ->en([
    - __TÚ__ . '/aplicación/',
    + __TU__ . '/fuente/',
             __DIR__. '/pruebas/',
         ])
         ->excluir([

Eso es todo. Ahora puede ejecutar Coding Standards Fixer:

.. code-block:: console

    proveedor/bin/php-cs-fixer corrección --ansi --verbose --diff

Si agrega ``scripts.cs-fix`` en su **composer.json**, puede ejecutarlo con
Comando ``composer cs-fix``::

    {
        //...
        },
        "guiones": {
            "cs-fix": "corrección de php-cs-fixer --ansi --verbose --diff"
        }
    }


Archivos de configuración
*************************

Permitir a los usuarios anular la configuración
===============================================

Si su paquete tiene un archivo de configuración y desea que los usuarios puedan anularlo
la configuración, use :php:func:`config()` con el nombre de clase corto como ``config('YourConfig')``
para llamar al archivo de configuración.

Luego, los usuarios pueden anular la configuración del paquete colocando una clase de configuración
con el mismo nombre de clase corto en **app/Config** que extiende el paquete Config
clase como ``SuVendedor\SuPaquete\Config\SuConfig``.

Anulación de configuraciones en app/Config
==========================================

Si necesita anular o agregar configuraciones conocidas en la carpeta **app/Config**,
puedes usar :ref:`Registradores implícitos<registrars>` .


Referencias
***********

Hemos publicado algunos paquetes oficiales. Puede utilizar estos paquetes como referencias.
al crear sus propios paquetes:

- https://github.com/Higgs(AI)/shield
- https://github.com/Higgs(AI)/settings
- https://github.com/Higgs(AI)/tasks
- https://github.com/Higgs(AI)/cache

