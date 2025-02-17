#################################
Clase de manipulación de imágenes
#################################

La clase de manipulación de imágenes de Higgs le permite realizar lo siguiente
comportamiento:

- Cambio de tamaño de imagen
- Creación de miniaturas
- Recorte de imágenes
- Rotación de imagen
- Marca de agua de imagen

Se admiten las siguientes bibliotecas de imágenes: GD/GD2 e ImageMagick.

.. contents::
    :local:
    :depth: 2


Inicializando la clase
**********************

Como la mayoría de las otras clases en Higgs, la clase de imagen se inicializa
en su controlador llamando a la clase Servicios:

.. literalinclude:: images/001.php

Puede pasar el alias de la biblioteca de imágenes que desea utilizar al
Función de servicio:

.. literalinclude:: images/002.php

Los controladores disponibles son los siguientes:

- ``gd`` La biblioteca de imágenes GD/GD2
- ``imagick`` La biblioteca ImageMagick.

Si utiliza la biblioteca ImageMagick, debe establecer la ruta a la biblioteca en su
servidor en **app/Config/Images.php**.

.. note:: The ImageMagick handler requires the imagick extension.


Procesando una imagen
*********************

Independientemente del tipo de procesamiento que desee realizar
(cambiar el tamaño, recortar, rotar o marcar con marca de agua), el proceso general es
idéntico. Establecerás algunas preferencias correspondientes a la acción que deseas
pretende realizar, luego llame a una de las funciones de procesamiento disponibles.
Por ejemplo, para crear una miniatura de imagen, harás esto:

.. literalinclude:: images/003.php

El código anterior le dice a la biblioteca que busque una imagen.
llamado *mypic.jpg* ubicado en la carpeta source_image, luego cree un
nueva imagen que es de 100 x 100 píxeles usando la biblioteca de imágenes GD2,
y guárdelo en un archivo nuevo (el pulgar). Dado que está utilizando el método ``fit()``,
Intentará encontrar la mejor parte de la imagen para recortar según el
relación de aspecto deseada y luego recorte y cambie el tamaño del resultado.

Una imagen se puede procesar a través de tantos métodos disponibles como sea posible.
necesario antes de guardar. La imagen original no se modifica y se crea una nueva imagen.
se utiliza y se pasa a través de cada método, aplicando los resultados sobre el
resultados anteriores:

.. literalinclude:: images/004.php

Este ejemplo tomaría la misma imagen y primero solucionaría cualquier problema de orientación del teléfono móvil.
gire la imagen 90 grados y luego recorte el resultado en una imagen de 100x100 píxeles,
comenzando en la esquina superior izquierda. El resultado se guardará como miniatura.

.. note:: In order for the image class to be allowed to do any
    procesamiento, la carpeta que contiene los archivos de imagen debe tener escritura
    permisos.

.. note:: Image processing can require a considerable amount of server
    memoria para algunas operaciones. Si experimenta errores de falta de memoria
    mientras procesa imágenes, es posible que deba limitar su tamaño máximo y/o
    ajustar los límites de memoria de PHP.

Calidad de la imagen
====================

``save()`` puede tomar un parámetro adicional ``$calidad`` para alterar la imagen resultante
calidad. Los valores varían de 0 a 100, siendo 90 el valor predeterminado del marco. Este parámetro
solo se aplica a imágenes JPEG y WEBP; de lo contrario, se ignorará:

.. note:: The parameter ``$quality`` for WebP can be used since v7.4.0.

.. literalinclude:: images/005.php

.. note:: Higher quality will result in larger file sizes. See also https://www.php.net/manual/en/function.imagejpeg.php

Si solo estás interesado en cambiar la calidad de la imagen sin realizar ningún procesamiento.
Deberá incluir el recurso de imagen o terminará con una copia exacta:

.. literalinclude:: images/006.php


Métodos de procesamiento
************************

Hay siete métodos de procesamiento disponibles:

