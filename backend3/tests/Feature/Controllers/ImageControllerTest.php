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
    public function test_create_upload_image_ajax()
    {
        $user     = factory(User::class)->create();
        $this->actingAs($user)->assertAuthenticated();
        $image = UploadedFile::fake()->image('photo1.png');
        $response = $this->actingAs($user)->ajaxPost('/images/create',
            [
                'images' => [ $image ]
            ]);

        $response->assertSuccessful();
    }
}
