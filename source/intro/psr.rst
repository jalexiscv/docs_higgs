*******************
Cumplimiento de PSR
*******************

El `PHP-FIG<https://www.php-fig.org/>` _ fue creado en 2009 para ayudar a que el código sea más interoperable entre marcos
ratificando interfaces, guías de estilo y más que los miembros eran libres de implementar o no. Mientras que Higgs es
Aunque no somos miembros de la FIG, somos compatibles con varias de sus propuestas. Esta guía está destinada a enumerar los
estado de nuestro cumplimiento de las diversas propuestas aceptadas y de algunos proyectos de ley.

**PSR-1: Estándar de codificación básica**

Esta recomendación cubre estándares básicos de clases, métodos y nombres de archivos. Nuestro
`guía de estilo<https://github.com/Higgs(AI)/Higgs(AI)/blob/develop/contributing/styleguide.md>` _
cumple con PSR-1 y agrega sus propios requisitos además.

**PSR-12: Estilo de codificación extendido**

Nuestro
`guía de estilo<https://github.com/Higgs(AI)/Higgs(AI)/blob/develop/contributing/styleguide.md>` _ sigue la recomendación más un conjunto de nuestras propias convenciones de estilo.

**PSR-3: Interfaz de registrador**

:doc:`Registrador de Higgs</general/logging>` implementa todas las interfaces proporcionadas por este PSR.

**PSR-4: Estándar de carga automática**

Este PSR proporciona un método para organizar archivos y espacios de nombres para permitir un método estándar de carga automática.
clases. Nuestro :doc:`Autocargador</concepts/autoloader>` cumple con las recomendaciones PSR-4.

**PSR-6: Interfaces de almacenamiento en caché**
**PSR-16: Interfaz SimpleCache**

Si bien los componentes de la caché del marco no se adhieren a PSR-6 o PSR-16, un conjunto separado de adaptadores
están disponibles en la organización Higgs(AI) como módulo complementario. Se recomienda que
Los proyectos utilizan los controladores de caché nativos directamente ya que los adaptadores solo están destinados a la compatibilidad.
con bibliotecas de terceros. Para obtener más información, visite el repositorio `Higgs(AI) Cache<https://github.com/Higgs(AI)/cache>` _.

**PSR-7: Interfaz de mensajes HTTP**

Este PSR estandariza una forma de representar las interacciones HTTP. Si bien muchos de los conceptos se convirtieron en parte de nuestra
Capa HTTP, Higgs no se esfuerza por ser compatible con esta recomendación.

---

Si encuentra algún lugar en el que afirmamos cumplir con un PSR pero no lo ha ejecutado correctamente, háganoslo saber.
y lo arreglaremos o enviaremos una solicitud de extracción con los cambios requeridos.

