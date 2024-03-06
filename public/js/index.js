$(document).ready(function() {
    // Acciones cuando se hace clic en los botones de idioma
    $('#spanish').click(function() {
        $('html').attr('lang', 'es');
    });

    $('#english').click(function() {
        $('html').attr('lang', 'en');
    });

    $('#german').click(function() {
        $('html').attr('lang', 'de');
    });
});
