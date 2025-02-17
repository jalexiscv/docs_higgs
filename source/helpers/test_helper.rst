##################
Ayudante de prueba
##################

El archivo Test Helper contiene funciones que ayudan a probar su proyecto.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: test_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: fake($model, array $overrides = null)

    :param Modelo|objeto|cadena $modelo: Instancia o nombre del modelo a usar con Fabricator
    :param array|null $overrides: Anulación de datos para pasar a Fabricator::setOverrides()
    :returns: Un artículo falso aleatorio creado y agregado a la base de datos por Fabricator
    :rtype: objeto|matriz

    Utiliza ``Higgs\Test\Fabricator`` para crear un elemento aleatorio y agregarlo a la base de datos.

    Ejemplo de uso:

    .. literalinclude:: test_helper/002.php
