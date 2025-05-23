<?php

namespace Tests\Feature;

use App\Http\Resources\AlbumResource;
use App\Models\Album;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    #[Test]
    public function index(): void
    {
        Album::factory(10)->create();

        $this->getAs('api/albums')
            ->assertJsonStructure(AlbumResource::PAGINATION_JSON_STRUCTURE);

        $this->getAs('api/albums?sort=artist_name&order=asc')
            ->assertJsonStructure(AlbumResource::PAGINATION_JSON_STRUCTURE);

        $this->getAs('api/albums?sort=year&order=desc&page=2')
            ->assertJsonStructure(AlbumResource::PAGINATION_JSON_STRUCTURE);

        $this->getAs('api/albums?sort=created_at&order=desc&page=1')
            ->assertJsonStructure(AlbumResource::PAGINATION_JSON_STRUCTURE);
    }

    #[Test]
    public function show(): void
    {
        $this->getAs('api/albums/' . Album::factory()->create()->id)
            ->assertJsonStructure(AlbumResource::JSON_STRUCTURE);
    }
}