- ``$imagen->recortar()``
- ``$imagen->convertir()``
- ``$imagen->ajustar()``
- ``$imagen->aplanar()``
- ``$imagen->flip()``
- ``$imagen->redimensionar()``
- ``$imagen->rotar()``
- ``$imagen->texto()``

Estos métodos devuelven la instancia de clase para que puedan encadenarse, como se muestra arriba.
Si fallan, lanzarán una ``Higgs\Images\ImageException`` que contiene
el mensaje de error. Una buena práctica es detectar las excepciones, mostrando una
error tras falla, así:

.. literalinclude:: images/007.php

Recortar imágenes
=================

Las imágenes se pueden recortar para que solo quede una parte de la imagen original. Esto se utiliza a menudo al crear
imágenes en miniatura que deben coincidir con un determinado tamaño/relación de aspecto. Esto se maneja con el método ``crop()``::

    crop(int $ancho = nulo, int $alto = nulo, int $x = nulo, int $y = nulo, bool $maintainRatio = false, cadena $masterDim = 'auto')

- ``$width`` es el ancho deseado de la imagen resultante, en píxeles.
- ``$height`` es la altura deseada de la imagen resultante, en píxeles.
- ``$x`` es el número de píxeles del lado izquierdo de la imagen para comenzar a recortar.
- ``$y`` es el número de píxeles desde la parte superior de la imagen para comenzar a recortar.
- ``$maintainRatio``, si es verdadero, ajustará las dimensiones finales según sea necesario para mantener la relación de aspecto original de la imagen.
- ``$masterDim`` especifica qué dimensión debe dejarse intacta cuando ``$maintainRatio`` es verdadero. Los valores pueden ser: ``'ancho'``, ``'alto'`` o ``'auto'``.

Para sacar un cuadrado de 50x50 píxeles del centro de una imagen, primero deberá calcular las x e y apropiadas.
valores de compensación:

.. literalinclude:: images/008.php

Convertir imágenes
==================

El método ``convert()`` cambia el indicador interno de la biblioteca para el formato de archivo deseado. Esto no toca el recurso de imagen real, pero indica a ``save()`` qué formato usar::

    convertir(int $tipoimagen)

