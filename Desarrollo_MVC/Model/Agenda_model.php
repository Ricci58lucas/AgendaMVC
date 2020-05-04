<?php

    class Agenda_model {

        private $con; //conexion
        private $contactosArray;

        public function __construct(){
            require_once("Model/Conexion_model.php");

            //accedemos al metodo estatico conectar()
            $this->con = Conexion::conectar();

            if(isset($_POST['debug_btn'])){
                $this->setUpContactos(true);
            } else{
                $this->setUpContactos(false);
            }

            if(isset($_POST['borrar']))
                $this->removeContacto($_POST['borrar']);

            if(isset($_POST['nombre']) || isset($_POST['apellido']) || isset($_POST['numero']))
                $this->insertContacto($_POST['nombre'], $_POST['apellido'], $_POST['numero']);

            if(isset($_POST['aceptarEdit']))
                $this->editContacto($_POST['nombreEdit'], $_POST['apellidoEdit'], $_POST['numeroEdit'], $_POST['aceptarEdit']);

            //se asigna a contactosArray como un array
            $this->contactosArray = array();

            if(isset($_POST['alfSortNom_btn'])){
                //ORDER BY ordena el campo indicado (nombre) de la forma indicada (ASCendant)
                $sql = "SELECT * FROM contactos ORDER BY nombre ASC;";
            } else if(isset($_POST['alfSortApe_btn'])){
                $sql = "SELECT * FROM contactos ORDER BY apellido ASC;";
            } else{
                $sql = "SELECT * FROM contactos;";
            }
            $this->fetchContactos($sql);
        }

        private function insertContacto($nom, $ape, $num){
            $sql = "INSERT INTO contactos (nombre,apellido,numero) VALUES('".$nom."','".$ape."',".$num.");";
            //query ejecuta la consulta y devuelve un booleano
            if(!$this->con->query($sql)){
                echo "<script>console.log('Error al insertar la tabla: ".$this->con->error."');</script>";
            }
        }

        private function removeContacto($num){ //se recibe un numero y se borra el contacto con ese numero (***TODO: popup de deshacer)
            $sql = "DELETE FROM contactos WHERE numero=".$num.";";

            if(!$this->con->query($sql)){
                echo "<script>console.log('Error al remover la tabla: ".$this->con->error."');</script>";
            }
        }

        private function editContacto($nombre, $apellido, $numero, $datosOriginales){
            //$datosOriginales = $nombre*$apellido*$numero; el metodo explode($delimiter, $string) los separa
            $datosSeparados = explode("*", $datosOriginales);

            //si el campo del nombre esta vacio, se deja el nombre original (guardado previamente en $datosSeparados)
            if($nombre == "")
                $nombre = $datosSeparados[0];

            //lo mismo con el apellido
            if($apellido == "")
                $apellido = $datosSeparados[1];

            $sql = "UPDATE contactos SET nombre='".$nombre."', apellido='".$apellido."'";

            if($numero == $datosSeparados[2]){
                //en caso que el numero se repita solo se hace el update del nombre y apellido
                $sql = $sql." WHERE numero=".$datosSeparados[2].";";
            } else{
                //en caso de que el numero sea distinto se hace, tambien, el update del numero
                $sql = $sql.", numero=".$numero." WHERE numero=".$datosSeparados[2].";";
            }

            if(!$this->con->query($sql)){
                echo "<script>console.log('Error al actualizar la tabla: ".$this->con->error."');</script>";
            }
        }

        private function fetchContactos($sql){
            //se hace la consulta
            if($result = mysqli_query($this->con, $sql)){
                if (mysqli_num_rows($result) > 0) {
                    //se recorre el resultado de la consulta
                    while($row = mysqli_fetch_assoc($result)) {
                        //se almacena cada fila en el array
                        $this->contactosArray[] = $row;
                    }
                }
            }
        }

        private function setUpContactos($insertar){
            //se crea la tabla
            $sql="CREATE TABLE IF NOT EXISTS contactos(
            nombre VARCHAR(50) NOT NULL,
            apellido VARCHAR(50) NOT NULL,
            numero INT(8) NOT NULL PRIMARY KEY
            );";
            if(!$this->con->query($sql)){
                echo "<script>console.log('Error al crear la tabla: ".$this->con->error."');</script>";
            }

            //si se activa el modo de prueba se rellena la tabla con contactos predeterminados
            if($insertar){
                //se resetea la tabla
                $sql = "TRUNCATE contactos;";
                if(!$this->con->query($sql)){
                    echo "<script>console.log('Error al truncar la tabla: ".$this->con->error."');</script>";
                }

                $sql="INSERT INTO contactos(nombre,apellido,numero) VALUES
                ('Lucas','Ricci',12345678),
                ('Lucas','Castagna',23456789),
                ('Celeste','Gomez',45678912),
                ('Ivan','Vazquez Frino',84530065),
                ('Julian','Aparicio',90605492),
                ('Fausto','Castrilli',34545676),
                ('Joaquin','Garcia Silvarredonda',30067891),
                ('Facundo','Galvan',43068023),
                ('Facundo','Gonzalez Toro',87650321),
                ('Rodrigo','Bosotina',40065032),
                ('Rodrigo','Avincola',65402109);";

                if(!$this->con->query($sql)){
                    echo "<script>console.log('Error al insertar la tabla: ".$this->con->error."');</script>";
                }
            }
        }

        public function getContactosArray(){
            return $this->contactosArray;
        }
    }
?>