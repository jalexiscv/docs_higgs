############
Localización
############

.. contents::
    :local:
    :depth: 3


Trabajar con configuraciones regionales
***************************************

Higgs proporciona varias herramientas para ayudarle a localizar su aplicación en diferentes idiomas. mientras está lleno
La localización de una aplicación es un tema complejo, es sencillo intercambiar cadenas en su aplicación.
con diferentes idiomas soportados.

Las cadenas de idioma se almacenan en el directorio **app/Language**, con un subdirectorio para cada
idioma soportado::

    aplicación/
        Idioma/
            en/
                aplicación.php
            fr/
                aplicación.php

.. important:: Locale detection only works for web-based requests that use the IncomingRequest class.
    Las solicitudes de línea de comandos no tendrán estas características.

Configurar la configuración regional
====================================

.. _setting-the-default-locale:

Configuración de la configuración regional predeterminada
--------------------------

Cada sitio tendrá un idioma/localización predeterminado en el que operará. Esto se puede configurar en **app/Config/App.php**:

.. literalinclude:: localization/001.php

El valor puede ser cualquier cadena que utilice su aplicación para administrar cadenas de texto y otros formatos. Es
recomendó que un `BCP 47<http://www.rfc-editor.org/rfc/bcp/bcp47.txt>` _ se utiliza el código de idioma. Esto resulta en
códigos de idioma como en-US para inglés americano, o fr-FR, para francés/Francia. Una introducción más legible
a esto se puede encontrar en el sitio del `W3C<https://www.w3.org/International/articles/language-tags/>` _.

El sistema es lo suficientemente inteligente como para recurrir a códigos de idiomas más genéricos si hay una coincidencia exacta.
no pudo ser encontrado. Si el código local se configuró en ``en-US`` y solo tenemos archivos de idioma configurados para ``en``
entonces se usarán ya que no existe nada para el ``en-US`` más específico. Sin embargo, si una lengua
Si el directorio existiera en el directorio **app/Language/en-US**, entonces ese se usaría primero.

Detección de configuración regional
===================================

Se admiten dos métodos para detectar la configuración regional correcta durante la solicitud. El primero es "configurar y olvidar".
método que realizará automáticamente :doc:`negociación de contenido</incoming/content_negotiation>` para que usted
determinar la ubicación correcta a utilizar. El segundo método le permite especificar un segmento en sus rutas que
se utilizará para establecer la configuración regional.

Si alguna vez necesita configurar la configuración regional directamente, consulte `Configuración de la configuración regional actual`_.

Desde v7.4.0, se agregó ``IncomingRequest::setValidLocales()`` al conjunto
(y restablecer) las configuraciones regionales válidas que se configuran desde la configuración ``Config\App::$supportedLocales``.

Negociación de contenidos
-------------------

Puede configurar la negociación de contenido para que se realice automáticamente configurando dos configuraciones adicionales en **app/Config/App.php**.
El primer valor le dice a la clase Request que queremos negociar una configuración regional, así que simplemente configúrelo en verdadero:

.. literalinclude:: localization/002.php

Una vez habilitado, el sistema negociará automáticamente el idioma correcto basándose en una matriz
de configuraciones regionales que ha definido en ``$supportLocales``. Si no se encuentra ninguna coincidencia entre los idiomas
que admite y el idioma solicitado, se utilizará el primer elemento de ``$supportedLocales``. En
En el siguiente ejemplo, se utilizaría la configuración regional ``en`` si no se encuentra ninguna coincidencia:

.. literalinclude:: localization/003.php

.. _localization-in-routes:

En Rutas
---------

El segundo método utiliza un marcador de posición personalizado para detectar la configuración regional deseada y configurarla en la Solicitud. El
El marcador de posición ``{locale}`` se puede colocar como un segmento en su ruta. Si está presente, el contenido de la correspondencia
El segmento será su localidad:

.. literalinclude:: localization/004.php

En este ejemplo, si el usuario intentó visitar **http://example.com/fr/books**, entonces la configuración regional sería
establecido en ``fr``, asumiendo que fue configurado como una configuración regional válida.

Si el valor no coincide con una configuración regional válida como se define en ``$supportedLocales`` en **app/Config/App.php**, el valor predeterminado
La configuración regional se usará en su lugar, a menos que configure usar solo las configuraciones regionales admitidas definidas en la configuración de la aplicación.
archivo:

.. literalinclude:: localization/018.php

.. note:: The ``useSupportedLocalesOnly()`` method can be used since v7.3.0.

Configuración de la configuración regional actual
=================================================

Si desea configurar la configuración regional directamente, puede usar
``SolicitudEntrante::setLocale(string $locale)``.
Debes configurar las configuraciones regionales admitidas en **app/Config/App.php**:

.. literalinclude:: localization/003.php

.. note:: Any attempt to set a locale not included in this array will result in
    la :ref:`localización predeterminada<setting-the-default-locale>`  siendo configurado.

Recuperar la configuración regional actual
==========================================

La configuración regional actual siempre se puede recuperar desde el objeto IncomingRequest, a través del método ``getLocale()``.
Si su controlador extiende ``Higgs\Controller``, esto estará disponible a través de ``$this->request``:

.. literalinclude:: localization/005.php

Alternativamente, puede utilizar la clase :doc:`Services</concepts/services>` para recuperar la solicitud actual:

