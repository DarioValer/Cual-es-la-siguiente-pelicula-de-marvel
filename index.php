<?php 
session_start();

const URL_API = 'https://whenisthenextmcufilm.com/api';
$result = file_get_contents(URL_API);
$data = json_decode($result, true);
$data2= $data["following_production"];
//print_r('<pre>');
//var_dump($data);
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Determinar qué datos usar en función del ID
$pelicula = ($id === 1) ? $data : $data2;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CualEsLaSiguientePeliculaMarvel</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bebas+Neue&family=Timmana&display=swap" rel="stylesheet">
        <style>

            * {
                margin: 0;
                padding: 0;
                font-family: "Bebas Neue", sans-serif;
                font-weight: 400;
                font-style: normal;
            }

            .bebas-neue-regular {
                font-family: "Bebas Neue", sans-serif;
                font-weight: 400;
                font-style: normal;
            }


            body{
                width: 100%;
                height: 100dvh;
            }

            .titulo{
                font-size: 80px;
                margin-bottom: 5%;
            }

            .centrado{
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            #revelarBoton{
                font-size: 40px;
                padding: 20px;
                width: 30%;
                background-color: transparent;
                border-radius: 40px;
                border: 1px solid black;
            }

            .siguienteBoton{
                display: none;
                opacity: 0;
                transition: 2s opacity;
                font-size: 40px;
                padding: 20px;
                background-color: transparent;
                border-radius: 40px;
                border: 1px solid black;
                width: 5%;
            }

            .atrasBoton{
                display: none;
                opacity: 0;
                transition: 2s opacity;
                font-size: 40px;
                padding: 20px;
                background-color: transparent;
                border-radius: 40px;
                border: 1px solid black;
                width: 5%;
            }

            .titulo-pelicula-actual{
                font-size: 200px;
            }

            .info-izq{
                display: none;
                opacity: 0;
                transition: 2s opacity;
                padding-right: 30px;
                width: 50%;
            }

            .bloque-info{
                font-size: 30px;
            }

            .descripcion-value{
                font-size: 25px;
            }

            .faltan-dias{
                font-size: 90px;
                /*position: absolute;*/
                bottom: 0;
                left: 0;
                right: 0;
                text-align: center;
                background-color: rgb(255, 255, 255, 0.7);
            }

            .pelicula-actual{
                display: none;
                opacity: 0;
                transition: 2s opacity;
                position: relative;
            }

            .revelado{
                display: block;
                opacity: 1;
            }
        </style>
    </head>
    <body class="centrado">
        <h1 class="titulo">¿Cuál es la siguiente película de <span style="background-color: red; color: white; padding:0px 8px;">MARVEL</span>?</h1>
        <button id="revelarBoton">REVELAR</button>
        <button class="atrasBoton">VOLVER</button>
        <div class="info-izq">
            <h2 class="titulo-pelicula-actual"><?= $pelicula["title"]?></h2>
            <div class="bloque-info">
                <h3>Fecha de estreno: <span style="font-family: 'Barlow', sans-serif; font-weight: 400;"><?= $pelicula["release_date"]; ?></span></h3>
                <h3>Tipo: <span style="font-family: 'Barlow', sans-serif; font-weight: 400;"><?= $pelicula["type"]; ?></span></h3>
                <h3>Descripción: <span class="descripcion-value" style="font-family: 'Barlow', sans-serif; font-weight: 400;"><?= $pelicula["overview"];?></span></h3>
            </div>
            
            
        </div>
        <div class="pelicula-actual centrado">
            <img src="<?php echo $data["poster_url"]?>" alt="">
            <h2 class="faltan-dias">FALTAN <span style="background-color: red; color: white; padding: 0 8px;"><?= $pelicula["days_until"] ?></span> DÍAS</h2>
            
        </div>
        <button class="siguienteBoton">SIGUIENTE PELÍCULA</button>
        <script> 
            function actualizarParametroURL(parametro, valor) {
                const url = new URL(window.location);
                url.searchParams.set(parametro, valor);
                window.history.pushState({}, '', url);
            }
        </script>
        <script>
            let boton = document.querySelector('#revelarBoton');
            let botonSiguiente = document.querySelector('.siguienteBoton');
            let botonAtras = document.querySelector('.atrasBoton');
            let peliculaActual = document.querySelector('.pelicula-actual');
            let titulo = document.querySelector('.titulo');
            let infoIzq = document.querySelector('.info-izq');
            let body = document.querySelector('body');

            boton.addEventListener('click', () => {
                body.style.flexDirection = 'row';
                body.style.justifyContent = 'space-evenly';
                boton.style.display = 'none';
                titulo.style.display = 'none';
                infoIzq.style.display = 'block'; 
                peliculaActual.style.display = 'block'; // Asegura que el elemento se muestre
                setTimeout(function() {
                    peliculaActual.classList.add('revelado'); // Aplica la transición de opacidad
                    infoIzq.classList.add('revelado');
                    botonSiguiente.classList.add('revelado');
                }, 5); 

                
            });
            botonSiguiente.addEventListener('click', () => {
                botonSiguiente.style.display = 'none';
                peliculaActual.style.display = 'none';
                infoIzq.style.display = 'none';
                botonSiguiente.style.display = 'none';
                botonAtras.style.display = 'block'; 
                //peliculaSiguiente.style.display = 'block'; // Asegura que el elemento se muestre
                setTimeout(function() {
                    //peliculaSiguiente.classList.add('revelado'); // Aplica la transición de opacidad
                    //infoIzqSiguiente.classList.add('revelado');
                    botonAtras.classList.add('revelado');
                }, 5); 

                actualizarParametroURL('id', 2);

                
            });
        </script>
    </body>
</html>
