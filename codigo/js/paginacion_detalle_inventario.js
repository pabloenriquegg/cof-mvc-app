/**
 * Script pra la paginacion y configuaracion de la tabla inventaario utilizando DataTAbles para la tabla de DatalleInventario
 * 
 * Se encarga de inicializar DataTables con opciones de paginacion, búsqueda y ordenamiento
 * También verifica si la tabla ya está inicializada para evitar problemas de reinicializacioon
 * 
 * author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * since 2025-03-10
 */

document.addEventListener("DOMContentLoaded", function() {
    console.log("CARGANDO PAGINACIÓN PARA INVENTARIO...");

    /**
     * Obtiene el elemento de la tabla de inventario
     */
    let tablaElement = document.getElementById('tabla-inventario');

    if (tablaElement) {
        console.log("Tabla de inventario encontrada, inicializando DataTables...");

        /**
         * Si data tables ya está inicializado en la tabla, lo destruye antesd e volver a inciarlo
         */
        if ($.fn.DataTable.isDataTable("#tabla-inventario")) {
            console.log("Reiniciando DataTables...");
            $('#tabla-inventario').DataTable().destroy();
        }

        /**
         * Inicia DataTables con la configuracio deseada
         */
        let tabla = $('#tabla-inventario').DataTable({
            "paging": true, //Habilita la paginacion
            "lengthMenu": [5, 10, 15, 20, 30, 50], //Opciones de cantidad de filar por página
            "pageLength": 10, //número predeterminado de filar por página
            "searching": true, //habilita el buscador
            "ordering": true, //permite ordenar las columnas
            "info": true, //muestra info sobre la tabla
            "responsive": true, //diseño responsivo
            "scrollx": true, //desplacemiento lateral habilitado en moviles
            "autowidth": false, //evitar anchos incorrectos de las columnas
            "fixedHeader": true, //fija el encabezado de la tabla al hacer scroll
            /**
             * Configuracion del ordenamieto de columnas: por ean13, descripcion y fecha de caducidad y el resto no son ordenables
             */
            "columnDefs": [
                {"orderable": true, "targets": [1, 2, 4]}, // Ordenar por EAN y Descripción y fecha de caducidad
                {"orderable": false, "targets": "_all"} // Resto sin orden
            ],
            /**
             * Personalizacion de los textos en la interfaz de DataTables
             */
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrando de _MAX_ registros en total)",
                "search": "🔎 Filtrar:",
                "paginate": {
                    "first": "⏮ Primero",
                    "last": "⏭ Último",
                    "next": "➡ Siguiente",
                    "previous": "⬅ Anterior"
                }
            },
            /**
             * Configuracion del diseño de la tabla
             * - 'l' Selector de cantidad de registros por pagina
             * - 'p' Controles de paginacion
             * - 'f' campo busqueda
             * - 'i' info sobre registros mostrados
             */
            "dom": '<"top"l><"top"p>rt<"bottom"f><"bottom"i><"clear">'
        });

        console.log("DataTables inicializado correctamente.");
    } else {
        console.warn("ERROR: Tabla de inventario no encontrada. No se pudo inicializar DataTables.");
    }
})