<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
REQUIRE_ONCE("clases/Usuario.php");

$app = new \Slim\App;


#TRAER TODOS LOS USUARIOS

$app->get('/usuarios', function (Request $request, Response $response) 
{
    $listado = Usuario::TraerTodosLosUsuarios();
    return $response->withJson($listado);
});




#ALTA
$app->get('/agregarParam', function ($request, $response, $args) 
{
    $usuario = new stdClass();

    $usuario->nombre = $request->getParam("nombre");   
    $usuario->email = $request->getParam("email");
    $usuario->password = $request->getParam("password");

    try
    {
        $usuarioExistente = Usuario::TraerUsuarioPorEmail($usuario->email);

        if ($usuarioExistente === FALSE) 
        {
            Usuario::Agregar(json_encode($usuario));
            $retorno["Exito"] = TRUE;
            $retorno["Mensaje"] = "Usuario agregado con exito";
            
        } 
        else 
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Email ya existente";
        }
    }
    catch(Exception $e)
    {
        $retorno["Exito"] = FALSE;
        $retorno["Mensaje"] = "Error";
    }

    return $response->withJson($retorno);
});

#ALTA2
$app->get('/agregarJson/{nombre}/{email}/{password}', function ($request, $response, $args) 
{
    $usuario = new stdClass();

    $usuario->nombre = $request->getAttribute("nombre");
    $usuario->email = $request->getAttribute("email");
    $usuario->password = $request->getAttribute("password");

    try
    {
        $usuarioExistente = Usuario::TraerUsuarioPorEmail($usuario->email);

        if ($usuarioExistente === FALSE) 
        {
            Usuario::Agregar(json_encode($usuario));
            $retorno["Exito"] = TRUE;
            $retorno["Mensaje"] = "Usuario agregado con exito";
            
        } 
        else 
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Email ya existente";
        }
    }
    catch(Exception $e)
    {
        $retorno["Exito"] = FALSE;
        $retorno["Mensaje"] = "Error";
    }

    return $response->withJson($retorno);
});







#LOGIN PARAM
$app->get('/loginParam', function ($request, $response, $args) 
{
    $usuario = new stdClass();
    $usuario->email = $request->getParam("email");
    $usuario->password = $request->getParam("password");

    try
    {
        $usuarioLogueado = Usuario::TraerUsuarioLogueado(json_encode($usuario));

        if ($usuarioLogueado === FALSE) 
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Error!!!\nNO coincide email y password!!!";
        } 
        else 
        {
            $retorno["Exito"] = TRUE;
            $retorno["Mensaje"] = "Usuario logueado correctamente";
        }
    }
    catch(Exception $e)
    {
        $retorno["Exito"] = FALSE;
        $retorno["Mensaje"] = "Error";
    }
return $response->withJson($retorno);
    
});


#LOGIN JSON
$app->get('/loginJson/{email}/{password}', function ($request, $response, $args) 
{
    $usuario = new stdClass();
    $usuario->email = $request->getAttribute("email");
    $usuario->password = $request->getAttribute("password");

    try
    {
        $usuarioLogueado = Usuario::TraerUsuarioLogueado(json_encode($usuario));

        if ($usuarioLogueado === FALSE) 
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Error!!!\nNO coincide email y password!!!";
        } 
        else 
        {
            $retorno["Exito"] = TRUE;
            $retorno["Mensaje"] = "Usuario logueado correctamente";
        }
    }
    catch(Exception $e)
    {
        $retorno["Exito"] = FALSE;
        $retorno["Mensaje"] = "Error";
    }
return $response->withJson($retorno);
    
});




#BAJA PARAM
$app->get('/eliminarParam', function ($request, $response, $args) 
{
    $emailEliminar = $request->getParam("email");

    try
    {
        if(Usuario::TraerUsuarioPorEmail($emailEliminar) != false)
        {
            if(Usuario::Borrar($emailEliminar) != false)
            {
                $retorno["Exito"] = TRUE;
                $retorno["Mensaje"] = "Usuario eliminado correctamente";
            }
            else
            {
                    $retorno["Exito"] = FALSE;
                    $retorno["Mensaje"] = "No se puedo eliminar al usuario";
            }
        }
        else
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Usuario inexistente";
        }

    }
    catch(Exception $e)
    {
           $retorno["Exito"] = FALSE;
           $retorno["Mensaje"] = "Error";
    }


    return $response->withJson($retorno);
});




#BAJA JSON
$app->get('/eliminarJson/{email}', function ($request, $response, $args) 
{
    $emailEliminar = $request->getAttribute("email");

    try
    {
        if(Usuario::TraerUsuarioPorEmail($emailEliminar) != false)
        {
            if(Usuario::Borrar($emailEliminar) != false)
            {
                $retorno["Exito"] = TRUE;
                $retorno["Mensaje"] = "Usuario eliminado correctamente";
            }
            else
            {
                    $retorno["Exito"] = FALSE;
                    $retorno["Mensaje"] = "No se puedo eliminar al usuario";
            }
        }
        else
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Usuario inexistente";
        }

    }
    catch(Exception $e)
    {
           $retorno["Exito"] = FALSE;
           $retorno["Mensaje"] = "Error";
    }


    return $response->withJson($retorno);
});






#MODIFICAR PARAM
$app->get('/modificarParam', function (Request $request, Response $response) 
{
    $usuarioNuevo = new stdClass();

    $usuarioNuevo->nombre = $request->getParam("nombre");
    $usuarioNuevo->email = $request->getParam("email");
    $usuarioNuevo->password = $request->getParam("password");


        $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "Se modifico usuario correctamente";

        $email = $usuarioNuevo->email;

        $usuario = new Usuario($email);
        $usuario = Usuario::TraerUsuarioPorEmail($email);

        if ($usuario === FALSE)
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "No se encontro usuario";
        }
        else
        {
                if(Usuario::Modificar(json_encode($usuarioNuevo)) == false)
                {
                    $retorno["Exito"] = FALSE;
                    $retorno["Mensaje"] = "No se pudo modificar usuario";
                }
        }

        return $response->withJson($retorno);
});












#MODIFICAR JSON
$app->get('/modificarJson/{nombre}/{email}/{password}', function (Request $request, Response $response) 
{
    $usuarioNuevo = new stdClass();
    $usuarioNuevo->nombre = $request->getAttribute("nombre");
    $usuarioNuevo->email = $request->getAttribute("email");
    $usuarioNuevo->password = $request->getAttribute("password");


        $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "Se modifico usuario correctamente";

        $email = $usuarioNuevo->email;

        $usuario = new Usuario($email);
        $usuario = Usuario::TraerUsuarioPorEmail($email);

        if ($usuario === FALSE)
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "No se encontro usuario";
        }
        else
        {
                if(Usuario::Modificar(json_encode($usuarioNuevo)) == false)
                {
                    $retorno["Exito"] = FALSE;
                    $retorno["Mensaje"] = "No se pudo modificar usuario";
                }
        }

        return $response->withJson($retorno);
});




$app->run();