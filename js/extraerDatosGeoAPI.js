document.addEventListener("DOMContentLoaded", function () {
    const comunidadSelect = document.getElementById("comunidad");
    const provinciaSelect = document.getElementById("provincia");
    const municipioSelect = document.getElementById("municipio");
    const poblacionSelect = document.getElementById("poblacion");
    const nucleoSelect = document.getElementById("nucleo");
    const codigoPostalSelect = document.getElementById("codigoPostal");
    const calleSelect = document.getElementById("calle");
    const direccionInput = document.getElementById("direccion");

    const API_KEY = "11375f1150e290f6c7ca7681f7166589a1b0340cae30b6dda19b22b1554698ea";
    const SANDBOX = 0;

    // Objeto para almacenar los códigos de cada nivel
    let codigosSeleccionados = {
        comunidad: {},
        provincia: {},
        municipio: {},
        poblacion: {},
        nucleo: {},
        codigoPostal: {},
        calle: {}
    };

    async function obtenerDatos(url) {
        try {
            let response = await fetch(url);
            let data = await response.json();
            return data.data || [];
        } catch (error) {
            console.error("Error al obtener datos:", error);
            return [];
        }
    }

    function limpiarSelect(...selects) {
        selects.forEach(select => {
            select.innerHTML = '<option value="">Selecciona una opción</option>';
            select.disabled = true;
        });
        direccionInput.disabled = true;
        direccionInput.value = "";
    }

    function capitalizarTexto(texto) {
        texto = texto.replace(/\*/g, ''); // Eliminar asteriscos
    
        const minusculas = ["de", "del", "y", "la", "el", "las", "los"];
        
        let palabras = texto.toLowerCase().split(/(\s+|\(|\)|\-)/);
    
        let resultado = palabras.map((palabra, index) => {
            
            // Siempre capitalizar primera palabra o después de ( o -
            if (index === 0 || palabras[index - 1] === "(" || palabras[index - 1] === "-") {
                return palabra.charAt(0).toUpperCase() + palabra.slice(1);
            }
    
            // Si está en lista de palabras en minúscula
            if (minusculas.includes(palabra)) {
                return palabra;
            }
    
            // Si no es espacio, guion o paréntesis -> Capitalizar
            if (![" ", "(", ")", "-"].includes(palabra)) {
                return palabra.charAt(0).toUpperCase() + palabra.slice(1);
            }
    
            return palabra;
        });
    
        return resultado.join('');
    }
    
    

    // Cargar comunidades autónomas
    obtenerDatos(`https://apiv1.geoapi.es/comunidades?type=JSON&key=${API_KEY}&sandbox=${SANDBOX}`)
        .then(comunidades => {
            comunidades.forEach(comunidad => {
                let nombre = capitalizarTexto(comunidad.COM);
                codigosSeleccionados.comunidad[nombre] = comunidad.CCOM;

                let option = document.createElement("option");
                option.value = nombre;
                option.textContent = nombre;
                comunidadSelect.appendChild(option);
            });
        });

    comunidadSelect.addEventListener("change", function () {
        let comunidadNombre = this.value;
        let comunidadId = codigosSeleccionados.comunidad[comunidadNombre];

        limpiarSelect(provinciaSelect, municipioSelect, poblacionSelect, nucleoSelect, codigoPostalSelect, calleSelect);

        if (comunidadId) {
            obtenerDatos(`https://apiv1.geoapi.es/provincias?CCOM=${comunidadId}&type=JSON&key=${API_KEY}&sandbox=${SANDBOX}`)
                .then(provincias => {
                    provincias.forEach(provincia => {
                        let nombre = capitalizarTexto(provincia.PRO);
                        codigosSeleccionados.provincia[nombre] = provincia.CPRO;

                        let option = document.createElement("option");
                        option.value = nombre;
                        option.textContent = nombre;
                        provinciaSelect.appendChild(option);
                    });
                    provinciaSelect.disabled = false;
                });
        }
    });

    provinciaSelect.addEventListener("change", function () {
        let provinciaNombre = this.value;
        let provinciaId = codigosSeleccionados.provincia[provinciaNombre];

        limpiarSelect(municipioSelect, poblacionSelect, nucleoSelect, codigoPostalSelect, calleSelect);

        if (provinciaId) {
            obtenerDatos(`https://apiv1.geoapi.es/municipios?CPRO=${provinciaId}&type=JSON&key=${API_KEY}&sandbox=${SANDBOX}`)
                .then(municipios => {
                    municipios.forEach(municipio => {
                        let nombre = capitalizarTexto(municipio.DMUN50);
                        codigosSeleccionados.municipio[nombre] = municipio.CMUM;

                        let option = document.createElement("option");
                        option.value = nombre;
                        option.textContent = nombre;
                        municipioSelect.appendChild(option);
                    });
                    municipioSelect.disabled = false;
                });
        }
    });

    municipioSelect.addEventListener("change", function () {
        let municipioNombre = this.value;
        let municipioId = codigosSeleccionados.municipio[municipioNombre];
        let provinciaId = codigosSeleccionados.provincia[provinciaSelect.value];

        limpiarSelect(poblacionSelect, nucleoSelect, codigoPostalSelect, calleSelect);

        if (municipioId) {
            obtenerDatos(`https://apiv1.geoapi.es/poblaciones?CPRO=${provinciaId}&CMUM=${municipioId}&type=JSON&key=${API_KEY}&sandbox=${SANDBOX}`)
                .then(poblaciones => {
                    poblaciones.forEach(poblacion => {
                        let nombre = capitalizarTexto(poblacion.NENTSI50);
                        codigosSeleccionados.poblacion[nombre] = poblacion.CUN;

                        let option = document.createElement("option");
                        option.value = nombre;
                        option.textContent = nombre;
                        poblacionSelect.appendChild(option);
                    });
                    poblacionSelect.disabled = false;
                });
        }
    });

    poblacionSelect.addEventListener("change", function () {
        let poblacionNombre = this.value;
        let provinciaId = codigosSeleccionados.provincia[provinciaSelect.value];
        let municipioId = codigosSeleccionados.municipio[municipioSelect.value];
    
        limpiarSelect(nucleoSelect, codigoPostalSelect, calleSelect);
    
        if (poblacionNombre) {
            obtenerDatos(`https://apiv1.geoapi.es/nucleos?CPRO=${provinciaId}&CMUM=${municipioId}&NENTSI50=${poblacionNombre.toUpperCase()}&type=JSON&key=${API_KEY}&sandbox=${SANDBOX}`)
                .then(nucleos => {
                    nucleos.forEach(nucleo => {
                        let nombre = capitalizarTexto(nucleo.NNUCLE50);
                        codigosSeleccionados.nucleo[nombre] = nucleo.CUN;
    
                        let option = document.createElement("option");
                        option.value = nombre;
                        option.textContent = nombre;
                        nucleoSelect.appendChild(option);
                    });
                    nucleoSelect.disabled = false;
                });
        }
    });
    

    nucleoSelect.addEventListener("change", function () {
        let provinciaId = codigosSeleccionados.provincia[provinciaSelect.value];
        let municipioId = codigosSeleccionados.municipio[municipioSelect.value];
        let nucleoNombre = nucleoSelect.value;
        let nucleoId = codigosSeleccionados.nucleo[nucleoNombre]; // Obtener el código real del núcleo
        
        if (nucleoId) {
            obtenerDatos(`https://apiv1.geoapi.es/cps?CPRO=${provinciaId}&CMUM=${municipioId}&type=JSON&key=${API_KEY}&sandbox=${SANDBOX}`)
                .then(codigos => {
                    codigoPostalSelect.innerHTML = '<option value="">Selecciona un código postal</option>';
                    codigos.forEach(cp => {
                        let option = document.createElement("option");
                        option.value = cp.CPOS;
                        option.textContent = cp.CPOS;
                        codigoPostalSelect.appendChild(option);
                    });
                    codigoPostalSelect.disabled = false;
                });
        }
    });

    codigoPostalSelect.addEventListener("change", function () {
        let codigoPostalId = this.value;
        let provinciaId = codigosSeleccionados.provincia[provinciaSelect.value];
        let municipioId = codigosSeleccionados.municipio[municipioSelect.value];
        let nucleoNombre = nucleoSelect.value;
        let nucleoId = codigosSeleccionados.nucleo[nucleoNombre]; // Obtener el código del núcleo
    
        limpiarSelect(calleSelect);
    
        if (codigoPostalId && nucleoId) { // Asegurar que ambos valores existen
            obtenerDatos(`https://apiv1.geoapi.es/calles?CPRO=${provinciaId}&CMUM=${municipioId}&CPOS=${codigoPostalId}&type=JSON&key=${API_KEY}&sandbox=${SANDBOX}`)
                .then(calles => {
                    if (calles.length > 0) {
                        calleSelect.innerHTML = '<option value="">Selecciona una calle</option>';
                        calles.forEach(calle => {
                            let nombre = capitalizarTexto(calle.NVIAC);
                            codigosSeleccionados.calle[nombre] = calle.CVIA;
    
                            let option = document.createElement("option");
                            option.value = nombre;
                            option.textContent = nombre;
                            calleSelect.appendChild(option);
                        });
                        calleSelect.disabled = false;
                    } else {
                        console.warn("No se encontraron calles para este código postal.");
                    }
                })
                .catch(error => console.error("Error cargando calles:", error));
        } else {
            console.warn("No se pudo obtener el código del núcleo o el código postal es inválido.");
        }
    });
    
    calleSelect.addEventListener("change", function () {
        direccionInput.disabled = this.value === "";
    });
    
});
