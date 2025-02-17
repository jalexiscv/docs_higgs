###########################
Suplantación de método HTTP
###########################

Cuando trabaje con formularios HTML, solo puede utilizar verbos HTTP GET o POST. En la mayoría de los casos, esto está bien. Sin embargo, a
Para admitir el enrutamiento REST completo, necesita admitir otros verbos más correctos, como DELETE o PUT. Desde los navegadores
no admite esto, Higgs le proporciona una manera de falsificar el método que se está utilizando. Esto le permite
realice una solicitud POST, pero dígale a la aplicación que debe tratarse como un tipo de solicitud diferente.

Para falsificar el método, se agrega una entrada oculta al formulario con el nombre ``_method``. Su valor es el verbo HTTP.
que desea que la solicitud sea::

    <form action="" method="post">
        <input type="hidden" name="_method" value="PUT">
    </form>

Este formulario se convierte en una solicitud PUT y es una solicitud PUT verdadera en cuanto al enrutamiento y la solicitud entrante.
clase están preocupados.

El formulario que esté utilizando debe ser una solicitud POST. Las solicitudes GET no se pueden falsificar.

.. note:: Be sure to check your web server's configuration as some servers do not support all HTTP verbs
    con la configuración predeterminada y debe tener paquetes adicionales habilitados para funcionar.
