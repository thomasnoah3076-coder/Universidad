// Confirmación reutilizable para formularios de borrado.
// El mensaje se guarda en data-confirm, así no hay JavaScript incrustado en las vistas.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-confirm]').forEach(function (formulario) {
        formulario.addEventListener('submit', function (evento) {
            if (!window.confirm(formulario.dataset.confirm)) {
                evento.preventDefault();
            }
        });
    });
});
