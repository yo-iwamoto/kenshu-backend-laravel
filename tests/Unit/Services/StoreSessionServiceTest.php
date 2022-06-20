<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\StoreSessionService;
use App\Services\StoreSessionServiceInterface;
use Tests\TestCase;

class StoreSessionServiceTest extends TestCase
{
    const DEFATUL_ICON_PATH = '/img/default-icon.png';

    private StoreSessionServiceInterface $service;
    private string $email;
    private string $password;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(StoreSessionService::class);

        $this->email = $this->faker->email();
        $this->password = $this->faker->password(minLength: 10);


        User::create([
            'name' => $this->faker->name(),
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'profile_image_url' => self::DEFATUL_ICON_PATH,
        ]);
    }

    public function test_正しい入力でtrueが返ること(): void
    {
        $result = $this->service->execute(
            email: $this->email,
            password: $this->password,
        );
        $this->assertTrue($result);
    }

    public function test_誤ったパスワードでfalseが返ること(): void
    {
        $wrong_password = 'password'; // $this->password は生成時に minLength: 10 をしているので必ず一致しない

        $result = $this->service->execute(
            email: $this->email,
            password: $wrong_password,
        );
        $this->assertFalse($result);
    }
}
