<?php
REQUIRE_ONCE("clases/AccesoDatos.php");
class Usuario 
{
    public $email;
    public $password;

    public function __construct($email = NULL) 
    {
        if ($email !== NULL) 
        {
            $this->$email = $email;
            $password = "";
        }
    }
    
    public static function TraerUsuarioLogueado($objString) 
    {
        $obj = json_decode($objString);
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

        $sql = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios2 WHERE email = :email AND password = :pass");
        $sql->execute(array(':email' => $obj->email, ':pass' => $obj->password));
        $usuarioLogueado = $sql->fetchObject('Usuario');
        return $usuarioLogueado;
    }

    public static function Agregar($objString) 
    {
        $obj = json_decode($objString);

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sql = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios2 (nombre, email, password) VALUES (:nombre, :email, :pass)");
         $sql->bindValue(':nombre', $obj->nombre, PDO::PARAM_STR);
        $sql->bindValue(':email', $obj->email, PDO::PARAM_STR);
        $sql->bindValue(':pass', $obj->password, PDO::PARAM_STR);
        $sql->execute();
    }

    public static function Modificar($objString) 
    {
        $obj = json_decode($objString);

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $sql =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios2 SET nombre = :nombre, password = :password WHERE email = :email");
        $sql->bindValue(':nombre', $obj->nombre, PDO::PARAM_STR);
        $sql->bindValue(':password', $obj->password, PDO::PARAM_STR);
        $sql->bindValue(':email', $obj->email, PDO::PARAM_STR);
        return $sql->execute();
    }

    public static function TraerTodosLosUsuarios() 
    {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sql = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios2");
        $sql->execute();
        return $sql->fetchall(PDO::FETCH_ASSOC);
    }

    public static function Borrar($Email) 
    {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sql =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios2 WHERE email = :email");
        $sql->bindValue(':email', $Email, PDO::PARAM_INT);
        return $sql->execute();
    }

    public static function TraerUsuarioPorEmail($email)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sql = $objetoAccesoDato->RetornarConsulta("SELECT email, password FROM usuarios2 WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();
        $unUsuario = $sql->fetchobject("Usuario");
        return $unUsuario;
    }
}