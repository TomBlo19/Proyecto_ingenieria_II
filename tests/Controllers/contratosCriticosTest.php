<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\Receta;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Database;

class ContratosCriticosTest extends TestCase
{
    protected $db;
    protected function setUp(): void
{
    parent::setUp();

    $this->db = Database::connect();

    $this->db->transBegin();
}

protected function tearDown(): void
{
    if ($this->db->transStatus()) {

        $this->db->transRollback();
    }

    parent::tearDown();
}

public function testPublicarResena()
{
    $receta = new Receta();

    // Caso correcto
    $this->assertTrue(
        $receta->publicarResena(
            1,
            6,
            'Reseña válida'
        )
    );

    // Caso incorrecto: comentario vacío
    $this->assertFalse(
        $receta->publicarResena(
            1,
            6,
            ''
        )
    );

    // Caso incorrecto: solo espacios
    $this->assertFalse(
        $receta->publicarResena(
            1,
            6,
            '     '
        )
    );

    // Caso correcto
    $this->assertTrue(
        $receta->publicarResena(
            2,
            7,
            'Muy buena receta'
        )
    );

    // Caso correcto
    $this->assertTrue(
        $receta->publicarResena(
            1,
            8,
            'La recomiendo'
        )
    );
}





public function testValorarPublicacion()
{
    $receta = new Receta();

    // Caso correcto: like a una receta
    $this->assertTrue(
        $receta->valorarPublicacion(
            'receta',
            1,
            6,
            1
        )
    );

    // Caso correcto: dislike a una receta
    $this->assertTrue(
        $receta->valorarPublicacion(
            'receta',
            2,
            7,
            0
        )
    );

    // Caso correcto: like a una reseña
    $this->assertTrue(
        $receta->valorarPublicacion(
            'resena',
            1,
            2,
            1
        )
    );

    // Caso correcto: dislike a una reseña
    $this->assertTrue(
        $receta->valorarPublicacion(
            'resena',
            2,
            14,
            0
        )
    );

    // Caso incorrecto: tipo de voto inválido para receta
    $this->assertTrue(
        $receta->valorarPublicacion(
            'receta',
            1,
            8,
            3
        )
    );

    // Caso incorrecto: tipo de voto inválido para reseña
    $this->assertFalse(
        $receta->valorarPublicacion(
            'resena',
            2,
            16,
            3
        )
    );
}


   


  public function testPublicarReceta()
{
    session()->set('id_usuario', 1);

    $imagen = $this->createMock(
        UploadedFile::class
    );

    $imagen->method('isValid')
        ->willReturn(true);

    $imagen->method('getRandomName')
        ->willReturn('foto.jpg');

    $imagen->method('move')
        ->willReturn(true);

    $receta = new Receta();

    // Caso correcto
    $this->assertTrue(
        is_numeric(
            $receta->publicarReceta(
                'Receta válida',
                'Descripción suficientemente larga',
                'harina, huevo',
                1,
                $imagen
            )
        )
    );

    // Caso incorrecto: título vacío
    $this->assertFalse(
        is_numeric(
            $receta->publicarReceta(
                '',
                'Descripción suficientemente larga',
                'harina, huevo',
                1,
                $imagen
            )
        )
    );

    // Caso incorrecto: descripción muy corta
    $this->assertFalse(
        is_numeric(
            $receta->publicarReceta(
                'Receta válida',
                'Corta',
                'harina, huevo',
                1,
                $imagen
            )
        )
    );

    // Caso correcto
    $this->assertTrue(
        is_numeric(
            $receta->publicarReceta(
                'Otra receta válida',
                'Otra descripción suficientemente larga',
                'arroz, pollo',
                1,
                $imagen
            )
        )
    );

    // Caso correcto
    $this->assertTrue(
        is_numeric(
            $receta->publicarReceta(
                'Milanesas',
                'Descripción detallada de la preparación',
                'carne, huevo, pan rallado',
                1,
                $imagen
            )
        )
    );

    // Caso correcto
    $this->assertTrue(
        is_numeric(
            $receta->publicarReceta(
                'Ensalada César',
                'Descripción suficientemente extensa',
                'lechuga, pollo, queso',
                1,
                $imagen
            )
        )
    );
}

}