.. literalinclude:: localization/006.php


Localización de idiomas
***********************

Crear archivos de idioma
========================

.. note:: The Language Files do not have namespaces.

Los idiomas no tienen ninguna convención de nomenclatura específica que sea necesaria. El archivo debe tener un nombre lógico para
describir el tipo de contenido que contiene. Por ejemplo, digamos que desea crear un archivo que contenga mensajes de error.
Podrías nombrarlo simplemente: **Errors.php**.

Dentro del archivo, devolvería una matriz, donde cada elemento de la matriz tiene una clave de idioma y puede tener una cadena para devolver:

.. literalinclude:: localization/007.php

También admite definiciones anidadas:

.. literalinclude:: localization/008.php

.. literalinclude:: localization/009.php

Uso básico
==========

Puede utilizar la función auxiliar :php:func:`lang()` para recuperar texto de cualquiera de los archivos de idioma, pasando el
nombre de archivo y la clave de idioma como primer parámetro, separados por un punto (.). Por ejemplo, para cargar el
Cadena ``errorEmailMissing`` del archivo de idioma **Errors.php**, haría lo siguiente:

.. literalinclude:: localization/010.php

Para una definición anidada, haría lo siguiente:

.. literalinclude:: localization/011.php

Si la clave de idioma solicitada no existe en el archivo para la configuración regional actual, se pasará la cadena
atrás, sin cambios. En este ejemplo, devolvería 'Errors.errorEmailMissing' o 'Errors.nested.error.message' si no existiera.

Reemplazo de parámetros
--------------------

.. note:: The following functions all require the `intl <https://www.php.net/manual/en/book.intl.php>`_ extension to
    cargarse en su sistema para poder funcionar. Si la extensión no está cargada, no se intentará reemplazarla.
    Puede encontrar una excelente descripción general en `Sitepoint<https://www.sitepoint.com/localization-demystified-understanding-php-intl/>` _.

Puede pasar una matriz de valores para reemplazar marcadores de posición en la cadena de idioma como segundo parámetro del
Función ``lang()``. Esto permite traducciones y formatos de números muy simples:

.. literalinclude:: localization/012.php

El primer elemento del marcador de posición corresponde al índice del elemento de la matriz, si es numérico:

.. literalinclude:: localization/013.php

También puede usar claves con nombre para que sea más fácil mantener las cosas claras, si lo desea:

.. literalinclude:: localization/014.php

Obviamente, puedes hacer más que simplemente reemplazar números. De acuerdo con la
`Documentos oficiales de la UCI<https://unicode-org.github.io/icu-docs/apidoc/released/icu4c/classMessageFormat.html#details>` _ para el subyacente
biblioteca, se pueden reemplazar los siguientes tipos de datos:

* números: entero, moneda, porcentaje
* fechas: corta, media, larga, completa
* tiempo: corto, medio, largo, completo
* deletrear: deletrea los números (es decir, 34 se convierte en treinta y cuatro)
* ordinal
* duración

Aquí están algunos ejemplos:

.. literalinclude:: localization/015.php

Debe asegurarse de leer sobre la clase MessageFormatter y el formato ICU subyacente para obtener una mejor
idea sobre las capacidades que tiene, como realizar el reemplazo condicional, la pluralización y más. Ambos enlaces proporcionados.
anterior le dará una excelente idea de las opciones disponibles.

Especificación de configuración regional
-----------------

Para especificar una configuración regional diferente que se utilizará al reemplazar parámetros, puede pasar la configuración regional como
tercer parámetro de la función ``lang()``.

.. literalinclude:: localization/016.php

Matrices anidadas
-------------

Los archivos de idioma también permiten matrices anidadas para facilitar el trabajo con listas, etc.

.. literalinclude:: localization/017.php

Idioma alternativo
==================

Si tiene un conjunto de mensajes para una ubicación determinada, por ejemplo
**Idioma/en/app.php**, puedes agregar variantes de idioma para esa configuración regional,
cada uno en su propia carpeta, por ejemplo **Idioma/en-US/app.php**.

Sólo necesita proporcionar valores para aquellos mensajes que serían
localizado de forma diferente para esa variante local. Cualquier mensaje faltante
Las definiciones se extraerán automáticamente de la configuración regional principal.

Se pone mejor: la localización puede volver al inglés,
en caso de que se agreguen nuevos mensajes al marco y no haya tenido
una oportunidad de traducirlos todavía para su localidad.

Entonces, si estás usando la configuración regional ``fr-CA``, entonces un
El mensaje se buscará primero en el directorio **Language/fr-CA** y luego en
el directorio **Idioma/fr** y, finalmente, en el directorio **Idioma/en**.

Traducciones de mensajes
========================

Disponemos de un conjunto de traducciones "oficiales" en su
`propio repositorio<https://github.com/Higgs(AI)/translations>` _.

Puedes descargar ese repositorio y copiar su carpeta **Idioma**
en tu carpeta **aplicación**. Las traducciones incorporadas serán automáticamente
recogido porque el espacio de nombres ``App`` está asignado a su carpeta **app**.

Alternativamente, una mejor práctica sería ejecutar el siguiente comando dentro de su
proyecto:

.. code-block:: console

    el compositor requiere Higgs(AI)/traducciones

Los mensajes traducidos se seleccionarán automáticamente.
porque las carpetas de traducciones se asignan correctamente.
