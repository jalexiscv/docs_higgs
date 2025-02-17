#################
Horarios y fechas
#################

Higgs proporciona una clase de fecha/hora inmutable y totalmente localizada que se basa en el objeto DateTimeImmutable de PHP, pero utiliza el método Intl
Funciones de la extensión para convertir horas entre zonas horarias y mostrar la salida correctamente para diferentes configuraciones regionales. Esta clase
es la clase ``Time`` y vive en el espacio de nombres ``Higgs\I18n``.

.. note:: Since the Time class extends ``DateTimeImmutable``, if there are features that you need that this class doesn't provide,
    probablemente puedas encontrarlos dentro del `DateTimeImmutable<https://www.php.net/manual/en/class.datetimeimmutable.php>` _ clase misma.

.. note:: Prior to v7.3.0, the Time class extended ``DateTime`` and some inherited methods changed
    el estado actual del objeto. El error se solucionó en v7.3.0. Si necesita la clase Time antigua para retroceder
    compatibilidad, puede utilizar la clase ``TimeLegacy`` obsoleta por el momento.

.. contents::
    :local:
    :depth: 2


Creación de instancias
**********************

Hay varias formas de crear una nueva instancia de Time. La primera es simplemente crear una nueva instancia.
como cualquier otra clase.

Cuando lo haces de esta manera, puedes pasar una cadena que represente el tiempo deseado. Esto puede
Sea cualquier cadena que la función `strtotime()`_ de PHP pueda analizar:

.. _strtotime(): https://www.php.net/manual/en/function.strtotime.php

.. literalinclude:: time/001.php

Puede pasar cadenas que representen la zona horaria y la configuración regional en los segundos parámetros y, respectivamente. Zonas horarias
puede ser cualquiera soportado por `DateTimeZone de PHP<https://www.php.net/manual/en/timezones.php>` __ clase. El lugar puede ser
cualquiera soportado por la configuración regional de PHP<https://www.php.net/manual/en/class.locale.php>` __ clase. Si no hay ninguna ubicación o zona horaria
siempre que se proporcione, se utilizarán los valores predeterminados de la aplicación.

.. literalinclude:: time/002.php

ahora()
=======

La clase Time tiene varios métodos auxiliares para crear instancias de la clase. El primero de ellos es el método ``now()``
que devuelve una nueva instancia establecida en la hora actual. Puede pasar cadenas que representen la zona horaria y la ubicación
en el segundo y parámetros, respectivamente. Si no se proporciona ninguna configuración regional o zona horaria, se utilizarán los valores predeterminados de la aplicación.

.. literalinclude:: time/003.php

analizar gramaticalmente()
==========================

Este método auxiliar es una versión estática del constructor predeterminado. Se necesita una cadena aceptable como DateTimeImmutable
constructor como primer parámetro, una zona horaria como segundo parámetro y la configuración regional como tercer parámetro:

.. literalinclude:: time/004.php

hoy()
=====

Devuelve una nueva instancia con la fecha establecida en la fecha actual y la hora establecida en medianoche. Acepta cuerdas
para la zona horaria y local en el primer y segundo parámetro:

.. literalinclude:: time/005.php

ayer()
======

Devuelve una nueva instancia con la fecha establecida en la fecha de ayer y la hora establecida en medianoche. Acepta cuerdas
para la zona horaria y local en el primer y segundo parámetro:

.. literalinclude:: time/006.php

mañana()
========

Devuelve una nueva instancia con la fecha establecida en la fecha de mañana y la hora establecida en medianoche. Acepta cuerdas
para la zona horaria y local en el primer y segundo parámetro:

.. literalinclude:: time/007.php

crearDesdeFecha()
=================

Si se dan entradas separadas para **año**, **mes** y **día**, se devolverá una nueva instancia. Si alguno de estos parámetros
no se proporcionan, utilizará el valor actual para completarlo. Acepta cadenas para la zona horaria y la configuración regional en el
cuarto y quinto parámetros:

