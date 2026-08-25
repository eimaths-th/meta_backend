<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteSmokeTest extends TestCase
{
    public function test_key_public_routes_are_registered(): void
    {
        foreach ([
            'login',
            'form.store',
            'form.checkDuplicateRegistration',
            'parentregister',
            'google.login',
            'generate.tts',
            'receipts.cancel',
        ] as $routeName) {
            $this->assertNotNull(Route::getRoutes()->getByName($routeName), "Route [{$routeName}] is not registered.");
        }
    }
}
