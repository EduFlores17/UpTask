!function(){function e(e,t,a){const n=document.querySelector(".alertas");n&&n.remove();const o=document.createElement("DIV");o.classList.add("alertas",t),o.textContent=e,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout((()=>{o.remove()}),5e3)}document.querySelector("#agregar-tarea").addEventListener("click",(function(){const t=document.createElement("DIV");t.classList.add("modal"),t.innerHTML='\n        <form class="formulario nueva-tarea">\n            <legend>Agrega una nueva tarea</legend>\n            <div class="campo">\n                <label>Tarea</label>\n                <input \n                    type="text"\n                    name="tarea"\n                    placeholder="añadir tarea al proyecto actual"\n                    id="tarea"\n                />\n            </div>\n\n            <div class="opciones"> \n                <input \n                    type="submit"\n                    class="submit-nueva-tarea"\n                    value="Añadir tarea"\n                />\n                <button type="button" class="cerrar-modal">Cancelar</button>\n            </div>\n        \n        </form>\n        \n\n        ',setTimeout((()=>{document.querySelector(".formulario").classList.add("animar")}),0),t.addEventListener("click",(function(a){if(a.preventDefault(),a.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout((()=>{t.remove()}),500)}a.target.classList.contains("submit-nueva-tarea")&&function(){const t=document.querySelector("#tarea").value.trim();if(""===t)return void e("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend"));!async function(t){const a=new FormData;a.append("nombre",t),a.append("proyecto_id",function(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}());try{const t="http://localhost:3000/api/tarea",n=await fetch(t,{method:"POST",body:a}),o=await n.json();if(console.log(o),e(o.mensaje,o.tipo,document.querySelector(".formulario legend")),"exito"===o.tipo){const e=document.querySelector(".modal");setTimeout((()=>{e.remove()}),3e3)}}catch(e){console.log(e)}}(t)}()})),document.querySelector(".dashboard").appendChild(t)}))}();