.. literalinclude:: time/008.php

crearDesdeTiempo()
==================

Como ``createFromDate()`` excepto que solo se refiere a las **horas**, **minutos** y **segundos**. Utiliza el
día actual para la parte de fecha de la instancia de Hora. Acepta cadenas para la zona horaria y la configuración regional en el
cuarto y quinto parámetros:

.. literalinclude:: time/009.php

crear()
=======

Una combinación de los dos métodos anteriores toma **año**, **mes**, **día**, **hora**, **minutos** y **segundos**.
como parámetros separados. Cualquier valor no proporcionado utilizará la fecha y hora actuales para determinarlo. Acepta cadenas para el
zona horaria y localidad en los parámetros cuarto y quinto:

.. literalinclude:: time/010.php

crear desde formato()
=====================

Este es un reemplazo del método del mismo nombre de DateTimeImmutable. Esto permite configurar la zona horaria al mismo tiempo,
y devuelve una instancia ``Time``, en lugar de DateTimeImmutable:

.. literalinclude:: time/011.php

.. _time-createfromtimestamp:

crearFromTimestamp()
====================

Este método toma una marca de tiempo UNIX y, opcionalmente, la zona horaria y la configuración regional, para crear una nueva instancia de tiempo:

.. literalinclude:: time/012.php

.. note:: Due to a bug, prior to v7.4.6, this method returned a Time instance
    en la zona horaria UTC cuando no especifica una zona horaria.

crearDesdeInstancia()
=====================

Cuando trabaje con otras bibliotecas que proporcionan una instancia de DateTime, puede usar este método para convertir esa
a una instancia de tiempo, configurando opcionalmente la configuración regional. La zona horaria se determinará automáticamente a partir de DateTime
instancia pasada en:

.. literalinclude:: time/013.php

hastaFechaHora()
================

Si bien no es un creador de instancias, este método es lo opuesto al método **instancia**, lo que le permite convertir una hora
instancia en una instancia DateTime. Esto conserva la configuración de zona horaria, pero pierde la configuración regional, ya que DateTime es
no conoce las configuraciones regionales:

.. literalinclude:: time/014.php



Mostrando el valor
******************

Dado que la clase Time extiende DateTimeImmutable, obtienes todos los métodos de salida que proporciona, incluido el método ``format()``.
Sin embargo, los métodos DateTimeImmutable no proporcionan un resultado localizado. La clase Time proporciona varios métodos auxiliares.
Sin embargo, para mostrar versiones localizadas del valor.

toLocalizedString()
===================

Esta es la versión localizada del método ``format()`` de DateTimeImmutable. Sin embargo, en lugar de utilizar los valores con los que quizás esté familiarizado,
debe utilizar valores aceptables para `IntlDateFormatter<https://www.php.net/manual/en/class.intldateformatter.php>` __ clase.
Puede encontrar una lista completa de valores "aquí<https://unicode-org.github.io/icu-docs/apidoc/released/icu4c/classSimpleDateFormat.html#details>` __.

.. literalinclude:: time/015.php

.. _time-todatetimestring:

toDateTimeString()
==================

Este es el primero de tres métodos auxiliares para trabajar con `IntlDateFormatter<https://www.php.net/manual/en/class.intldateformatter.php>` _ sin tener que recordar sus valores.
Esto devolverá una versión localizada de la cadena con el formato (``Ymd H:i:s``):

.. literalinclude:: time/016.php

hastaCadenaFecha()
==================

Muestra solo la versión localizada de la parte de fecha de la Hora:

.. literalinclude:: time/017.php

aTimeString()
=============

Muestra solo la versión localizada de la porción de tiempo del valor:

.. literalinclude:: time/018.php

humanizar()
===========

Este método devuelve una cadena que muestra la diferencia entre la fecha/hora actual y la instancia en un
Formato legible por humanos que está orientado a ser fácilmente comprendido. Puede crear cadenas como 'hace 3 horas',
'en 1 mes', etc.:

.. literalinclude:: time/019.php

