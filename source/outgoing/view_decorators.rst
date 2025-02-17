###############
Ver decoradores
###############

Los decoradores de vistas permiten que su aplicación modifique la salida HTML durante el proceso de renderizado. esto sucede solo
antes de ser almacenado en caché y le permite aplicar funcionalidad personalizada a sus vistas.


Creando decoradores
*******************

Crear sus propios decoradores de vistas requiere crear una nueva clase que implemente ``Higgs\View\ViewDecoratorInterface``.
Esto requiere un método único que tome la cadena HTML generada, realice cualquier modificación en ella y devuelva
el HTML resultante.

.. literalinclude:: view_decorators/001.php

Una vez creada, la clase debe registrarse en ``app/Config/View.php``:

.. literalinclude:: view_decorators/002.php

Ahora que está registrado, se llamará al decorador para cada vista que se represente o analice.
Los decoradores se llaman en el orden especificado en esta configuración.
