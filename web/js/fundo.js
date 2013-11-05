var opciones = [];


$(document).ready(function () {


    var bindAlert = function (element) {
        element = typeof element === 'undefined' ? 'body' : element;
        $('[data-alerts="alerts"]', element).each(function () {
            var alert = $(this);
            alert.bsAlerts(alert.data())
        })
    }

    var bindSelect = function (element) {

        element = typeof element === 'undefined' ? 'body' : element;

        $('select,.select', element).selectize({
            delimiter: ',',
            create: false,
            persist: false,
            create: function (input) {
                return {
                    value: input,
                    text: input
                }
            }
        });
    }

    var bindDatePicker = function (element) {
        element = typeof element === 'undefined' ? 'body' : element;
        $('.datepicker', element).datetimepicker({
            autoclose: true,
            todayBtn: true,
            language: "es",
            initialDate: new Date(),
            endDate: (new Date()),
            pickerPosition: "top-left"


        });
    }

    var bindSelectable = function () {
        $("#fundo-region").selectable({
            stop: function () {

                opciones = [];
                $(".ui-selected", this).each(function (index, element) {
                    var fila = $(element).data('fila');
                    var columna = $(element).data('columna');
                    var planta = $(element).data('planta');
                    var codigo = $(element).data('codigo');

                    if (typeof  fila !== 'undefined' && typeof  columna !== 'undefined') {

                        opciones.push({
                            id: planta || codigo,
                            title: codigo,
                            planta: planta,
                            codigo: codigo,
                        })


                    }


                });


            }
        });
    }


    $(document).on('submit', '.form-accion', function (event) {

        event.preventDefault();
        var $form = $(this);
        var $alert = $form.find('[data-alerts]');
        var $button = $form.find('button[type="submit"]');
        var currentValue = $button.text();
        $button.text('cargando...');

        var request = $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serializeArray()
        });

        request.done(function (data) {

            var $fundo = $("#fundo");
            $fundo.load($fundo.data('url'), bindSelectable);
            $alert.trigger('clear-alerts');

        });

        request.fail(function (data) {

        });

        request.always(function (data) {

            $button.text(currentValue);
            $alert.trigger('add-alerts', [
                {
                    message: data.message || 'Error Desconocido',
                    priority: data.status === 200 ? 'success' : 'danger'
                }
            ]);

        });


    });


    bindSelectable();
    bindSelect();
    bindDatePicker();

    $('#options').on('click', 'a', function (event) {

        $.fn.custombox({
            url: $(this).attr('href'),
            effect: 'fadein',
            complete: function (data) {


                var $modal = $('.custombox-modal-content');
                var $element = $modal.find('.rango-seleccionado');
                var tipo = $element.data('codigo');
                if (typeof $element === 'undefined') {
                    console.log('error');
                    return;
                }

                bindSelect($modal);
                bindAlert($modal);
                bindDatePicker($modal);
                var $alert = $modal.find('[data-alerts]');

                var $select = $element.selectize({
                    maxItems: null,
                    valueField: 'id',
                    labelField: 'title',
                    searchField: 'title',
                    options: [],
                    create: false
                });

                console.log($select);

                control = typeof $select[0] !== 'undefined' ? $select[0].selectize : undefined;


                if (typeof control === 'undefined') {
                    console.log('select no encontrado');
                    return;
                }

                if (tipo === 'codigo') {
                    control.clearOptions();
                }

                console.log(tipo);
                var estaOcupado = false;

                for (var i = 0; i < opciones.length; i++) {

                    var danger = false;
                    if (opciones[i].id !== opciones[i].codigo) {
                        danger = true;
                        estaOcupado = true;
                    }

                    if (tipo === 'planta') {

                        // siempre sera true, porque lo controlo desde un select precargado
                        estaOcupado = true;
                        control.addItem(opciones[i].planta);

                    } else if (tipo === 'codigo') {


                        control.addOption({
                            id: opciones[i].codigo,
                            title: opciones[i].title,
                            danger: danger
                        });
                        control.addItem(opciones[i].codigo);

                    } else {
                        control.addOption(opciones[i]);
                        control.addItem(opciones[i]);

                    }

                }
                control.refreshItems();

                if (tipo === 'codigo' && estaOcupado) {

                    console.log('codigo esta')
                    $alert.trigger('add-alerts', [
                        {
                            message: 'Existen posiciones ya ocupadas actualmente, si continua se registraran como removidas las posiciones donde hay plantas',
                            priority: 'warning'
                        }
                    ]);
                }else if (tipo === 'planta' && !estaOcupado) {
                    console.log('planta estaLibre')
                    /*$alert.trigger('add-alerts', [
                        {
                            message: 'Existen posiciones libres en las ubicaciones seleccionadas',
                            priority: 'warning'
                        }
                    ]);*/
                }



            },
            open: function () {
                console.log('open');
            },
            close: function () {
                console.log('close');
            }
        });

        event.preventDefault();

    });


    $(document).on('click.modal', '[rel="modal:close"]', function (event) {
        $.fn.custombox('close');
    });

    // $(".datepicker").datepicker();
});

