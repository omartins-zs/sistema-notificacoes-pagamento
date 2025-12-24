import './bootstrap';
import 'flowbite';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Configuração do Toastr
toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    onclick: null,
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '5000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut'
};

// Torna toastr disponível globalmente para uso em scripts inline
window.toastr = toastr;
