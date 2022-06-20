<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected FakerGenerator $faker;

    public function __construct()
    {
        parent::__construct();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');

        $this->faker = FakerFactory::create();
    }
}
