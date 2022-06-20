<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\StoreUserService;
use App\Services\StoreUserServiceInterface;
use Tests\TestCase;

class StoreUserServiceTest extends TestCase
{
    private StoreUserServiceInterface $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(StoreUserService::class);
    }

    /**
     * ファイルのアップロードとセッションに関心を持たない
     */
    public function test_ファイル無しの正しい入力でUserが作成されること(): void
    {
        $email = $this->faker->email();

        $this->service->execute(
            name: $this->faker->name(),
            email: $email,
            password: $this->faker->password(),
            file: null,
        );

        $data = User::where('email', $email)->get()->toArray();

        $this->assertEquals(count($data), 1);
    }
}
