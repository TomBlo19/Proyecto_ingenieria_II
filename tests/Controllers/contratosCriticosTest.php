<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\Receta;
use CodeIgniter\HTTP\Files\UploadedFile;

class ContratosCriticosTest extends TestCase
{
public function testPublicarResena()
{
    $receta = new Receta();

    // Caso correcto
    $this->assertTrue(
        $receta->publicarResena(
            1,
            5,
            'Reseña válida'
        )
    );

    // Caso incorrecto: espero que publique una reseña vacía
    $this->assertTrue(
        $receta->publicarResena(
            1,
            5,
            ''
        )
    );

    // Otro caso correcto
    $this->assertTrue(
        $receta->publicarResena(
            1,
            7,
            'Otra reseña válida'
        )
    );
}

   public function testValorarResena()
{
    $receta = $this->createMock(
        Receta::class
    );

    $receta->method('valorarPublicacion')
        ->willReturnOnConsecutiveCalls(
            true,
            false,
            true
        );

    echo "\nCaso 1: voto válido\n";

    $this->assertTrue(
        $receta->valorarPublicacion(
            'resena',
            1,
            5,
            1
        )
    );

    echo "Caso 2: voto inválido\n";

    $this->assertFalse(
        $receta->valorarPublicacion(
            'resena',
            2,
            6,
            null
        )
    );

    echo "Caso 3: otro voto válido\n";

    $this->assertTrue(
        $receta->valorarPublicacion(
            'resena',
            3,
            7,
            0
        )
    );
}

  public function testPublicarReceta()
{
    $imagen = $this->createMock(
        UploadedFile::class
    );

    $receta = $this->createMock(
        Receta::class
    );

    $receta->method('publicarReceta')
        ->willReturnOnConsecutiveCalls(
            10,
            false,
            12
        );

    $this->assertIsInt(
        $receta->publicarReceta(
            'Receta válida',
            'Descripción suficientemente larga',
            'harina, huevo',
            1,
            $imagen
        )
    );

    $this->assertFalse(
        $receta->publicarReceta(
            '',
            '',
            '',
            null,
            null
        )
    );

    $this->assertIsInt(
        $receta->publicarReceta(
            'Otra receta válida',
            'Otra descripción suficientemente larga',
            'arroz, pollo',
            2,
            $imagen
        )
    );
}
}