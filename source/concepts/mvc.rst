###############################
Modelos, vistas y controladores
###############################

.. contents::
    :local:
    :depth: 2


¿Qué es MVC?
************

Siempre que creas una aplicación, debes encontrar una manera de organizar el código para que sea fácil de localizar.
los archivos adecuados y simplificar su mantenimiento. Como la mayoría de los marcos web, Higgs utiliza el modelo,
Ver, patrón Controlador (MVC) para organizar los archivos. Esto mantiene los datos, la presentación y el flujo a través del
aplicación como partes separadas.

Cabe señalar que existen muchas opiniones sobre las funciones exactas de cada elemento,
pero este documento describe nuestra opinión al respecto. Si lo piensas diferente, eres libre de modificar la forma en que usas
cada pieza como necesites.

**Los modelos** administran los datos de la aplicación y ayudan a hacer cumplir cualquier regla comercial especial que la aplicación pueda necesitar.

**Las vistas** son archivos simples, con poca o ninguna lógica, que muestran la información al usuario.

**Los controladores** actúan como código adhesivo, agrupando datos de un lado a otro entre la vista (o el usuario que los está viendo) y
el almacenamiento de datos.

En su forma más básica, los controladores y modelos son simplemente clases que tienen un trabajo específico. No son la única clase.
tipos que puede usar, obviamente, pero constituyen el núcleo de cómo está diseñado para ser utilizado este marco. Ellos
tiene directorios designados en el directorio **app** para su almacenamiento, aunque usted es libre de almacenarlos
donde desee, siempre y cuando tengan el espacio de nombres adecuado. Discutiremos esto con más detalle a continuación.

Echemos un vistazo más de cerca a cada uno de estos tres componentes principales.


Los componentes
***************

Puntos de vista
===============

Las vistas son los archivos más simples y normalmente son HTML con cantidades muy pequeñas de PHP. El PHP debería ser muy simple,
Por lo general, simplemente muestra el contenido de una variable o recorre algunos elementos y muestra su información en una tabla.

Las vistas obtienen los datos para mostrar de los controladores, quienes los pasan a las vistas como variables que se pueden mostrar.
con simples llamadas de ``eco``. También puede mostrar otras vistas dentro de una vista, lo que hace que sea bastante sencillo mostrar una
encabezado o pie de página común en cada página.

Las vistas generalmente se almacenan en **aplicación/Vistas**, pero pueden volverse difíciles de manejar rápidamente si no se organizan de alguna manera.
Higgs no exige ningún tipo de organización, pero una buena regla general sería crear un nuevo directorio en
el directorio **Vistas** para cada controlador. Luego, nombre las vistas por el nombre del método. Esto hace que sean muy fáciles de encontrar más tarde.
en. Por ejemplo, el perfil de un usuario podría mostrarse en un controlador llamado ``Usuario`` y en un método llamado ``perfil``.
Puede almacenar el archivo de vista para este método en **app/Views/user/profile.php**.

Ese tipo de organización funciona muy bien como hábito básico a adquirir. En ocasiones, es posible que necesites organizarlo de manera diferente.
Eso no es un problema. Mientras Higgs pueda encontrar el archivo, podrá mostrarlo.

:doc:`Más información sobre las vistas</outgoing/views>`

Modelos
=======

El trabajo de un modelo es mantener un único tipo de datos para la aplicación. Pueden ser usuarios, publicaciones de blogs, transacciones, etc.
En este caso, el trabajo del modelo tiene dos partes: hacer cumplir las reglas de negocio sobre los datos a medida que se extraen o se introducen en el
base de datos; y manejar el guardado y recuperación real de los datos de la base de datos.

Para muchos desarrolladores, la confusión surge a la hora de determinar qué reglas comerciales se aplican. Simplemente significa que
cualquier restricción o requisito sobre los datos es manejado por el modelo. Esto podría incluir la normalización de datos sin procesar antes
se guarda para cumplir con los estándares de la empresa o para formatear una columna de cierta manera antes de entregársela al controlador.
Al mantener estos requisitos comerciales en el modelo, no repetirá el código en varios controladores y accidentalmente
Falta actualizar un área.

Los modelos normalmente se almacenan en **aplicación/Modelos**, aunque pueden usar un espacio de nombres para agruparlos según sea necesario.

:doc:`Más información sobre los modelos</models/model>`

Controladores
=============

Los controladores tienen un par de roles diferentes que desempeñar. La más obvia es que reciben información del usuario y
luego determine qué hacer con él. Esto a menudo implica pasar los datos a un modelo para guardarlos o solicitar datos de
el modelo que luego se pasa a la vista que se mostrará. Esto también incluye cargar otras clases de servicios públicos,
si es necesario, para manejar tareas especializadas que están fuera del ámbito del modelo.

La otra responsabilidad del controlador es manejar todo lo relacionado con las solicitudes HTTP: redirecciones,
autenticación, seguridad web, codificación, etc. En resumen, el controlador es donde usted se asegura de que las personas puedan acceder
estén allí y obtengan los datos que necesitan en un formato que puedan utilizar.

Los controladores generalmente se almacenan en **aplicación/Controladores**, aunque pueden usar un espacio de nombres para agruparse.
necesitas.

:doc:`Más información sobre los controladores</incoming/controllers>`