- ``$imageType`` es una de las constantes de tipo de imagen de PHP (ver por ejemplo https://www.php.net/manual/en/function.image-type-to-mime-type.php):

  .. literalinclude:: images/009.php

.. note:: ImageMagick already saves files in the type
    indicado por su extensión, ignorando ``$imageType``.

Imágenes de ajuste
==================

El método ``fit()`` tiene como objetivo ayudar a simplificar el recorte de una parte de una imagen de una manera "inteligente", siguiendo los siguientes pasos:

- Determine la parte correcta de la imagen original para recortar para mantener la relación de aspecto deseada.
- Recortar la imagen original.
- Cambiar el tamaño a las dimensiones finales.

::

    ajuste(int $ancho, int $alto = nulo, cadena $posición = 'centro')

- ``$width`` es el ancho final deseado de la imagen.
- ``$height`` es la altura final deseada de la imagen.
- ``$position`` determina la parte de la imagen que se recortará. Posiciones permitidas: ``'arriba-izquierda'``, ``'arriba'``, ``'arriba-derecha'``, ``'izquierda'``, ``'centro'``, ``' derecha'``, ``'abajo-izquierda'``, ``'abajo'``, ``'abajo-derecha'``.

Esto proporciona una forma mucho más sencilla de recortar que siempre mantendrá la relación de aspecto:

.. literalinclude:: images/010.php

Aplanamiento de imágenes
========================

El método ``aplanar()`` tiene como objetivo agregar un color de fondo detrás de imágenes transparentes (PNG) y convertir píxeles RGBA en píxeles RGB.

- Especifique un color de fondo al convertir de imágenes transparentes a jpg.

::

    aplanar(int $rojo = 255, int $verde = 255, int $azul = 255)

- ``$red`` es el valor rojo del fondo.
- ``$green`` es el valor verde del fondo.
- ``$blue`` es el valor azul del fondo.

.. literalinclude:: images/011.php

Voltear imágenes
================

Las imágenes se pueden voltear a lo largo de su eje horizontal o vertical::

    voltear(cadena $dir)

- ``$dir`` especifica el eje a lo largo del cual voltear. Puede ser ``'vertical'`` u ``'horizontal'``.

.. literalinclude:: images/012.php

Cambiar el tamaño de las imágenes
=================================

Se puede cambiar el tamaño de las imágenes para que se ajusten a cualquier dimensión que necesite con el método ``resize()``::

    cambiar tamaño(int $ancho, int $alto, bool $maintainRatio = false, cadena $masterDim = 'automático')

- ``$width`` es el ancho deseado de la nueva imagen en píxeles
- ``$height`` es la altura deseada de la nueva imagen en píxeles
- ``$maintainRatio`` determina si la imagen se estira para ajustarse a las nuevas dimensiones o si se mantiene la relación de aspecto original.
- ``$masterDim`` especifica qué eje debe tener su dimensión respetada al mantener la relación. Ya sea ``'ancho'``, ``'alto'``.

Al cambiar el tamaño de las imágenes, puede elegir si desea mantener la proporción de la imagen original o estirar/aplastar la nueva.
imagen para que se ajuste a las dimensiones deseadas. Si ``$maintainRatio`` es verdadero, la dimensión especificada por ``$masterDim`` permanecerá igual,
mientras que la otra dimensión se modificará para que coincida con la relación de aspecto de la imagen original.

.. literalinclude:: images/013.php

Imágenes giratorias
===================

El método ``rotate()`` le permite rotar una imagen en incrementos de 90 grados::

    rotar(flotar $ángulo)

- ``$angle`` es el número de grados a rotar. Uno de ``90``, ``180``, ``270``.

.. note:: While the ``$angle`` parameter accepts a float, it will convert it to an integer during the process.
        Si el valor es distinto de los tres valores enumerados anteriormente, generará una excepción Higgs\Images\ImageException.

Agregar una marca de agua de texto
==================================

Puedes superponer una marca de agua de texto a la imagen de forma muy sencilla con el método ``text()``. Esto es útil para colocar derechos de autor.
avisos, nombres de fotógrafos o simplemente marcar las imágenes como vista previa para que no se utilicen en la versión final de otras personas.
productos.

::

    texto(cadena $texto,matriz $opciones = [])

El primer parámetro es la cadena de texto que desea mostrar. El segundo parámetro es una serie de opciones.
que le permiten especificar cómo se debe mostrar el texto:

.. literalinclude:: images/014.php

Las posibles opciones que se reconocen son las siguientes:

- ``color`` Color del texto (número hexadecimal), es decir, #ff0000
- ``opacidad`` Un número entre 0 y 1 que representa la opacidad del texto.
- ``withShadow`` Valor booleano para mostrar una sombra o no.
- ``shadowColor`` Color de la sombra (número hexadecimal)
- ``shadowOffset`` Cuántos píxeles compensar la sombra. Se aplica tanto a los valores verticales como a los horizontales.
- ``hAlign`` Alineación horizontal: izquierda, centro, derecha
- ``vAlign`` Alineación vertical: superior, media, inferior
- ``hOffset`` Desplazamiento adicional en el eje x, en píxeles
- ``vOffset`` Desplazamiento adicional en el eje y, en píxeles
- ``fontPath`` La ruta completa del servidor a la fuente TTF que desea utilizar. Se utilizará la fuente del sistema si no se proporciona ninguna.
- ``fontSize`` El tamaño de fuente a utilizar. Cuando se utiliza el controlador GD con la fuente del sistema, los valores válidos están entre 1 y 5.

.. note:: The ImageMagick driver does not recognize full server path for fontPath. Instead, simply provide the
        nombre de una de las fuentes del sistema instaladas que desea utilizar, es decir, Calibri.
