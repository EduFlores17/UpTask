(function(){
    //boton para mostrar el modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario(){
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form class="formulario nueva-tarea">
            <legend>Agrega una nueva tarea</legend>
            <div class="campo">
                <label>Tarea</label>
                <input 
                    type="text"
                    name="tarea"
                    placeholder="añadir tarea al proyecto actual"
                    id="tarea"
                />
            </div>

            <div class="opciones"> 
                <input 
                    type="submit"
                    class="submit-nueva-tarea"
                    value="Añadir tarea"
                />
                <button type="button" class="cerrar-modal">Cancelar</button>
            </div>
        
        </form>
        

        `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);


        modal.addEventListener('click', function(e){
            e.preventDefault();

            if(e.target.classList.contains('cerrar-modal')){

            const formulario = document.querySelector('.formulario');
            formulario.classList.add('cerrar');

                setTimeout(() => {
                    modal.remove();
                }, 500);
                
            }
            if(e.target.classList.contains('submit-nueva-tarea')){
                submitFormularioNuevaTarea();
            }
        })
        
        document.querySelector('.dashboard').appendChild(modal);
    }

    function submitFormularioNuevaTarea(){
        const tarea = document.querySelector('#tarea').value.trim();
        if(tarea === ''){
            //mostrar alerta de error
            mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'))
            return;
        }

        agregarTarea(tarea);
    }

    //muestra un mensaje en la interfaz
    function mostrarAlerta(mensaje, tipo, referencia){
        //previene la creacion de multiples alertas
        const alertaPrevia = document.querySelector('.alertas');
        if(alertaPrevia){
            alertaPrevia.remove();
        }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alertas', tipo);
        alerta.textContent = mensaje;
        //referencia.appendChild(alerta);

        //iserta la alerta antes del legend
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);


        //eliminar la alerta despues de 5 segundos
        setTimeout(() => {
            alerta.remove();
        }, 5000);

    }

    //consultar el servidor para añadir una nueva tarea al proyecto
    async function agregarTarea(tarea){
        //construir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyecto_id', obtenerProyecto());

        

    
        try {
            const url = 'http://localhost:3000/api/tarea'
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            console.log(resultado);
            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'))

            if(resultado.tipo === 'exito'){
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 3000);
            }


        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto(){
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

})();