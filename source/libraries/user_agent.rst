##########################
Clase de agente de usuario
##########################

La clase de agente de usuario proporciona funciones que ayudan a identificar información.
sobre el navegador, dispositivo móvil o robot que visita su sitio.

.. contents::
    :local:
    :depth: 2


Usando la clase de agente de usuario
************************************

Inicializando la clase
======================

La clase Agente de usuario siempre está disponible directamente desde el :doc:`IncomingRequest actual</incoming/incomingrequest>` instancia.
De forma predeterminada, tendrá una instancia de solicitud en su controlador que puede recuperar
Clase de agente de usuario de:

.. literalinclude:: user_agent/001.php

Definiciones de agentes de usuario
==================================

Las definiciones de los nombres del agente de usuario se encuentran en un archivo de configuración ubicado en:

**aplicación/Config/UserAgents.php**. Puede agregar elementos a los distintos
matrices de agentes de usuario si es necesario.

Ejemplo
=======

Cuando se inicializa la clase Agente de usuario, intentará determinar
si el agente de usuario que navega por su sitio es un navegador web, un dispositivo móvil
dispositivo o un robot. También recopilará la información de la plataforma si
está disponible:

.. literalinclude:: user_agent/002.php


Referencia de clase
*******************

.. php:namespace:: Higgs\HTTP

.. php:class:: UserAgent

    .. php:method:: isBrowser([$key = null])

        :param  string $key: nombre del navegador opcional
        :returns: verdadero si el agente de usuario es un navegador (especificado), falso en caso contrario
        :rtype: booleano

        Devuelve verdadero/falso (booleano) si el agente de usuario es un navegador web conocido.

        .. literalinclude:: user_agent/003.php

        .. note:: The string "Safari" in this example is an array key in the list of browser definitions.
                  Puede encontrar esta lista en **app/Config/UserAgents.php** si desea agregar nuevos
                  navegadores o cambiar las cadenas.

    .. php:method:: isMobile([$key = null])

        :param  string $key: nombre de dispositivo móvil opcional
        :returns: verdadero si el agente de usuario es un dispositivo móvil (especificado), falso en caso contrario
        :rtype: booleano

        Devuelve verdadero/falso (booleano) si el agente de usuario es un dispositivo móvil conocido.

        .. literalinclude:: user_agent/004.php

    .. php:method:: isRobot([$key = null])

        :param  string $key: nombre de robot opcional
        :returns: verdadero si el agente de usuario es un robot (especificado), falso si no
        :rtype: booleano

        Devuelve verdadero/falso (booleano) si el agente de usuario es un robot conocido.

        .. note:: The user agent library only contains the most common robot definitions. It is not a complete list of bots.
                  Hay cientos de ellos, por lo que buscar cada uno de ellos no sería muy eficaz. Si encuentras que algunos bots
                  que visitan habitualmente su sitio no están en la lista, puede agregarlos a su
                  **archivo app/Config/UserAgents.php**.

    .. php:method:: isReferral()

        :returns: verdadero si el agente de usuario es una referencia, falso si no
        :rtype: booleano

        Devuelve verdadero/falso (booleano) si el agente de usuario fue remitido desde otro sitio.

    .. php:method:: getBrowser()

        :returns: navegador detectado o una cadena vacía
        :rtype: cadena

        Devuelve una cadena que contiene el nombre del navegador web que visualiza su sitio.

    .. php:method:: getVersion()

        :returns: versión del navegador detectada o una cadena vacía
        :rtype: cadena

        Devuelve una cadena que contiene el número de versión del navegador web que visualiza su sitio.

    .. php:method:: getMobile()

        :vuelve: Marca de dispositivo móvil detectada o una cadena vacía
        :rtype: cadena

        Devuelve una cadena que contiene el nombre del dispositivo móvil que visualiza su sitio.

    .. php:method:: getRobot()

        :devuelve: nombre del robot detectado o una cadena vacía
        :rtype: cadena

        Devuelve una cadena que contiene el nombre del robot que visita su sitio.

    .. php:method:: getPlatform()

        :devuelve: Sistema operativo detectado o una cadena vacía
        :rtype: cadena

        Devuelve una cadena que contiene la plataforma que visualiza su sitio (Linux, Windows, OS X, etc.).

    .. php:method:: getReferrer()

        :returns: referente detectado o una cadena vacía
        :rtype: cadena

        El referente, si el agente de usuario fue referido desde otro sitio. Normalmente, probará esto de la siguiente manera:

        .. literalinclude:: user_agent/005.php

    .. php:method:: getAgentString()

        :returns: cadena de agente de usuario completa o una cadena vacía
        :rtype: cadena

        Devuelve una cadena que contiene la cadena completa del agente de usuario. Normalmente será algo como esto::

            Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.0.4) Gecko/20060613 Camino/1.0.2

    .. php:method:: parse($string)

        :param string $string: una cadena de agente de usuario personalizada
        :rtype: nulo

        Analiza una cadena de agente de usuario personalizada, diferente de la informada por el visitante actual.
