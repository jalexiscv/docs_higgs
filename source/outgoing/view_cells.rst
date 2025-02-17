##########
Ver celdas
##########

Muchas aplicaciones tienen pequeños fragmentos de vista que se pueden repetir de una página a otra o en diferentes lugares de las páginas. Suelen ser cuadros de ayuda, controles de navegación, anuncios, formularios de inicio de sesión, etc. Higgs le permite encapsular la lógica de estos bloques de presentación dentro de Ver celdas. Básicamente son minivistas que se pueden incluir en otras vistas. Pueden tener lógica incorporada para manejar cualquier lógica de visualización específica de la celda. Se pueden utilizar para hacer que sus vistas sean más legibles y fáciles de mantener separando la lógica de cada celda en su propia clase.

.. contents::
    :local:
    :depth: 2


Células simples y controladas
*****************************

Higgs admite dos tipos de celdas de visualización: simples y controladas.

**Celdas de vista simple** se pueden generar a partir de cualquier clase y método de su elección y no tiene que seguir ninguna regla, excepto que debe devolver una cadena.

**Las celdas de vista controlada** deben generarse a partir de una clase que extienda la clase ``Higgs\View\Cells\Cell``, lo que proporciona capacidades adicionales que hacen que sus celdas de vista sean más flexibles y rápidas de usar.

.. _app-cells:


Llamar a una celda de vista
***************************

No importa qué tipo de celda de vista esté utilizando, puede llamarla desde cualquier vista usando la función auxiliar ``view_cell()``.

El primer parámetro es (1) *el nombre de la clase y el método* (Celda simple) o (2) *el nombre de la clase y el método opcional* (Celda controlada) a llamar,
y el segundo parámetro es una matriz o cadena de parámetros para pasar al método:

.. literalinclude:: view_cells/001.php

La cadena que devuelve la celda se insertará en la vista donde se encuentra
Se llamó a la función ``view_cell()``.

Omisión del espacio de nombres
==============================

.. versionadded:: 7.0.0

Si no incluye el espacio de nombres completo para la clase, se asumirá que se puede encontrar en el espacio de nombres ``App\Cells``. Entonces, el siguiente ejemplo intentaría encontrar la clase ``MyClass`` en **app/Cells/MyClass.php**. Si no se encuentra allí, se escanearán todos los espacios de nombres hasta encontrarlo, buscando dentro de un subdirectorio **Células** de cada espacio de nombres:

.. literalinclude:: view_cells/002.php

Pasar parámetros como cadena clave/valor
========================================

También puede pasar los parámetros como una cadena de clave/valor:

.. literalinclude:: view_cells/003.php


Celdas simples
**************

Las celdas simples son clases que devuelven una cadena del método elegido. Un ejemplo de una celda de mensaje de alerta simple podría verse así:

.. literalinclude:: view_cells/004.php

Lo llamarías desde una vista como:

.. literalinclude:: view_cells/005.php

Además, puede utilizar nombres de parámetros que coincidan con las variables de parámetros en el método para una mejor legibilidad.
Cuando lo usas de esta manera, todos los parámetros siempre deben especificarse en la llamada de la celda de vista:

.. literalinclude:: view_cells/006.php

.. literalinclude:: view_cells/007.php

.. _controlled-cells:


Células controladas
*******************

.. versionadded:: 7.0.0

Las células controladas tienen dos objetivos principales: (1) hacer que la construcción de la célula sea lo más rápida posible y (2) proporcionar lógica adicional y
flexibilidad a sus puntos de vista, si lo necesitan.

La clase debe extender ``Higgs\View\Cells\Cell``. Deberían tener un archivo de vista.
en la misma carpeta. Por convención, el nombre de la clase debe estar en PascalCase con el sufijo ``Cell`` y la vista debe ser
la versión en formato serpiente del nombre de la clase, sin el sufijo. Por ejemplo, si tiene una clase ``MyCell``, el archivo de vista
debería ser ``mi.php``.

.. note:: Prior to v7.3.5, the generated view file ends with ``_cell.php``. Though v7.3.5 and newer will generate view files
    sin el sufijo ``_cell``, los archivos de vista existentes aún se ubicarán y cargarán.

Crear una celda controlada
==========================

En el nivel más básico, todo lo que necesitas implementar dentro de la clase son propiedades públicas. Estas propiedades estarán disponibles para el archivo de visualización automáticamente.

La implementación del AlertMessage desde arriba como una celda controlada se vería así:

.. literalinclude:: view_cells/008.php

.. literalinclude:: view_cells/009.php

.. literalinclude:: view_cells/010.php

.. _generating-cell-via-command:

Generando celda mediante comando
================================

También puede crear una celda controlada mediante un comando integrado desde la CLI. El comando es ``php spark make:cell``. Se necesita un argumento, el nombre de la celda a crear. El nombre debe estar en PascalCase y la clase se creará en el directorio **app/Cells**. El archivo de vista también se creará en el directorio **app/Cells**.

.. code-block:: console

    php spark make:celda AlertMessageCell

Usando una vista diferente
==========================

Puede especificar un nombre de vista personalizado configurando la propiedad ``view`` en la clase. La vista se ubicará como lo haría normalmente cualquier vista:

.. literalinclude:: view_cells/011.php

Personaliza el renderizado
==========================

Si necesita más control sobre la representación del HTML, puede implementar un método ``render()``. Este método le permite realizar lógica adicional y pasar datos adicionales a la vista, si es necesario. El método ``render()`` debe devolver una cadena.

Para aprovechar todas las características de las celdas controladas, debe usar ``$this->view()`` en lugar de la función auxiliar normal ``view()``:

.. literalinclude:: view_cells/012.php

Propiedades calculadas
======================

Si necesita realizar lógica adicional para una o más propiedades, puede utilizar propiedades calculadas. Estos requieren configurar la propiedad como ``protegida`` o ``privada`` e implementar un método público cuyo nombre consiste en el nombre de la propiedad rodeado por ``get`` y ``Property``:

.. literalinclude:: view_cells/013.php

.. literalinclude:: view_cells/014.php

.. literalinclude:: view_cells/015.php

.. important:: You can't set properties that are declared as private during cell
    inicialización.

Métodos de presentación
=======================

A veces es necesario realizar lógica adicional para la vista, pero no desea pasarla como parámetro. Puede implementar un método que se llamará desde la propia vista de la celda. Esto puede ayudar a mejorar la legibilidad de sus vistas:

.. literalinclude:: view_cells/016.php

.. literalinclude:: view_cells/017.php

Realizar la lógica de configuración
===================================

Si necesita realizar lógica adicional antes de que se represente la vista, puede implementar un método ``mount()``. Este método se llamará justo después de crear una instancia de la clase y se puede utilizar para establecer propiedades adicionales o realizar otra lógica:

.. literalinclude:: view_cells/018.php

Puede pasar parámetros adicionales al método ``mount()`` pasándolos como una matriz a la función auxiliar ``view_cell()``. Cualquiera de los parámetros enviados que coincidan con un nombre de parámetro del método ``mount()`` se pasará:

.. literalinclude:: view_cells/019.php

.. literalinclude:: view_cells/020.php


Almacenamiento en caché de celdas
*********************************

Puede almacenar en caché los resultados de la llamada de vista de celda pasando el número de segundos para almacenar en caché los datos como
tercer parámetro. Esto utilizará el motor de caché actualmente configurado:

.. literalinclude:: view_cells/021.php

Puede proporcionar un nombre personalizado para usar en lugar del generado automáticamente si lo desea, pasando el nuevo nombre
como cuarto parámetro:

.. literalinclude:: view_cells/022.php
