/**
 * Script pra la paginacion y configuaracion de la tabla inventaario utilizando DataTAbles para la tabla de Inventario
 * 
 * Se encarga de inicializar DataTables con opciones de paginacion, búsqueda y ordenamiento
 * También verifica si la tabla ya está inicializada para evitar problemas de reinicializacioon
 * 
 * author Pablo Enrique Guntín Garrido <pabloenriqueguntin@icloud.com>
 * since 2025-03-10
 */
document.addEventListener("DOMContentLoaded", function(){
    console.log("CARGANDO PAGINACIÓN.JS.......");

     /**
     * Obtiene el elemento de la tabla de inventario
     */
    let tablaElement = document.getElementById('tabla-resultados');
    
    if (tablaElement) { 
        console.log("Tabla encontrada, incializando DATATABLES.....");

            /**
         * Si data tables ya está inicializado en la tabla, lo destruye antesd e volver a inciarlo
         */
        if ($.fn.DataTable.isDataTable("#tabla-resultados")){
            console.log("Reiniciando data tables")
            $('#tabla-resultados').DataTable().destroy();
        }
         /**
         * Inicia DataTables con la configuracio deseada
         */
        let tabla = $('#tabla-resultados').DataTable({
            "paging": true, //habilita la paginacion
            "lengthMenu": [5, 10, 15, 20, 30, 50], // Opciones para seleccionar
            "pageLength": 10, // Cantidad predeterminada
            "searching": true, // Habilita búsqueda
            "ordering": true, // Ordenar columnas
            "info": true, //muestra info de la tabla
            /**
             * Configuracion del ordenamieto de columnas. el resto no son ordenables
             */
            "columnDefs": [
                
                {"orderable": true, "targets": [0, 1]}, // Ordenar solo columnas específicas
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
                "search": "🔎 Filtrar por registros:",
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
            "dom": '<"top"l><"top"p>rt<"bottom"f><"bottom"i><"clear">' // Controlar la posición de los elementos
        });

        // Capturar el cambio de selector de cantidad de registros por página
        let selector = document.getElementById('registrosPorPagina');
        if (selector) {
            selector.addEventListener('change', function(){
                let cantidad = parseInt(this.value);
                tabla.page.len(cantidad).draw();
            });
        }
        console.log("Data tables inicializados correctamente");
    } else {
        console.warn("ERROR: Tabla vacía: DataTables no se ha inicializado.");
    }
});
