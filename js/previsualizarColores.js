document.addEventListener("DOMContentLoaded", function () {

    const colorPicker = document.querySelector("input[name='color']");

    colorPicker.addEventListener("input", function () {

        let nuevoColor = this.value;

        if(nuevoColor == "#000000" || nuevoColor == "#ffffff") {

            // Establecer el nuevo color como --color-1 en el CSS
            document.documentElement.style.setProperty('--color-1', "#1864AF");
            document.documentElement.style.setProperty('--color-2', "#CAE6FF");
            document.documentElement.style.setProperty('--color-3', "#12508C");
            document.documentElement.style.setProperty('--color-4', "#CFECFF");
            document.documentElement.style.setProperty('--color-5', "#2C3E50");
            document.documentElement.style.setProperty('--color-6', "#34495E");
            document.documentElement.style.setProperty('--color-7', "#3498DB");
            document.documentElement.style.setProperty('--color-8', "#2980B9");
            document.documentElement.style.setProperty('--color-9', "#99C1E4");
            document.documentElement.style.setProperty('--color-10', "#004FAD");

            return;

        }else{

            // Establecer el nuevo color como --color-1 en el CSS
            document.documentElement.style.setProperty('--color-1', nuevoColor);

        }

        // Función clamp para limitar valores
        function clamp(value, min, max) {
            return Math.max(min, Math.min(max, value));
        }

        // Convierte HEX a HSL
        function hexToHSL(hex) {
            let r = parseInt(hex.substring(1, 3), 16) / 255;
            let g = parseInt(hex.substring(3, 5), 16) / 255;
            let b = parseInt(hex.substring(5, 7), 16) / 255;

            let max = Math.max(r, g, b), min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;

            if (max === min) {
                h = s = 0; // Sin saturación
            } else {
                let d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                h *= 60;
            }
            return { h: Math.round(h), s: Math.round(s * 100), l: Math.round(l * 100) };
        }

        // Convierte HSL a HEX
        function hslToHex(h, s, l) {
            s /= 100;
            l /= 100;

            let c = (1 - Math.abs(2 * l - 1)) * s;
            let x = c * (1 - Math.abs((h / 60) % 2 - 1));
            let m = l - c / 2;

            let r, g, b;
            if (h < 60) { r = c; g = x; b = 0; }
            else if (h < 120) { r = x; g = c; b = 0; }
            else if (h < 180) { r = 0; g = c; b = x; }
            else if (h < 240) { r = 0; g = x; b = c; }
            else if (h < 300) { r = x; g = 0; b = c; }
            else { r = c; g = 0; b = x; }

            r = Math.round((r + m) * 255);
            g = Math.round((g + m) * 255);
            b = Math.round((b + m) * 255);

            return `#${((1 << 24) | (r << 16) | (g << 8) | b).toString(16).slice(1).toUpperCase()}`;
        }

        // Función para normalizar más el color base:
        // Forzamos la saturación a un rango entre 50% y 70%
        // y la luminancia a un rango entre 45% y 55%.
        function normalizarHSL(h, s, l) {
            s = clamp(s, 50, 70);
            l = clamp(l, 45, 55);
            return { h, s, l };
        }

        // Genera la paleta a partir del color base normalizado
        function generarPaleta(baseColor) {
            let hsl = hexToHSL(baseColor);
            // Normalizamos el color base para evitar extremos y mantener consistencia
            hsl = normalizarHSL(hsl.h, hsl.s, hsl.l);

            return {
                color1: hslToHex(hsl.h, hsl.s, hsl.l), // Color base normalizado
                color2: hslToHex(hsl.h, clamp(hsl.s * 0.3, 0, 100), clamp(hsl.l * 1.8, 0, 100)), // Muy claro
                color3: hslToHex(hsl.h, clamp(hsl.s * 1.1, 0, 100), clamp(hsl.l * 0.6, 0, 100)), // Más oscuro
                color4: hslToHex(hsl.h, clamp(hsl.s * 0.4, 0, 100), clamp(hsl.l * 1.3, 0, 100)), // Claro
                color5: hslToHex(hsl.h, clamp(hsl.s * 1.2, 0, 100), clamp(hsl.l * 0.5, 0, 100)), // Muy oscuro
                color6: hslToHex(hsl.h - 10, clamp(hsl.s * 1.1, 0, 100), clamp(hsl.l * 0.6, 0, 100)), // Variación 1
                color7: hslToHex(hsl.h + 10, clamp(hsl.s * 1.1, 0, 100), clamp(hsl.l * 0.7, 0, 100)), // Variación 2
                color8: hslToHex(hsl.h, clamp(hsl.s * 1.0, 0, 100), clamp(hsl.l * 0.8, 0, 100)), // Intermedio
                color9: hslToHex(hsl.h, clamp(hsl.s * 0.6, 0, 100), clamp(hsl.l * 1.2, 0, 100)),  // Suave
                color10: hslToHex(hsl.h, clamp(hsl.s * 1.3, 0, 100), clamp(hsl.l * 0.5, 0, 100)) // Nuevo color 10: más oscuro
            };
        }

        // Función que actualiza todas las variables de color en :root
        function actualizarColores() {
            
            let colorBase = getComputedStyle(document.documentElement).getPropertyValue('--color-1').trim();

            if (!colorBase || colorBase === '') {
                console.warn("⚠️ No se encontró --color-1, usando #1864AF por defecto.");
                colorBase = "#1864AF";
            }

            let paleta = generarPaleta(colorBase);

            document.documentElement.style.setProperty('--color-1', paleta.color1);
            document.documentElement.style.setProperty('--color-2', paleta.color2);
            document.documentElement.style.setProperty('--color-3', paleta.color3);
            document.documentElement.style.setProperty('--color-4', paleta.color4);
            document.documentElement.style.setProperty('--color-5', paleta.color5);
            document.documentElement.style.setProperty('--color-6', paleta.color6);
            document.documentElement.style.setProperty('--color-7', paleta.color7);
            document.documentElement.style.setProperty('--color-8', paleta.color8);
            document.documentElement.style.setProperty('--color-9', paleta.color9);
            document.documentElement.style.setProperty('--color-10', paleta.color10);

        }

        actualizarColores();
        
    });

    actualizarColores();

});
