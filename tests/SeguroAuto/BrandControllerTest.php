<?php

use App\Models\SeguroAuto\Brands;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery as m;

class BrandControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $connectionsToTransact = ['sqlite', 'sqlite_seguro_auto'];

    /**
     * A basic test example.
     *
     * @test
     */
    public function testIndex()
    {
        $brands = factory(Brands::class)->create();

        $retorno = $this->call('GET', '/api/seguroauto/v1/frontend/brands');

        $this->assertResponseOk();
    }
}