La hora exacta mostrada se determina de la siguiente manera:
=============================== ==================== ===============
Diferencia horaria Resultado
=============================== ==================== ===============
$tiempo > 1 año &amp;&amp; < 2 años en 1 año / Hace 1 año
$tiempo > 1 mes &amp;&amp; < 1 año en 6 meses / Hace 6 meses
$tiempo > 7 días &amp;&amp; < 1 mes en 3 semanas / Hace 3 semanas
$time > hoy &amp;&amp; < 7 días en 4 días / Hace 4 días
$hora == mañana / ayer Mañana / Ayer
$tiempo > 59 minutos &amp;&amp; < 1 día en 2 horas / Hace 2 horas
$time > ahora &amp;&amp; < 1 hora en 35 minutos / Hace 35 minutos
$tiempo == ahora Ahora
=============================== ==================== ===============

El idioma exacto utilizado se controla a través del archivo de idioma, **Time.php**.


Trabajar con valores individuales
*********************************

El objeto Time proporciona una serie de métodos que permiten obtener y configurar elementos individuales, como el año, mes, hora, etc.
de una instancia existente. Todos los valores recuperados a través de los siguientes métodos estarán completamente localizados y respetarán
la configuración regional con la que se creó la instancia de Time.

Todos los siguientes métodos ``getX()`` y ``setX()`` también se pueden utilizar como si fueran una propiedad de clase. Entonces, cualquier llamada a métodos
También se puede acceder a archivos como ``getYear()`` a través de ``$time->year``, y así sucesivamente.

captadores
==========

Existen los siguientes captadores básicos:

.. literalinclude:: time/020.php

Además de estos, existen varios métodos para proporcionar información adicional sobre la fecha:

.. literalinclude:: time/021.php

obtenerEdad()
--------

Devuelve la edad, en años, entre la instancia de Time y la hora actual. Perfecto para comprobar
la edad de alguien según su cumpleaños:

.. literalinclude:: time/022.php

obtenerDST()
--------

Devuelve un valor booleano verdadero/falso en función de si la instancia de Hora está observando actualmente el horario de verano:

.. literalinclude:: time/023.php

obtener local()
----------

Devuelve un valor booleano verdadero si la instancia de Time está en la misma zona horaria en la que se ejecuta actualmente la aplicación:

.. literalinclude:: time/024.php

obtenerUtc()
--------

Devuelve un valor booleano verdadero si la instancia de Hora está en hora UTC:

.. literalinclude:: time/025.php

obtener zona horaria()
-------------

Devuelve una nueva `DateTimeZone<https://www.php.net/manual/en/class.datetimezone.php>` __ objeto establece la zona horaria de la Hora
instancia:

.. literalinclude:: time/026.php

getTimezoneName()
-----------------

Devuelve la cadena `timezone completa<https://www.php.net/manual/en/timezones.php>` __ de la instancia de Tiempo:

.. literalinclude:: time/027.php

Colocadores
===========

Existen los siguientes configuradores básicos. Si alguno de los valores establecidos está fuera de rango, se generará una ``InvalidArgumentExeption``.
arrojado.

.. note:: All setters will return a new Time instance, leaving the original instance untouched.

.. note:: All setters will throw an InvalidArgumentException if the value is out of range.

.. literalinclude:: time/028.php

establecerzona horaria()
-------------

Convierte la hora de su zona horaria actual a la nueva:

.. literalinclude:: time/029.php

establecermarca de tiempo()
--------------

Devuelve una nueva instancia con la fecha establecida en la nueva marca de tiempo:

.. literalinclude:: time/030.php

Modificando el valor
====================

Los siguientes métodos le permiten modificar la fecha sumando o restando valores a la hora actual. esto no
modifica la instancia de Time existente, pero devolverá una nueva instancia.

.. literalinclude:: time/031.php

Comparando dos tiempos
======================

