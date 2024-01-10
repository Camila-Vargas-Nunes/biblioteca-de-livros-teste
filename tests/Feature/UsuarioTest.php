<?php

namespace Tests\Feature;

use Auth;
use App\Models\UsuarioModel;
use Tests\TestCase;

class UsuarioTest extends TestCase
{

    protected $usuario;

    public function setUp(): void
    {
        parent::setUp();
        $usuario = UsuarioModel::factory()->create();
        $this->usuario = $usuario;

        $this->actingAs($usuario);
    }

    /**
     * Teste Get Usuario
     *
     * @return void
     */
    public function testGetUsuario()
    {

        $response = $this->get('/api/usuario');
        $response->assertStatus(200)
            ->assertJsonCount(0);
    }

    /**
     * Teste Get usuarios
     *
     * @return void
     */
    public function testGetusuarioNotFound()
    {

        $response = $this->get(route('usuario', 10));
        $response->assertStatus(404)
            ->assertExactJson(['message' => 'Usuário não encontrado.']);
    }


    /**
     * Teste Get usuarios
     *
     * @return void
     */
    public function testGetusuarioOk()
    {

        $usuario = UsuarioModel::factory()->create();
        $response = $this->get(route('usuario.find', $usuario->id));

        $response->assertStatus(200);
    }


    /**
     * Test Post usuarios
     *
     * @return void
     */
    public function testPostusuariosOk()
    {

        $response = $this->post(route('usuario.create'), UsuarioModel::factory()->make()->toArray());
        $response->assertStatus(201);

        // Test validation with no data in payload
        $response = $this->post(route('usuario.create'), []);
        $response->assertStatus(422);
    }


    /**
     * Test PUT usuarios
     *
     * @return void
     */
    public function testPutusuariosNotFound()
    {

        $response = $this->put(route('usuario.update', 10), UsuarioModel::factory()->make()->toArray());

        $response->assertStatus(404)
            ->assertExactJson(['message' => 'Usuário não encontrado.']);
    }

    /**
     * Test PUT usuarios
     *
     * @return void
     */
    public function testPutusuariosOk()
    {

        $usuario = UsuarioModel::factory()->create(['usuario_id' => $this->usuario->id]);
        $response = $this->put(route('usuario.update', $usuario->id), $usuario->toArray());
        $response->assertStatus(200);
    }

    /**
     * Test Post usuarios
     *
     * @return void
     */
    public function testDeletausuarioOk()
    {
        $usuario = UsuarioModel::factory()->create(['usuario_id' => $this->usuario->id]);
        $response = $this->delete(route('usuario.delete', $usuario->id));
        $response->assertStatus(200);

    }

    /**
     * Test Post usuarios
     *
     * @return void
     */
    public function testDeletausuarioNaoEncontrado()
    {
        $usuario = usuario::factory()->create();
        $usuario = UsuarioModel::factory()->create(['usuario_id' => $usuario->id]);
        $response = $this->delete(route('usuario.delete', $usuario->id));
        $response->assertStatus(400)->assertExactJson(['message' => 'Usuário não encontrado']);
    }
}