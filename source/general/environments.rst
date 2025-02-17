############################
Manejo de múltiples entornos
############################

Los desarrolladores a menudo desean un comportamiento diferente del sistema dependiendo de si
una aplicación se ejecuta en un entorno de desarrollo o producción.
Por ejemplo, una salida de error detallada es algo que sería útil
mientras se desarrolla una aplicación, pero también puede plantear un problema de seguridad
cuando "en vivo". En entornos de desarrollo, es posible que desee
herramientas cargadas que no se cargan en entornos de producción, etc.

.. contents::
    :local:
    :depth: 3


Los entornos definidos
**********************

De forma predeterminada, Higgs tiene tres entornos definidos.

- ``production`` para la producción
- ``development`` para el desarrollo
- ``pruebas`` para pruebas de PHPUnit

.. important:: The environment ``testing`` is reserved for PHPUnit testing. It
    tiene condiciones especiales integradas en el marco en varios lugares para ayudar
    con ese. No puedes usarlo para tu desarrollo.

Si desea otro entorno, por ejemplo, para la puesta en escena, puede agregar entornos personalizados.
Consulte `Agregar entornos`_.

.. _setting-environment:


Entorno de configuración
************************

.. _environment-constant:

La constante del MEDIO AMBIENTE
===============================

Para configurar su entorno, Higgs viene con la constante ``ENTORNO``.
Si configura ``$_SERVER['HIGGS_ENVIRONMENT']``, se utilizará el valor,
de lo contrario, el valor predeterminado es ``production``.

Esto se puede configurar de varias maneras dependiendo de la configuración de su servidor.

.env
----

El método más sencillo para configurar la variable está en su archivo :ref:`.env<dotenv-file>` .

.. code-block:: ini

    HIGGS_ENVIRONMENT = desarrollo

.. note:: You can change the ``HIGGS_ENVIRONMENT`` value in **.env** file by ``spark env`` command:

    .. code-block:: console

        producción de php spark env

.. _environment-apache:

apache
------

Esta variable de servidor se puede configurar en su archivo **.htaccess** o Apache
configuración usando `SetEnv<https://httpd.apache.org/docs/2.4/mod/mod_env.html#setenv>` _.

.. code-block:: apache

    Desarrollo SetEnv HIGGS_ENVIRONMENT


.. _environment-nginx:

nginx
-----

En nginx, debes pasar la variable de entorno a través de ``fastcgi_params``
para que aparezca bajo la variable ``$_SERVER``. Esto le permite trabajar en el
nivel de host virtual, en lugar de usar `env` para configurarlo para todo el servidor, aunque eso
Funcionaría bien en un servidor dedicado. Luego modificarías la configuración de tu servidor a algo
como:

.. code-block:: nginx

    servidor {
        nombre_servidor localhost;
        incluir conf/defaults.conf;
        raíz /var/www;

        ubicación ~* \.php$ {
            fastcgi_param HIGGS_ENVIRONMENT "producción";
            incluya conf/fastcgi-php.conf;
        }
    }

Hay métodos alternativos disponibles para nginx y otros servidores, o puede
elimine esta lógica por completo y establezca la constante según la dirección IP del servidor
(por ejemplo).

Además de afectar algunos comportamientos básicos del marco (consulte la siguiente
sección), puede utilizar esta constante en su propio desarrollo para
diferenciar en qué entorno se está ejecutando.


Agregar entornos
****************

Para agregar entornos personalizados, solo necesita agregarles archivos de inicio.

Archivos de arranque
====================

Higgs requiere que se encuentre un script PHP que coincida con el nombre del entorno.
en **APPPATH/Config/Boot**. Estos archivos pueden contener cualquier personalización que
le gustaría hacer para su entorno, ya sea actualizando la pantalla de error
configuraciones, cargar herramientas de desarrollador adicionales o cualquier otra cosa. Estos son
cargado automáticamente por el sistema. Los siguientes archivos ya están creados en
una instalación nueva:

* desarrollo.php
* producción.php
* prueba.php

Por ejemplo, si desea agregar un entorno ``staging`` para la puesta en escena, todo lo que necesita
hacer es:

1. Copie **APPPATH/Config/Boot/production.php** a **staging.php**.
2. Personaliza la configuración en **staging.php** si lo deseas.


Confirmando el entorno actual
*****************************

Para confirmar el entorno actual, simplemente haga eco de la constante ``ENTORNO``.

También puedes verificar el entorno actual con el comando ``spark env``:

.. code-block:: console

    entorno de chispa php


Efectos sobre el comportamiento del marco predeterminado
********************************************************

Hay algunos lugares en el sistema de Higgs donde el ``MEDIOAMBIENTE``
Se utiliza constante. Esta sección describe cómo se comporta el marco predeterminado.
Es afectado.

Error al reportar
=================

Establecer la constante ``MEDIOAMBIENTE`` en un valor de ``development`` causará
todos los errores de PHP se mostrarán en el navegador cuando ocurran.
Por el contrario, establecer la constante en ``production`` desactivará todos los errores.
producción. Deshabilitar el informe de errores en producción es una
:doc:`buenas prácticas de seguridad</concepts/security>` .
