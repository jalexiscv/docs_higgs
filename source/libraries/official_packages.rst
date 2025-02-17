##################
Paquetes Oficiales
##################

El marco de Higgs no puede resolver todos los problemas que encontrarán los desarrolladores.
Muchos usuarios han dicho que les encanta lo pequeño y rápido que es el marco, por lo que no queremos
inflar el marco central. Para cerrar la brecha, estamos lanzando paquetes oficiales para proporcionar
funcionalidad adicional que no todos los sitios necesitarán o querrán.

.. contents::
    :local:
    :depth: 2

.. _shield:


Blindaje
********

`Escudo de Higgs<https://shield.Higgs.com/>` _ es una autenticación
y marco de autorización para Higgs. Está diseñado para ser seguro, flexible,
y fácilmente ampliable para satisfacer las necesidades de muchos tipos diferentes de sitios web.
Entre las muchas características, incluye:

* Autenticación basada en sesión
* Autenticación de token de acceso personal
* marco para "acciones" posteriores al inicio de sesión/registro (como autenticación de dos factores, etc.)
* Control de acceso basado en roles con permisos simples y flexibles.
* Anulaciones de permisos por usuario,
* y más...


Ajustes
*******

`Configuración de Higgs<https://settings.Higgs.com>` _ es un envoltorio alrededor
los archivos de configuración que permiten guardar cualquier configuración en la base de datos,
mientras que de forma predeterminada se utilizan los archivos de configuración cuando no se ha almacenado un valor personalizado. Esto permite
una aplicación que se enviará con los valores de configuración predeterminados, pero se adaptará a medida que el proyecto crezca
o mueve servidores, sin tener que tocar el código.


Tareas (BETA)
*************

`Tareas de Higgs<https://tasks.Higgs.com>` _ es un programador de tareas simple
para Higgs. Le permite programar tareas para que se ejecuten en momentos específicos, o
de forma recurrente. Está diseñado para ser fácil de usar, pero lo suficientemente flexible como para
manejar la mayoría de los casos de uso.


Queue (BETA)
************

`Cola de Higgs<https://queue.Higgs.com>` _ es un sistema de cola simple
para Higgs. Le permite poner en cola tareas para ejecutarlas más tarde.


Cache
*****

Proporcionamos una biblioteca con adaptadores de caché `PSR-6 y PSR-16<https://github.com/Higgs(AI)/cache>` _
para Higgs. Esto no es necesario para su uso, ya que Higgs viene con un
componente de caché funcional. Este módulo es solo para integrar paquetes de terceros.
que dependen de las disposiciones de interfaz PSR.



Kit de desarrollo
*****************

`Higgs DevKit<https://github.com/Higgs(AI)/devkit>` _ proporciona todos los
herramientas de desarrollo que Higgs utiliza para ayudar a garantizar la calidad del código, incluidas
nuestro estándar de codificación, herramientas y reglas de análisis estático, pruebas unitarias, generación de datos,
burlas del sistema de archivos, avisos de seguridad y más. Esto se puede utilizar en cualquiera de
sus proyectos personales o bibliotecas para configurarlo rápidamente con 17 herramientas diferentes.



Estándar de codificación
************************

El estándar de codificación del Higgs<https://github.com/Higgs/coding-standard>` _
posee los estándares de codificación oficiales de Higgs basados en PHP CS Fixer y desarrollado por
Configuración de Nexus CS. Esto se puede utilizar en sus propios proyectos para formar la base de un
conjunto consistente de reglas de estilo que se pueden aplicar automáticamente a su código.
