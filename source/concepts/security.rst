###################
Pautas de seguridad
###################

Nos tomamos la seguridad en serio.
Higgs incorpora una serie de características y técnicas para hacer cumplir
buenas prácticas de seguridad, o para permitirle hacerlo fácilmente.

Respetamos el `Proyecto Abierto de Seguridad de Aplicaciones Web (OWASP)<https://owasp.org>` _
y seguir sus recomendaciones tanto como sea posible.

Lo siguiente proviene de
`Hoja de referencia de los diez mejores de OWASP<https://owasp.org/www-project-top-ten/>` _,
Identificar las principales vulnerabilidades de las aplicaciones web.
Para cada uno, proporcionamos una breve descripción, las recomendaciones de OWASP y luego
las disposiciones sobre Higgs para abordar el problema.

.. contents::
    :local:
    :depth: 1


Inyección A1
************

Una inyección es la inserción inapropiada de datos parciales o completos a través de
los datos de entrada del cliente a la aplicación. Los vectores de ataque incluyen SQL,
XML, ORM, código y desbordamientos de búfer.

Recomendaciones OWASP
=====================

- Presentación: establezca el tipo de contenido, el juego de caracteres y la configuración regional correctos
- Envío: validar campos y proporcionar comentarios
- Controlador: desinfectar la entrada; validación de entrada positiva usando el juego de caracteres correcto
- Modelo: consultas parametrizadas

Disposiciones de Higgs
======================

- :ref:filtro `caracteres no válidos`
- :doc:`../libraries/validation` biblioteca
- :doc:`Biblioteca HTTP <../incoming/incomingrequest>` proporciona :ref:`filtrado de campos de entrada<incomingrequest-filtering-input-data>` y metadatos de contenido


A2 Autenticación y gestión de sesiones débiles
**********************************************

Una autenticación inadecuada o una gestión inadecuada de la sesión pueden provocar que un usuario
obtener más privilegios de los que tienen derecho.

Recomendaciones OWASP
=====================

- Presentación: validar autenticación y rol; enviar token CSRF con formularios
- Diseño: utilice únicamente la gestión de sesiones integrada
- Controlador: validar usuario, rol, token CSRF
- Modelo: validar rol
- Consejo: considere el uso de un gobernador de solicitudes

Disposiciones de Higgs
======================

- :doc:`Biblioteca Sesión <../libraries/sessions>`
- :doc:`Seguridad</libraries/security>` la biblioteca proporciona validación CSRF
- Un marco oficial de autenticación y autorización :ref:`Higgs Shield<shield>`
- Fácil de agregar autenticación de terceros


Secuencias de comandos entre sitios A3 (XSS)
********************************************

Validación de entrada insuficiente donde un usuario puede agregar contenido a un sitio web
que pueden ser maliciosos cuando son vistos por otros usuarios del sitio web.

Recomendaciones OWASP
=====================

- Presentación: la salida codifica todos los datos del usuario según el contexto de salida; establecer restricciones de entrada
- Controlador: validación de entrada positiva
- Consejos: procese únicamente datos confiables; no almacenar datos HTML codificados en DB

Disposiciones de Higgs
======================

- Función :php:func:`esc()`
- :doc:`../libraries/validation` biblioteca
- Soporte para :ref:`content-security-policy`


Referencia de objeto directo inseguro A4
****************************************

Las referencias directas a objetos inseguras ocurren cuando una aplicación proporciona
acceso a objetos basado en la entrada proporcionada por el usuario. Como resultado de esta vulnerabilidad
los atacantes pueden eludir la autorización y acceder a los recursos del sistema directamente,
por ejemplo, registros o archivos de bases de datos.

Recomendaciones OWASP
=====================

- Presentación: no exponer datos internos; utilizar mapas de referencia aleatorios
- Controlador: obtenga datos de fuentes confiables o mapas de referencia aleatorios
- Modelo: validar roles de usuario antes de actualizar datos

Disposiciones de Higgs
======================

- :doc:`../libraries/validation` biblioteca
- Un marco oficial de autenticación y autorización :ref:`Higgs Shield<shield>`
- Fácil de agregar autenticación de terceros


