$(document).ready(function () {

    var opciones = [];
    var selects = {};

    $("#options button").on('click', function (event) {

        var target = $(this).data('target');
        var $element = $(target).find('.rango-seleccionado');
        var control;

        if (typeof selects[target] == 'undefined') {

            var $select = $element.selectize({
                maxItems: null,
                valueField: 'id',
                labelField: 'title',
                searchField: 'title',
                options: [],
                create: false
            });

            selects[target] = $select[0].selectize;
        }

        control = selects[target];

        control.clearOptions();
        for (var i = 0; i < opciones.length; i++) {
            control.addOption(opciones[i]);
            control.addItem(opciones[i].id);
        }
        control.refreshItems();

    });


    $("#fundo-region").selectable({
        stop: function () {

            opciones = [];
            $(".ui-selected", this).each(function (index, element) {
                var fila = $(element).data('fila');
                var columna = $(element).data('columna');
                var codigo = $(element).data('codigo');

                if (typeof  fila !== 'undefined' && typeof  columna !== 'undefined') {

                    opciones.push({
                        id: columna + '|' + fila,
                        title: codigo
                    })


                }


            });


        }
    });


    $('.form-accion').on('submit', function (event) {

        event.preventDefault();

        var request = $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serializeArray()
        });

        request.done(function (data) {
            alert("success");
        });

        request.fail(function () {
            alert("error");
        });

        request.always(function () {
            alert("complete");
        });


    });


    $(".datepicker").datepicker();
    $('select,.select').selectize({
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
});

