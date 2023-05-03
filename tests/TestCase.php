<?php

namespace Tests;

use Database\Seeders\GuruSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    
    // protected $seeder = GuruSeeder::class;
}
