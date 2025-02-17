#######################
Información de registro
#######################

.. contents::
    :local:
    :depth: 2

Niveles de registro
===================

Puede registrar información en los archivos de registro locales utilizando el método :php:func:`log_message()`. Debes suministrar
el "nivel" del error en el primer parámetro, indicando qué tipo de mensaje es (depuración, error, etc).
El segundo parámetro es el mensaje en sí:

.. literalinclude:: logging/001.php

Hay ocho niveles de registro diferentes, que coinciden con el `RFC 5424<https://tools.ietf.org/html/rfc5424>` _ niveles, y son los siguientes:
=========== ======================================== ============================
Descripción del nivel
=========== ======================================== ============================
debug Información detallada de depuración.
info Eventos interesantes en su aplicación, como un usuario que inicia sesión, registra consultas SQL, etc.
observe eventos normales, pero significativos, en su aplicación.
advertencia Sucesos excepcionales que no son errores, como el uso de API obsoletas,
            mal uso de una API u otras cosas indeseables que no necesariamente están mal.
error Errores de tiempo de ejecución que no requieren acción inmediata pero que normalmente deben registrarse y monitorearse.
critic Condiciones críticas, como un componente de la aplicación no disponible o una excepción inesperada.
alerta Se deben tomar medidas de inmediato, como cuando un sitio web completo no funciona, la base de datos no está disponible, etc.
Emergencia El sistema está inutilizable.
=========== ======================================== ============================

El sistema de registro no proporciona formas de alertar a los administradores de sistemas o webmasters sobre estos eventos; únicamente registran
la información. Para muchos de los niveles de eventos más críticos, el registro ocurre automáticamente por el
Manejador de errores, descrito anteriormente.

.. _logging-configuration:

Configuración
=============

Puede modificar qué niveles se registran realmente, así como asignar diferentes registradores para manejar diferentes niveles, dentro de
el archivo de configuración **app/Config/Logger.php**.

El valor ``umbral`` del archivo de configuración determina qué niveles se registran en su aplicación. Si hay algún nivel
La aplicación solicita que se registren, pero el umbral no les permite iniciar sesión actualmente, serán
ignorado. El método más sencillo de utilizar es establecer este valor en el nivel mínimo que desea que se registre. Por ejemplo,
Si desea registrar mensajes de advertencia y no mensajes de información, deberá establecer el umbral en ``5``. Cualquier solicitud de registro con
se registraría un nivel de 5 o menos (que incluye errores de tiempo de ejecución, errores del sistema, etc.) y se obtendría información, avisos y depuración.
sería ignorado:

.. literalinclude:: logging/002.php

Una lista completa de niveles y su valor de umbral correspondiente se encuentra en el archivo de configuración para su referencia.

Puede elegir los niveles específicos que desea registrar asignando una serie de números de nivel de registro
al valor umbral:

.. literalinclude:: logging/003.php

Uso de múltiples controladores de registros
---------------------------

El sistema de registro puede admitir múltiples métodos de manejo del registro que se ejecutan al mismo tiempo. Cada manejador puede
configurarse para manejar niveles específicos e ignorar el resto. Actualmente, tres controladores vienen con una instalación predeterminada:

- **File Handler** es el controlador predeterminado y creará un único archivo para cada día localmente. Este es el
  método recomendado de registro.
- **Controlador ChromeLogger** Si tiene la extensión `ChromeLogger<https://craig.is/writing/chrome-logger>` _
  instalado en el navegador web Chrome, puede utilizar este controlador para mostrar la información de registro en
  Ventana de la consola de Chrome.
- **Controlador de registro de errores** Este controlador aprovechará la función nativa ``error_log()`` de PHP y escribirá
  los troncos allí. Actualmente, sólo se admiten los tipos de mensajes ``0`` y ``4`` de ``error_log()``.

Los manejadores se configuran en el archivo de configuración principal, en la propiedad ``$handlers``, que es simplemente
una serie de controladores y su configuración. Cada controlador se especifica siendo la clave la completa
nombre de clase con espacio de nombre. El valor será una matriz de propiedades variables, específicas de cada controlador.
La sección de cada controlador tendrá una propiedad en común: ``handles``, que es una matriz de nivel de registro.
*nombres* para los que el controlador registrará información.

.. literalinclude:: logging/004.php

Modificando el mensaje con contexto
===================================

A menudo querrás modificar los detalles de tu mensaje según el contexto del evento que se está registrando.
Es posible que necesite registrar una identificación de usuario, una dirección IP, las variables POST actuales, etc. Puede hacerlo mediante el uso
marcadores de posición en su mensaje. Cada marcador de posición debe estar entre llaves. En el tercer parámetro,
debe proporcionar una serie de nombres de marcadores de posición (sin las llaves) y sus valores. Estos serán insertados
en la cadena del mensaje:

.. literalinclude:: logging/005.php

Si desea registrar una excepción o un error, puede usar la clave de 'excepción' y el valor es el
Excepción o error en sí. Se generará una cadena a partir de ese objeto que contiene el mensaje de error, el
nombre del archivo y número de línea. Aún debes proporcionar el marcador de posición de excepción en el mensaje:

.. literalinclude:: logging/006.php

Existen varios marcadores de posición principales que se expandirán automáticamente según la solicitud de página actual:

+----------------+----------------------------------------------------+
| Marcador de posición | Valor insertado |
+================+================================= ====================+
| {post_vars} | variables $_POST |
+----------------+----------------------------------------------------+
| {get_vars} | variables $_GET |
+----------------+----------------------------------------------------+
| {vars_sesión} | variables $_SESSION |
+----------------+----------------------------------------------------+
| {entorno} | Nombre del entorno actual, es decir, desarrollo |
+----------------+----------------------------------------------------+
| {archivo} | El nombre del archivo que llama al registrador |
+----------------+----------------------------------------------------+
| {línea} | La línea en {file} donde se llamó al registrador |
+----------------+----------------------------------------------------+
| {entorno:foo} | El valor de 'foo' en $_ENV |
+----------------+----------------------------------------------------+

Uso de registradores de terceros
================================

Puede utilizar cualquier otro registrador que desee siempre que se extienda desde cualquiera de los dos
``Psr\Log\LoggerInterface`` y es `PSR-3<https://www.php-fig.org/psr/psr-3/>` _compatible. Esto significa
que puede utilizar fácilmente para cualquier registrador compatible con PSR-3 o crear el suyo propio.

Debe asegurarse de que el sistema pueda encontrar el registrador de terceros agregándolo a
el archivo de configuración **app/Config/Autoload.php**, o mediante otro cargador automático,
como compositor. A continuación, debes modificar **app/Config/Services.php** para que apunte al ``logger``
alias a su nuevo nombre de clase.

Ahora, cualquier llamada que se realice a través de la función :php:func:`log_message()` utilizará su biblioteca.
