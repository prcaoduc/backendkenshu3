<?php

namespace Tests\Feature\Controllers;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_upload_image()
    {
        $user     = factory(User::class)->create();
        $response = $this->actingAs($user)->ajaxPost('/images/create',
            [
                'images' => [ UploadedFile::fake()->image('photo1.png'), UploadedFile::fake()->image('photo2.png') ]
            ]);

        $response->assertSuccessful();

    }
}