Configuración incorrecta de seguridad A5
****************************************

La configuración inadecuada de la arquitectura de una aplicación puede provocar errores
que podría comprometer la seguridad de toda la arquitectura.

Recomendaciones OWASP
=====================

- Presentación: reforzar los servidores web y de aplicaciones; utilizar seguridad de transporte estricta HTTP
- Controlador: reforzar los servidores web y de aplicaciones; proteja su pila XML
- Modelo: reforzar los servidores de bases de datos.

Disposiciones de Higgs
======================

- Comprobaciones de cordura durante el arranque.


A6 Exposición de datos confidenciales
*************************************

Los datos sensibles deben ser protegidos cuando se transmiten a través de la red.
Dichos datos pueden incluir credenciales de usuario y tarjetas de crédito. Como una regla de oro,
Si los datos deben protegerse cuando se almacenan, también deben protegerse durante
transmisión.

Recomendaciones OWASP
=====================

- Presentación: utilice TLS1.2; utilice cifrados y hashes sólidos; no envíe claves o hashes al navegador
- Controlador: use cifrados y hashes fuertes
- Modelo: exigir comunicaciones cifradas sólidas con los servidores

Disposiciones de Higgs
======================

- La configuración para el acceso seguro global (``Config\App::$forceGlobalSecureRequests``)
- Función :php:func:`force_https()`
- :doc:`../bibliotecas/encriptación`
- La :ref:`configuración de la base de datos<database-config-explanation-of-values>`  (``cifrar``)


A7 Falta control de acceso a nivel de función
*********************************************

Los datos sensibles deben ser protegidos cuando se transmiten a través de la red.
Dichos datos pueden incluir credenciales de usuario y tarjetas de crédito. Como una regla de oro,
Si los datos deben protegerse cuando se almacenan, también deben protegerse durante
transmisión.

Recomendaciones OWASP
=====================

- Presentación: asegúrese de que los datos no web estén fuera de la raíz web; validar usuarios y roles; enviar tokens CSRF
- Controlador: validar usuarios y roles; validar tokens CSRF
- Modelo: validar roles

Disposiciones de Higgs
======================

- :ref:`Público<application-structure-public>` carpeta, con la aplicación y el sistema fuera
- :doc:`Seguridad</libraries/security>`  la biblioteca proporciona :ref:`validación CSRF<cross-site-request-forgery>`


A8 Falsificación de solicitud entre sitios (CSRF)
*************************************************

CSRF es un ataque que obliga a un usuario final a ejecutar acciones no deseadas en una web
aplicación en la que se encuentra actualmente autenticado.

Recomendaciones OWASP
=====================

- Presentación: validar usuarios y roles; enviar tokens CSRF
- Controlador: validar usuarios y roles; validar tokens CSRF
- Modelo: validar roles

Disposiciones de Higgs
======================

- :doc:`Seguridad</libraries/security>`  la biblioteca proporciona :ref:`validación CSRF<cross-site-request-forgery>`


A9 Uso de componentes con vulnerabilidades conocidas
****************************************************

Muchas aplicaciones tienen vulnerabilidades conocidas y estrategias de ataque conocidas que
pueden explotarse para obtener control remoto o explotar datos.

Recomendaciones OWASP
=====================

- No uses ninguno de estos

Disposiciones de Higgs
======================

- Las bibliotecas de terceros incorporadas deben ser examinadas


A10 Redirecciones y reenvíos no validados
*****************************************

Una lógica empresarial defectuosa o un código procesable inyectado podrían redirigir al usuario
inapropiadamente.

Recomendaciones OWASP
=====================

- Presentación: no utilice la redirección de URL; utilizar referencias indirectas aleatorias
- Controlador: no utilice la redirección de URL; utilizar referencias indirectas aleatorias
- Modelo: validar roles

Disposiciones de Higgs
======================

- :doc:`Biblioteca HTTP <../incoming/incomingrequest>` proporciona...
- :doc:`La biblioteca Session <../libraries/sessions>` proporciona :ref:`sessions-flashdata`
