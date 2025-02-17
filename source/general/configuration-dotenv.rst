####################
Variables de Entorno
####################

Las variables de entorno son una práctica ampliamente utilizada en el desarrollo de software para manejar configuraciones
que pueden cambiar entre distintos entornos como desarrollo, pruebas y producción. Son valores dinámicos que pueden afectar
la forma en que las aplicaciones se ejecutan, proporcionando una manera flexible y segura de gestionar la configuración
de la aplicación sin alterar el código fuente.

En nuestro framework, las variables de entorno forman parte integral de la configuración de cada plataforma creada y su
uso está restringido a características específicas. Esto significa que, aunque las variables de entorno pueden ser definidas
y utilizadas para configurar el comportamiento a nivel del sistema, los módulos adicionales desarrollados en las plataformas
no pueden modificar estas variables directamente.

Ventajas de la Restricción
==========================
    - **Control Centralizado**: Mantener la definición y el uso de variables de entorno centralizadas permite un mayor control sobre la configuración del sistema, evitando que módulos individuales alteren configuraciones críticas que podrían afectar la estabilidad y seguridad de la plataforma.
    - **Seguridad Mejorada**: Al restringir el acceso y la modificación de las variables de entorno, se reducen los riesgos de cambios no autorizados o accidentales que podrían exponer información sensible o desconfigurar el sistema.
    - **Consistencia en la Configuración**: Garantiza que todas las partes del sistema operen bajo las mismas configuraciones, lo que puede mejorar la predictibilidad y el comportamiento del sistema en diferentes entornos.

Implementación
==========================

En nuestro framework, las variables de entorno son configuradas y gestionadas por el núcleo del sistema o por administradores
de programación de las plataformas. Los módulos adicionales deben usar interfaces proporcionadas por el framework para acceder
a las configuraciones necesarias sin poder modificarlas directamente (hablando especificacmente de las variables de Entorno).

.. note:: **Historia y Evolución**. El concepto de variables de entorno se remonta a los primeros sistemas operativos Unix en la década de 1970. Estos sistemas introdujeron variables de entorno como una forma de pasar datos de configuración a los procesos en ejecución. Con el tiempo, esta práctica se ha adoptado y refinado en diversos lenguajes y plataformas de desarrollo.

¿Qué son las Variables de Entorno?
----------------------------------
Las variables de entorno son pares clave-valor que se almacenan fuera del código de la aplicación. Pueden contener información
sensible o específica del entorno, como credenciales de bases de datos, claves de API, rutas de archivos y configuraciones
del servidor. Al estar fuera del código fuente, facilitan la gestión y cambian según el entorno en el que se despliegue
la aplicación.

Ventajas de las Variables de Entorno
------------------------------------
    - **Seguridad**: Separación de credenciales: Almacenar credenciales y configuraciones sensibles fuera del código fuente ayuda a proteger información crítica. Esto es crucial para evitar la exposición de datos sensibles en repositorios públicos.
    - **Control de acceso**: Las variables de entorno pueden gestionarse mediante permisos del sistema operativo, limitando el acceso solo a usuarios autorizados.
    - **Flexibilidad**: Despliegue simplificado: Facilitan el cambio de configuración entre diferentes entornos sin modificar el código. Por ejemplo, puedes tener diferentes configuraciones para desarrollo, pruebas y producción.
    - **Mantenimiento**: Permiten actualizar configuraciones sin necesidad de redeploy del código, lo cual es útil para ajustes rápidos en producción.
    - **Consistencia**: El uso de variables de entorno es una práctica estándar en la industria, soportada por la mayoría de frameworks y plataformas, lo que facilita la adopción y la integración con herramientas existentes.
    - **Documentación y legibilidad**: Mantener las configuraciones en un archivo separado hace que el código sea más limpio y fácil de entender, además de proporcionar una documentación implícita de las configuraciones necesarias.

Comparación con Otros Métodos
-----------------------------
Archivos de Configuración
*************************
    - **Ventajas**: Los archivos de configuración permiten una estructura jerárquica y más compleja, y pueden incluir comentarios y documentación.
    - **Desventajas**: Sin embargo, suelen estar más expuestos a ser incluidos en el control de versiones y pueden no estar tan protegidos como las variables de entorno.

Variables Hardcoded
*******************
    - **Ventajas**: La configuración hardcoded es simple y directa.
    - **Desventajas**: Es inflexible, insegura y hace que el código sea más difícil de mantener y desplegar en múltiples entornos.

Buenas Prácticas
----------------
No incluir archivos .env en el control de versiones: Utiliza .gitignore para excluir el archivo .env.
Documentar las variables necesarias: Mantén un ejemplo .env.example en tu repositorio para indicar qué variables son necesarias.
Usar un gestor de configuración: En entornos de producción, considera el uso de gestores de configuración y secretos, como AWS Secrets Manager o HashiCorp Vault.
Validación de variables: Utiliza herramientas para validar que todas las variables necesarias estén presentes y correctamente formateadas.
















