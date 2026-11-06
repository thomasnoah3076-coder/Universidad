/**
 * Inicialización global de Select2.
 *
 * Activa Select2 con limpieza (allowClear) sobre los selects que usa el
 * proyecto. Solo se inicializan los elementos que existan en la página.
 *
 * Requiere que jQuery y Select2 ya estén cargados.
 */
(function ($) {
    'use strict';

    var selectors = [
        '#estudiantes',
        '#clubes',
        '#pais',
        '#departamento',
        '#ciudad',
        '#tipodocumento',
        '#sino',
        '#estrategia',
        '#semestre',
        '#persona',
        '#tipoparticipante',
        '#tipoactividad',
        '#actividad',
        '#lugar',
        '#anio_semestre',
        '#claseactividad',
        '#personaexterna',
        '#areaextension',
        '#tienecosto',
        '#areatrabajo',
        '#ciclovital',
        '#entidadnacional',
        '#fuentenacional',
        '#fuenteinternacional',
        '#poblacioncondicion',
        '#poblaciongrupo',
        '#poblacionimpactada',
        '#universidad',
        '#programaacademico',
        '#convenio',
        '#tipomovilidad',
        '#tipopersona',
        '#personaentrantemovilidad',
        '#modalidad',
        '#clasemovilidad',
        '#ambito',
        '#tipoformacioncomplementaria',
        '#tipoformacionposgrado',
        '#egresado',
        '#estadogrado',
        '#paisnacimiento',
        '#paisexpedicion',
        '#paisresidencia',
        '#departamentonacimiento',
        '#departamentoexpedicion',
        '#departamentoresidencia',
        '#ciudadnacimiento',
        '#ciudadexpedicion',
        '#ciudadresidencia',
        '#tipocontrato',
        '#nivelsalarial',
        '#areaprofesional',
        '#empresa',
        '#trabaja',
        '#estudia',
        '#sector',
    ];

    $(function () {
        if (!$.fn.select2) {
            return;
        }

        $.each(selectors, function (_, selector) {
            var $element = $(selector);

            if ($element.length) {
                $element.select2({
                    allowClear: true,
                    width: '100%',
                });
            }
        });
    });
})(jQuery);
