<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\Publicacion;
use App\Controllers\Valoracion;

class contratosCriticosTest extends TestCase
{
    public function testPublicarResena()
    {
        $publicacion = new Publicacion();

        $resultado = $publicacion->publicarResena(
            1, 
            5, 
            'Reseña creada desde PHPUnit'
        );

        $this->assertTrue($resultado);
    }

   public function testValorarReceta()
{
    $valoracion = new Valoracion();

    $resultado = $valoracion->valorarPublicacion(
        'receta', // Usa EstrategiaReceta
        1,         // Usuario que vota
        5,         // ID de la receta
        1          // Like
    );

    $this->assertNotNull($resultado);
}


public function testPublicarReceta()
{
    session()->set('id_usuario', 1);

    $imagen = $this->createMock(
        \CodeIgniter\HTTP\Files\UploadedFile::class
    );

    $imagen->method('isValid')
            ->willReturn(true);

    $imagen->method('getRandomName')
            ->willReturn('prueba.jpg');

    $imagen->method('move')
            ->willReturn(true);

    $publicacion = new Publicacion();

    $resultado = $publicacion->publicarReceta(
        'Receta PHPUnit',
        'Descripción suficientemente larga',
        'harina, huevo',
        1,
        $imagen
    );

    $this->assertIsInt($resultado);
}


    }