.. _dotenv-file:

Archivo Dotenv
==============

Higgs hace que sea simple y sin dolor usar Variables de Entorno mediante un archivo "dotenv". El término proviene del nombre del archivo, que comienza con un punto antes del texto "env".

Crear un Archivo Dotenv
-----------------------

Higgs espera que el archivo **.env** esté en la raíz de tu proyecto junto a los directorios **app**. Hay un archivo de plantilla distribuido con Higgs que se encuentra en la raíz del proyecto llamado **env** (Nota que no hay punto (``.``) al inicio).

Tiene una gran colección de variables que tu proyecto podría usar que han sido asignadas con valores vacíos, ficticios o predeterminados. Puedes usar este archivo como punto de partida para tu aplicación renombrando la plantilla a **.env**, o haciendo una copia de ella llamada **.env**.

.. warning:: Asegúrate de que el archivo **.env** NO sea rastreado por tu sistema de control de versiones. Para *git* eso significa agregarlo a **.gitignore**. No hacerlo podría resultar en que credenciales sensibles se expongan al público.

Configurar Variables
---------------------

Las configuraciones se almacenan en archivos **.env** como una simple colección de pares nombre/valor separados por un signo igual.
::

    S3_BUCKET = dotenv
    SECRET_KEY = super_secret_key
    HIGGS_ENVIRONMENT = development

Cuando tu aplicación se ejecute, **.env** se cargará automáticamente y las variables se colocarán en el entorno. Si ya existe una variable en el entorno, NO se sobrescribirá.

Obtener Variables
-----------------

Las variables de entorno cargadas se pueden acceder usando cualquiera de los siguientes:

``getenv()``, ``$_SERVER`` o ``$_ENV``.

.. warning:: Nota que tus configuraciones del archivo **.env** se agregan a ``$_SERVER`` y ``$_ENV``. Como efecto secundario, esto significa que si tu aplicación Higgs (por ejemplo) genera un ``var_dump($_ENV)`` o ``phpinfo()`` (por depuración u otras razones válidas), o se muestra un informe de error detallado en el entorno de ``desarrollo``, **tus credenciales seguras se expondrán públicamente**.

Variables Anidadas
------------------

Para ahorrar en escritura, puedes reutilizar variables que ya has especificado en el archivo envolviendo el nombre de la variable dentro de ``${...}``:

::

    BASE_DIR = "/var/webroot/project-root"
    CACHE_DIR = "${BASE_DIR}/cache"
    TMP_DIR = "${BASE_DIR}/tmp"

Variables con Espacios de Nombres
---------------------------------

Habrá ocasiones en las que tendrás varias variables con el mismo nombre. El sistema necesita una forma de saber cuál debe ser la configuración correcta. Este problema se resuelve mediante "*namespacing*" de las variables.

Las variables con espacios de nombres utilizan una notación de puntos para calificar los nombres de las variables para que sean únicos cuando se incorporan al entorno. Esto se hace incluyendo un prefijo distintivo seguido de un punto (.), y luego el nombre de la variable en sí.

::

    // variables sin espacios de nombres
    name = "George"
    db = my_db

    // variables con espacios de nombres
    address.city = "Berlin"
    address.country = "Germany"
    frontend.db = sales
    backend.db = admin
    BackEnd.db = admin

.. _env-var-namespace-separator:

Separador de Espacios de Nombres
--------------------------------

Algunos entornos, por ejemplo, Docker, CloudFormation, no permiten nombres de variables con puntos (``.``). En tal caso, desde la versión v7.1.5, también puedes usar guiones bajos (``_``) como separador.

::

    // variables con nombres de espacios con guion bajo
    app_forceGlobalSecureRequests = true
    app_CSPEnabled = true

Clases de Configuración y Variables de Entorno
----------------------------------------------

Cuando instancias una clase de configuración, cualquier variable de entorno *namespaced* se considera para fusionarse en las propiedades del objeto de configuración.

.. important:: No puedes agregar una nueva propiedad estableciendo variables de entorno, ni cambiar un valor escalar a un arreglo. Ver :ref:`env-var-replacements-for-data`.

.. note:: Esta característica se implementa en la clase ``Higgs\Config\BaseConfig``. Así que no funcionará con algunos archivos en la carpeta **app/Config** que no extienden la clase.

