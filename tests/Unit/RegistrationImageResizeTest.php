<?php

namespace Tests\Unit;

use App\Http\Controllers\ReceiptFormController;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use ReflectionMethod;
use Tests\TestCase;

class RegistrationImageResizeTest extends TestCase
{
    public function test_student_photo_and_slip_are_resized_to_their_maximum_dimensions(): void
    {
        $directory = sys_get_temp_dir().DIRECTORY_SEPARATOR.'registration-image-resize-'.Str::random(12);
        mkdir($directory, 0777, true);

        $source = $directory.DIRECTORY_SEPARATOR.'source.jpg';
        $photo = $directory.DIRECTORY_SEPARATOR.'photo.jpg';
        $slip = $directory.DIRECTORY_SEPARATOR.'slip.jpg';

        try {
            Image::canvas(3200, 2400, '#f26522')->save($source, 100);

            $method = new ReflectionMethod(ReceiptFormController::class, 'resizeRegistrationImage');
            $method->setAccessible(true);
            $controller = new ReceiptFormController;

            $method->invoke($controller, $source, $photo, 'photo', 'jpg');
            $method->invoke($controller, $source, $slip, 'slip', 'jpg');

            $this->assertSame([1600, 1200], array_slice(getimagesize($photo), 0, 2));
            $this->assertSame([2000, 1500], array_slice(getimagesize($slip), 0, 2));
            $this->assertLessThan(filesize($source), filesize($photo));
            $this->assertLessThan(filesize($source), filesize($slip));
        } finally {
            foreach ([$source, $photo, $slip] as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            if (is_dir($directory)) {
                rmdir($directory);
            }
        }
    }
}
