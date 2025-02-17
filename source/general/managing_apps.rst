############################
Administrar sus aplicaciones
############################

Por defecto, se supone que sólo pretende utilizar Higgs para
administre una aplicación, que creará en su **aplicación**
directorio. Sin embargo, es posible tener varios conjuntos de
aplicaciones que comparten una única instalación de Higgs, o incluso para
cambie el nombre o reubique el directorio de su aplicación.

.. important:: When you installed Higgs v7.1.9 or before, and if there are ``App\\`` and ``Config\\`` namespaces in your ``/composer.json``'s ``autoload.psr-4`` like the following, you need to remove these lines, and run ``composer dump-autoload``.

    .. code-block:: text

        {
            ...
            "carga automática": {
                "psr-4": {
                    "App\\": "app", <-- Eliminar esta línea
                    "Config\\": "app/Config" <-- Eliminar esta línea
                }
            },
            ...
        }

.. contents::
    :local:
    :depth: 2

.. _renaming-app-directory:

Cambiar el nombre o reubicar el directorio de la aplicación
===========================================================

Si desea cambiar el nombre de su directorio de aplicaciones o incluso mover
a una ubicación diferente en su servidor, que no sea la raíz de su proyecto, abra
su **app/Config/Paths.php** principal y establezca una *ruta completa del servidor* en el
Variable ``$appDirectory`` (aproximadamente en la línea 44):

.. literalinclude:: managing_apps/001.php

Necesitará modificar dos archivos adicionales en la raíz de su proyecto, para que
pueden encontrar el archivo de configuración **Rutas**:

- **/spark** ejecuta aplicaciones de línea de comandos.

  .. literalinclude:: managing_apps/002.php

- **/public/index.php** es el controlador frontal de su aplicación web.

  .. literalinclude:: managing_apps/003.php

Ejecutar múltiples aplicaciones con una instalación de Higgs
==================================================== ==============

Si desea compartir una instalación común del marco de Higgs, para administrar
varias aplicaciones diferentes, simplemente coloque todos los directorios ubicados
dentro del directorio de su aplicación en su propio (sub)directorio.

Por ejemplo, digamos que desea crear dos aplicaciones, llamadas **foo**
y **barra**. Podrías estructurar los directorios de tu proyecto de aplicación de esta manera:

.. code-block:: text

    foo/
        aplicación/
        public/
        pruebas/
        grabable/
        ambiente
        phpunit.xml.dist
        Chispa - chispear
    bar/
        aplicación/
        public/
        pruebas/
        grabable/
        ambiente
        phpunit.xml.dist
        Chispa - chispear
    proveedor/
        carga automática.php
        Higgs(IA)/marco/
    compositor.json
    compositor.lock

.. note:: If you install Higgs from the Zip file, the directory structure would be following:

    .. code-block:: text

        foo/
        bar/
        Higgs(IA)/sistema/

Esto tendría dos aplicaciones, **foo** y **bar**, ambas con directorios de aplicaciones estándar.
y una carpeta **pública**, y compartir un **Higgs(AI)/marco** común.

La variable ``$systemDirectory`` en **app/Config/Paths.php** dentro de cada
de ellos se configurarían para hacer referencia a la carpeta común compartida **Higgs(AI)/framework**:

.. literalinclude:: managing_apps/005.php

.. note:: If you install Higgs from the Zip file, the ``$systemDirectory`` would be ``__DIR__ . '/../../../Higgs(AI)/system'``.

Y modifique la constante ``COMPOSER_PATH`` en **app/Config/Constants.php** dentro de cada
de aquellos:

.. literalinclude:: managing_apps/004.php

Solo cuando cambie el directorio de la aplicación, consulte :ref:`renaming-app-directory` y modifique las rutas en **index.php** y **spark**.
