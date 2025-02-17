******************************
Reemplazo de funciones comunes
******************************

Hay bastantes funciones necesarias para Higgs que deben cargarse temprano para usar en las clases principales y
por lo tanto no se puede colocar en un ayudante. Si bien la mayoría de los usuarios nunca necesitarán hacer esto, la opción de reemplazar
Estas funciones existen para aquellos que quieran alterar significativamente el núcleo de Higgs. En la **aplicación/**
directorio hay un archivo **Common.php**, y cualquier función definida allí tendrá prioridad sobre las versiones
encontrado en **system/Common.php**. Esta también es una oportunidad para crear funciones disponibles globalmente que desea
uso en todo el marco.

.. note:: Messing with a core system class has a lot of implications, so make sure you know what you are doing before
    intentarlo.
