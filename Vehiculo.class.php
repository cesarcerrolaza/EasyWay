<?php

class Vehiculo {
    protected $color;
    protected $peso;

    public function circula() {
        echo "El vehículo está circulando";
    }

    public function añadir_persona($peso_persona) {
        $this->peso += $peso_persona;
    }

    public function __construct($color, $peso) {
        $this->color = $color;
        $this->peso = $peso;
    }

    public function color() {
        return $this->color;
    }

    public function peso() {
        return $this->peso;
    }
}

class Cuatro_ruedas extends Vehiculo {
    private $numero_puertas;

    public function repintar($color) {
        $this->color = $color;
    }

    public function __construct($color, $peso, $numero_puertas) {
        parent::__construct($color, $peso);
        $this->numero_puertas = $numero_puertas;
    }

    public function numero_puertas() {
        return $this->numero_puertas;
    }
}

class Dos_ruedas extends Vehiculo {
    private $cilindrada;

    public function poner_gasolina($litros) {
        $this->peso += $litros * 0.7; // 0.7 kg/litro
    }

    public function __construct($color, $peso, $cilindrada) {
        parent::__construct($color, $peso);
        $this->cilindrada = $cilindrada;
    }

    public function cilindrada() {
        return $this->cilindrada;
    }
}

class Coche extends Cuatro_ruedas {
    private $numero_cadenas_nieve = 0;

    public function añadir_cadenas_nieve($num) {
        $this->numero_cadenas_nieve += $num;
    }

    public function quitar_cadenas_nieve($num) {
        $this->numero_cadenas_nieve -= $num;
    }

    public function __construct($color, $peso, $numero_puertas, $numero_cadenas_nieve) {
        parent::__construct($color, $peso, $numero_puertas);
        $this->numero_cadenas_nieve = $numero_cadenas_nieve;
    }

    public function numero_cadenas_nieve() {
        return $this->numero_cadenas_nieve;
    }
}

class Camion extends Cuatro_ruedas {
    private $longitud;

    public function añadir_remolque($longitud_remolque) {
        $this->longitud += $longitud_remolque;
    }

    public function __construct($color, $peso, $numero_puertas, $longitud) {
        parent::__construct($color, $peso, $numero_puertas);
        $this->longitud = $longitud == null ? 0 : $longitud;
    }

    public function longitud() {
        return $this->longitud;
    }


}

?>