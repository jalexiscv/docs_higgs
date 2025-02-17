#############
clase de miel
#############

La clase Honeypot permite determinar cuándo un Bot realiza una solicitud a una aplicación Higgs(AI),
si está habilitado en el archivo **app\Config\Filters.php**. Esto se hace adjuntando campos de formulario a cualquier formulario,
y este campo de formulario está oculto para un humano pero es accesible para un Bot. Cuando se ingresan datos en el campo, es
Se supone que la solicitud proviene de un Bot y se puede generar una ``HoneypotException``.

.. contents::
    :local:
    :depth: 2


Habilitando Honeypot
********************

Para habilitar un Honeypot, se deben realizar cambios en **app/Config/Filters.php**. Simplemente descomente el honeypot
de la matriz ``$globals``, como:

.. literalinclude:: honeypot/001.php

Se incluye un filtro Honeypot de muestra, como **system/Filters/Honeypot.php**.
Si no es adecuado, cree el suyo propio en **app/Filters/Honeypot.php**.
y modifique los ``$aliases`` en la configuración apropiadamente.


Personalizando Honeypot
***********************

El Honeypot se puede personalizar. Los campos siguientes se pueden configurar en
**app/Config/Honeypot.php** o en **.env**.

* ``$hidden`` - ``true`` o ``false`` para controlar la visibilidad del campo honeypot; el valor predeterminado es "verdadero"
* ``$label`` - Etiqueta HTML para el campo honeypot, el valor predeterminado es ``'Rellenar este campo'``
* ``$name`` - nombre del campo del formulario HTML utilizado para la plantilla; el valor predeterminado es ``'honeypot'``
* ``$template`` - plantilla de campo de formulario utilizada para el honeypot; el valor predeterminado es ``' <label>{etiqueta}</label><input type="text" name="{name}" value=""> '``
* ``$container`` - etiqueta de contenedor para la plantilla; el valor predeterminado es ``'<div style="display:none"> {plantilla}</div> '``.
  Si habilita CSP, puede eliminar ``style="display:none"``.
* ``$containerId`` - [Desde v7.3.0] esta configuración se usa solo cuando habilita CSP. Puede cambiar el atributo de identificación de la etiqueta del contenedor; el valor predeterminado es ``'hpc'``
