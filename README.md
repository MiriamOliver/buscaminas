# buscaminas
ejercicio buscaminas

Funcionamiento

------------POST-------------
Ruta = localhost/Cliente1
Json {
    id
    nombre
    passw
}
Insertar un jugador 

-------------PUT-------------
Ruta = localhost/Cliente2
Json {
    id
    nombre
    passw
}
Para modificar el Jugador

-------------DELETE---------------
Ruta = localhost/Cliente4
Json {
    id
    nombre
    passw
}
Para borrar el Jugador

---------------GET----------------
Ruta = localhost/Cliente3
Json {
    id
    nombre
    passw
}
Para que se muestre el jugador y sus partidas
_____________________________________________

Ruta = localhost/Juego1
Json {
    id
    nombre
    passw
}
Se crea un tablero con un tamaño y una cantidad de minas predeterminado para el jugador
_____________________________________________

Ruta = localhost/Juego1/15/5
Json {
    id
    nombre
    passw
}
Se crea un tablero con un tamaño (15) y unas minas (5) por petición del jugador
_____________________________________________

Ruta = localhost/Juego2/7
Json {
    id
    nombre
    passw
}
El jugador golpea en su tablero en la posicion (7) que pida
