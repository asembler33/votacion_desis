$(document).ready(function() {

        /* * *
         * * * * Carga select candidatos * * * * * * * * * *
        * */

        $.ajax({
            url: '../api/ruta.php?ruta=candidatos',  
            type: 'GET',         
            dataType: 'json',      
            success: function (data) {
                
                // $('#contenido').html('<p>Nombre: ' + data.nombre + '</p><p>Edad: ' + data.edad + '</p>');
                data.forEach(element => {
                    $('#slcCandidato').append('<option value="' + element.id + '">' + element.nombre_candidato + '</option>')
                });
            },
            error: function (error) {
                // La función que se ejecutará si hay un error en la solicitud
                console.error('Error en la solicitud AJAX:', error);
            }
        });

        /* * *
         * * * * Carga select regiones * * * * * * * * * *
        * */

        $.ajax({
            url: '../api/ruta.php?ruta=regiones',  
            type: 'GET',         
            dataType: 'json',      
            success: function (data) {
                
                data.forEach(element => {
                    $('#slcRegion').append('<option value="' + element.id + '">' + element.region + '</option>')
                });
            },
            error: function (error) {
                // La función que se ejecutará si hay un error en la solicitud
                console.error('Error en la solicitud AJAX:', error);
            }
        });

        /* * *
         * * * * Carga select medios informativos * * * * * * * * * *
        * */

        $.ajax({
            url: '../api/ruta.php?ruta=medios_informativos',  
            type: 'GET',         
            dataType: 'json',      
            success: function (data) {
                
                data.forEach(element => {
                    $('.radio-group').append(`<input type="checkbox" id="${element.tipo_medio_informativo}" name="optInformacion[]" value="${element.id}" required>
                    <label for="web">${element.tipo_medio_informativo}</label>`)
                });
            },
            error: function (error) {
                // La función que se ejecutará si hay un error en la solicitud
                console.error('Error en la solicitud AJAX:', error);
            }
        });

        /* * *
         * * * * Carga select comunas según región elegida * * * * * * * * * *
        * */

        $('#slcRegion').change(function() { 
            
            let idRegion = $(this).val();

            $.ajax({
                url: '../api/ruta.php?ruta=comunas&idRegion='+idRegion,  
                type: 'GET',         
                dataType: 'json',      
                success: function (data) {
                    
                    $('#slcComuna').empty();
                    data.forEach(element => {
                        $('#slcComuna').append('<option value="' + element.id + '">' + element.comuna + '</option>')
                    });
                },
                error: function (error) {
                    // La función que se ejecutará si hay un error en la solicitud
                    console.error('Error en la solicitud AJAX para regiones:', error);
                }
            });
        });


        /* * *
         * * * * Validación según expresión regular para RUT chileno * * * * * * * * * *
        * */

        $.validator.addMethod("rutChileno", function (value, element) {
            // La expresión regular para el RUT chileno permite dígito verificador 0-9 o K
            return this.optional(element) || /^[0-9]{1,2}.[0-9]{3}.[0-9]{3}[-][0-9Kk]{1}$/.test(value);
        }, "Por favor, ingresa un RUT chileno válido");

        /* * *
         * * * * Validación de formulario * * * * * * * * * *
        * */

        $("#formVotacion").validate({
            rules: {
                nombreApellido: "required",
                alias: {
                    required: true,
                    minlength: 5
                },
                rut: {
                    required: true,
                    remote:{
                        url: '../api/ruta.php?ruta=validarRUT',
                        type: "get",
                        data: {
                            edit: false,
                            rut: function() {
                                return $("#rut").val(); 
                            }
                        }
                    },
                    rutChileno: true,
                },
                slcRegion:{
                    required: function(element) {
                        return $(element).val() == ""; 
                    }
                },
                slcComuna: "required",
                slcCandidato: "required",
                email: {
                    required: true,
                    email: true
                },
                optInformacion:{
                    required: true,
                    minlength: 2,
                }
            },
            messages: {
                nombre: "Por favor, ingresa tu nombre y apellido",
                alias: {
                    required: "Por favor, ingresa tu alias",
                    minlength: "La cantidad de caracteres debe ser superior a cinco"
                },
                rut: {
                    required: "Por favor, ingresa un RUT chileno",
                    rutChileno: "Por favor, ingresa un RUT chileno válido con puntos y dígito verificador",
                    remote: "Este RUT ya está en uso"
                },
                slcRegion: "Por favor, selecciona tu región",
                slcComuna: "Por favor, selecciona tu comuna",
                slcCandidato: "Por favor, selecciona el candidato",
                email: {
                    required: "Por favor, ingresa tu correo electrónico",
                    email: "Por favor, ingresa un correo electrónico válido"
                },
                optInformacion: "Selecciona al menos dos opciones"
            },
            submitHandler: function (form) {

                $.ajax({
                    url: '../api/ruta.php',
                    data:  $(form).serialize(),
                    type: 'POST',         
                    dataType: 'html',      
                    success: function (response) {
                        
                        alert("Datos guardados");
                        document.getElementById('formVotacion').reset();
                        document.getElementById('slcComuna').innerHTML = '<option value="">[Seleccione comuna ...]</option>';
                    },
                    error: function (error) {
                        // La función que se ejecutará si hay un error en la solicitud
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
                
            }
        });

        
});