<?php

namespace Tests;

use App\Exceptions\AppBaseException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');

        $this->withoutExceptionHandling([
            'Illuminate\Validation\ValidationException',
            'App\Exceptions\AppBaseException',
        ]);

    }
}