Si el prefijo de una variable con espacio de nombres coincide exactamente con el espacio de nombres de la clase de configuración, entonces la parte final del ajuste (después del punto) se trata como una propiedad de configuración. Si coincide con una propiedad de configuración existente, el valor de la variable de entorno reemplazará el valor correspondiente del archivo de configuración. Si no hay coincidencia, las propiedades de la clase de configuración no se cambian. En este uso, el prefijo debe ser el espacio de nombres completo (sensible a mayúsculas y minúsculas) de la clase.

::

    Config\App.forceGlobalSecureRequests = true
    Config\App.CSPEnabled = true

.. note:: Tanto el prefijo del espacio de nombres como el nombre de la propiedad son sensibles a mayúsculas y minúsculas. Deben coincidir exactamente con los nombres de espacio de nombres y propiedad definidos en el archivo de la clase de configuración.

Lo mismo aplica para un *prefijo corto*, que es un espacio de nombres usando solo la versión en minúsculas del nombre de la clase de configuración. Si el prefijo corto coincide con el nombre de la clase, el valor de **.env** reemplaza el valor del archivo de configuración.

::

    app.forceGlobalSecureRequests = true
    app.CSPEnabled = true

Desde la versión v7.1.5, también puedes escribir con guiones bajos::

    app_forceGlobalSecureRequests = true
    app_CSPEnabled = true

.. note:: Al usar el *prefijo corto* los nombres de las propiedades deben coincidir exactamente con el nombre definido en la clase.

.. _env-var-replacements-for-data:

Variables de Entorno como Reemplazos para Datos
===============================================

Es muy importante recordar siempre que las variables de entorno contenidas en tu **.env** son **solo reemplazos para valores escalares existentes**.

Simplemente, solo puedes cambiar el valor escalar de la propiedad que existe en la clase Config estableciéndolo en tu **.env**.

    1. No puedes agregar una propiedad que no esté definida en la clase Config.
    2. No puedes cambiar un valor escalar en una propiedad a un arreglo.
    3. No puedes agregar un elemento a un arreglo existente.

Por ejemplo, no puedes simplemente poner ``app.myNewConfig = foo`` en tu **.env** y esperar que tu ``Config\App`` tenga
mágicamente esa propiedad y valor en tiempo de ejecución.

Cuando tienes la propiedad ``$default = ['encrypt' => false]`` en tu ``Config\Database``, no puedes cambiar el valor
``encrypt`` a un arreglo incluso si pones ``database.default.encrypt = ['ssl' => true]`` en tu **.env**.

.. note:: La última notación sin prefijo de espacio de nombres se describe solo para variables que se usan para otros propósitos fuera de Higgs.

Variables de Entorno de Protección
----------------------------------

Si estás usando Git para tu control de versiones, es importante asegurarte de que tu archivo **.env** esté incluido en
tu archivo **.gitignore** para asegurarte de que no se incluya accidentalmente en tu repositorio de control
de versiones.


Tratar las variables de entorno como matrices
=============================================

Una variable de entorno con espacio de nombres se puede tratar además como una matriz.
Si el prefijo coincide con la clase de configuración, entonces el resto del
El nombre de la variable de entorno se trata como una referencia de matriz si también
contiene un punto.

::

 // variable con espacio de nombres normal
 Config\SimpleConfig.nombre = George

 // variables con espacio de nombres de matriz
 Config\SimpleConfig.address.city = "Berlín"
 Config\SimpleConfig.address.country = "Alemania"

Si esto se referiera a un objeto de configuración SimpleConfig, el ejemplo anterior se trataría
como:

.. literalinclude:: configuration/006.php

Cualquier otro elemento de la propiedad ``$address`` no se modificará.

También puede utilizar el nombre de la propiedad de la matriz como prefijo. Si el archivo de entorno
Si tuviera lo siguiente, entonces el resultado sería el mismo que el anterior.

::

 // variables con espacio de nombres de matriz
 Config\SimpleConfig.address.city = "Berlín"
 dirección.país = "Alemania"

Manejo de diferentes entornos
-----------------------------

La configuración de múltiples entornos se logra fácilmente utilizando un archivo **.env** separado con valores modificados para satisfacer las necesidades de ese entorno.

El archivo no debe contener todas las configuraciones posibles para cada clase de configuración utilizada por la aplicación. En verdad, debería incluir sólo aquellos elementos que son específicos del entorno o que son detalles confidenciales como contraseñas y claves API y otra información que no debe exponerse. Pero cualquier cosa que cambie entre implementaciones es un juego limpio.

En cada entorno, coloque el archivo **.env** en la carpeta raíz del proyecto. Para la mayoría de las configuraciones, este será el mismo nivel que los directorios ``app``.

No realice un seguimiento de los archivos **.env** con su sistema de control de versiones. Si lo hace y el repositorio se hace público, habrá puesto información confidencial donde todos puedan encontrarla.

.. _registradores: