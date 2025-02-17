**************************
Ampliación del controlador
**************************

El controlador central de Higgs no debe cambiarse, pero se le proporciona una extensión de clase predeterminada en
**aplicación/Controladores/BaseController.php**. Cualquier controlador nuevo que cree debe extender ``BaseController`` para tomar
ventaja de los componentes precargados y cualquier funcionalidad adicional que proporcione:

.. literalinclude:: basecontroller/001.php

.. contents::
    :local:
    :depth: 2

Componentes de precarga
=======================

El controlador base es un excelente lugar para cargar cualquier ayuda, modelo, biblioteca, servicio, etc. que desee
utilícelo cada vez que se ejecute su proyecto. Los ayudantes deben agregarse a la matriz ``$helpers`` predefinida. Por ejemplo, si
desea que los ayudantes de HTML y Texto estén disponibles universalmente:

.. literalinclude:: basecontroller/002.php

Cualquier otro componente a cargar o datos a procesar deben agregarse al constructor ``initController()``. Para
Por ejemplo, si su proyecto utiliza mucho la biblioteca de sesiones, es posible que desee iniciarlo aquí:

.. literalinclude:: basecontroller/003.php

Métodos adicionales
===================

El controlador base no es enrutable. Como seguridad añadida
medir **todos** los métodos nuevos que cree deben declararse como "protegidos" o "privados" y solo se puede acceder a ellos a través del
controladores que cree y que extiendan ``BaseController``.

Otras opciones
==============

Es posible que necesite más de un controlador base. Puede crear nuevos controladores base siempre que otros controladores que cree extiendan la base correcta. Por ejemplo, si su proyecto
tiene una interfaz pública involucrada y un portal administrativo simple, es posible que desee extender ``BaseController`` a
los controladores públicos y cree ``AdminController`` para cualquier controlador administrativo.

Si no desea utilizar el controlador base, puede omitirlo haciendo que sus controladores extiendan el sistema.
Controlador en su lugar:

.. literalinclude:: basecontroller/004.php
