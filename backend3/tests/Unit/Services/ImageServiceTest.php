<?php

namespace Tests\Feature\Controllers;

use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_upload_image_ajax()
    {
        $uploadedfile = Mockery::mock(UploadedFile::class);
        $uploadedfile->shouldReceive('guessExtension')->once()->andReturn('png');
        $uploadedfile->shouldReceive('storeAs')->once()->andReturn(time() . '.png');
        $exp = app(ImageService::class)->storeAjaxRequest($uploadedfile);
        $this->assertSame($exp, 'http://localhost/images/' . time() . '.png');
    }
}
