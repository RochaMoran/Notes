<?php 
    class Conection {    
        private $host = "localhost";
        private $user = "root";
        private $dbName = "notes";
        private $pass = "";
        private $conexion;
        public $message = '';

        public function __construct(){
            try{
                $this->conexion = new PDO("mysql:host=$this->host; dbname=$this->dbName", $this->user, $this -> pass);
            } catch(PDOException $e){
                die('Error en la conexion: '.$e->getMessage());
            }
        }

        private function validateUser($email){
            $sql = "SELECT COUNT(*) FROM users WHERE email=:email";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
            $stmt->execute();
            $countColumns = $stmt->fetchColumn();

            if($countColumns > 0){
                return true;
            }

            return false;
        }

        private function showMessage ($msg, $cls) {
            echo "<div class=\"alert $cls\" role=\"alert\">
                $msg
            </div>";
        }

        public function singUp ($email, $password, $username) {
            $db = new Conection();
            
            if($db -> validateUser($email)){
                $db -> showMessage("Ya existe un usuario con este correo electronico", "alert-danger");
            } else {
                $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
                $stmt = $this -> conexion -> prepare($sql);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR, 30);
                $passwordEncription = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $passwordEncription);
                $query = $stmt->execute();

                if($query){
                    $db -> showMessage("Usuario creado correctamente", "alert-primary");
                } else {
                    $db -> showMessage("Lo siento, ha ocurrido un error", "alert-danger");
                }

            }
        }

        private function compareUser ($email, $password){
            $db = new Conection();
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $this -> conexion -> prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $hash = $result['password'];

            if(password_verify($password, $hash)){
                $db -> showMessage("Inicio de sesion satisfactorio", "alert-primary");
            } else {
                $db -> showMessage("Favor, revise su contraseña", "alert-danger");
            }
        }

        public function login ($email, $password) {
            $db = new Conection();
            
            if($db -> validateUser($email)){
               $db -> compareUser($email, $password);

            } else {
                $db -> showMessage("No hemos encontrado un usuario con el correo electronico $email", "alert-danger");
            }
        }
    }
?>