Los siguientes métodos le permiten comparar una instancia de Time con otra. Todas las comparaciones se convierten primero a UTC
antes de realizar comparaciones, para garantizar que las diferentes zonas horarias respondan correctamente.

es igual()
--------

Determina si la fecha y hora pasada es igual a la instancia actual. Iguales en este caso significa que representan la
mismo momento en el tiempo y no es necesario que estén en la misma zona horaria, ya que ambas horas se convierten a UTC y se comparan
de esa manera:

.. literalinclude:: time/032.php

El valor que se está probando puede ser una instancia de Time, una instancia de DateTime o una cadena con la fecha y hora completa en
de una manera que una nueva instancia de DateTime pueda entender. Al pasar una cadena como primer parámetro, puede pasar
una cadena de zona horaria como segundo parámetro. Si no se proporciona ninguna zona horaria, se utilizará la predeterminada del sistema:

.. literalinclude:: time/033.php

igual que()
--------

Esto es idéntico al método ``equals()``, excepto que solo devuelve verdadero cuando la fecha, la hora Y la zona horaria son iguales.
todos idénticos:

.. literalinclude:: time/034.php

es antes()
----------

Comprueba si el tiempo transcurrido es anterior a la instancia actual. La comparación se realiza con las versiones UTC de
ambas veces:

.. literalinclude:: time/035.php

El valor que se está probando puede ser una instancia de Time, una instancia de DateTime o una cadena con la fecha y hora completa en
de una manera que una nueva instancia de DateTime pueda entender. Al pasar una cadena como primer parámetro, puede pasar
una cadena de zona horaria como segundo parámetro. Si no se proporciona ninguna zona horaria, se utilizará la predeterminada del sistema:

.. literalinclude:: time/036.php

es despues()
---------

Funciona exactamente igual que ``isBefore()`` excepto que comprueba si el tiempo es posterior al tiempo transcurrido:

.. literalinclude:: time/037.php

Visualización de diferencias
============================

Para comparar dos tiempos directamente, usarías el método ``diferencia()``, que devuelve un ``Higgs\I18n\TimeDifference``
instancia. El primer parámetro es una instancia de Hora, una instancia de FechaHora o una cadena con la fecha/hora. Si
se pasa una cadena en el primer parámetro, el segundo parámetro puede ser una cadena de zona horaria:

.. literalinclude:: time/038.php

Una vez que tenga la instancia TimeDifference, tendrá varios métodos que puede utilizar para encontrar información sobre la diferencia.
entre los dos tiempos. El valor devuelto será negativo si fue en el pasado, o positivo si en el futuro de
la hora original:

.. literalinclude:: time/039.php

Puede utilizar los métodos ``getX()`` o acceder a los valores calculados como si fueran propiedades:

.. literalinclude:: time/040.php

humanizar()
----------

Al igual que el método ``humanize()`` de Time, esto devuelve una cadena que muestra la diferencia entre las horas en un
formato legible por humanos que está orientado a ser fácilmente comprendido. Puede crear cadenas como 'hace 3 horas',
'en 1 mes', etc. Las mayores diferencias están en cómo se manejan las fechas muy recientes:

.. literalinclude:: time/041.php

La hora exacta mostrada se determina de la siguiente manera:
=============================== ==================== ===============
Diferencia horaria Resultado
=============================== ==================== ===============
$tiempo > 1 año &amp;&amp; < 2 años en 1 año / Hace 1 año
$tiempo > 1 mes &amp;&amp; < 1 año en 6 meses / Hace 6 meses
$tiempo > 7 días &amp;&amp; < 1 mes en 3 semanas / Hace 3 semanas
$time > hoy &amp;&amp; < 7 días en 4 días / Hace 4 días
$tiempo > 1 hora &amp;&amp; < 1 día en 8 horas / Hace 8 horas
$tiempo > 1 minuto &amp;&amp; < 1 hora en 35 minutos / Hace 35 minutos
$tiempo < 1 minuto Ahora
=============================== ==================== ===============

El idioma exacto utilizado se controla a través del archivo de idioma, **Time.php**.
