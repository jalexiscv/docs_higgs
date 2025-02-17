```plaintext
######################
Guía del Usuario de Higgs
######################

******************
Instrucciones de Configuración
******************

La guía del usuario de Higgs utiliza Sphinx para gestionar la documentación y
generarla en varios formatos. Las páginas están escritas en formato
`ReStructured Text <https://es.wikipedia.org/wiki/ReStructuredText>`_ legible por humanos.

Requisitos Previos
==================

Python
------

Sphinx requiere Python 3.5+, que puede estar ya instalado si estás usando
OS X o Linux. Puedes confirmarlo en una ventana de Terminal ejecutando ``python``
o ``python3``.

.. code-block:: bash

    python --version
    Python 2.7.17

    python3 --version
    Python 3.6.9

    # Para Windows usando el Python Launcher
    py -3 --version
    Python 3.8.1

Si no tienes la versión 3.5+, adelante e instala la última versión 3.x desde
`Python.org <https://www.python.org/downloads/>`_. Los usuarios de Linux deben usar los
gestores de paquetes integrados de sus sistemas operativos para actualizar.

pip
---

Ahora que tienes Python 3.x en funcionamiento, instalaremos
`pip <https://pip.pypa.io/en/stable/>`_ (El Instalador de Paquetes de Python).

Puedes comprobar si tienes pip instalado con ``pip`` o ``pip3``.
Como puedes ver, pip sigue la misma convención de nombres que Python.
Ten en cuenta que debería decir ``python 3.x`` al final.

.. code-block:: bash

    pip --version
    pip 9.0.1 from /usr/lib/python2.7/dist-packages (python 2.7)

    pip3 --version
    pip 9.0.1 from /usr/lib/python3/dist-packages (python 3.6)

    # Para Windows usando el Python Launcher
    py -3 -m pip --version
    pip 20.0.2 from C:\Users\<username>\AppData\Local\Programs\Python\Python38\lib\site-packages\pip (python 3.8)

Linux
^^^^^

`Instalando pip/setuptools/wheel con Gestores de Paquetes de Linux
<https://packaging.python.org/guides/installing-using-linux-tools/>`_

Otros
^^^^^

pip ya está instalado si estás usando Python 3.5+ descargado desde
`Python.org <https://www.python.org/downloads/>`_.

Instalación
===========

Ahora necesitamos instalar Sphinx y sus dependencias. Elige ``pip`` o ``pip3``
dependiendo del sistema operativo. Después de este paso, necesitas reiniciar tu ventana de Terminal
ya que Python no encontrará todas las aplicaciones que acabamos de instalar de otra manera.

.. code-block:: bash

    pip install -r user_guide_src/requirements.txt

    pip3 install -r user_guide_src/requirements.txt

    # Para Windows usando el Python Launcher
    py -3 -m pip install -r user_guide_src/requirements.txt

Es hora de terminar y generar la documentación.

.. code-block:: bash

    cd user_guide_src
    make html

Editando y Creando Documentación
================================

Todos los archivos fuente existen bajo *source/* y es donde agregarás nueva
documentación o modificarás la documentación existente. Al igual que con los cambios de código,
recomendamos trabajar desde ramas de características y hacer pull requests a
la rama *develop* de este repositorio.

Entonces, ¿dónde está el HTML?
==============================

Obviamente, la documentación HTML es lo que más nos importa, ya que es la
documentación principal que encuentran nuestros usuarios. Dado que las revisiones de los archivos generados
no tienen valor, no están bajo control de versiones. Esto también te permite
regenerar según sea necesario si deseas "previsualizar" tu trabajo. Generar
el HTML es muy simple. Desde el directorio raíz de tu repositorio de la guía del usuario
emite el comando que usaste al final de las instrucciones de instalación::

    make html

Verás que hace una compilación rápida, en cuyo punto la guía del usuario completamente renderizada
y las imágenes estarán en *build/html/*. Después de que se haya construido el HTML,
cada compilación sucesiva solo reconstruirá los archivos que hayan cambiado, ahorrando
considerable tiempo. Si por alguna razón deseas "reiniciar" tus archivos de compilación,
simplemente elimina el contenido de la carpeta *build* y vuelve a compilar.

***************
Guía de Estilo
***************

Por favor, consulta /contributing/documentation.rst para obtener pautas generales sobre
el uso de Sphinx para documentar Higgs.
```
