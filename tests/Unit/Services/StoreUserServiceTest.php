<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\StoreUserService;
use App\Services\StoreUserServiceInterface;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StoreUserServiceTest extends TestCase
{
    private StoreUserServiceInterface $service;
    private string $testImagePath;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(StoreUserService::class);
        $this->testImagePath = base_path('/tests/tmpFiles/test.png');
    }

    /**
     * セッションに関心を持たない
     */
    public function test_正しい入力でUserが作成されること(): void
    {
        $email = $this->faker->email();
        $file = new UploadedFile($this->testImagePath, basename($this->testImagePath));

        $user_name = $this->faker->name();

        $this->service->execute(
            name: $user_name,
            email: $email,
            password: $this->faker->password(),
            file: $file,
        );

        $expected_post_count = 1;
        $data = User::where('email', $email)->get()->toArray();

        $this->assertEquals($expected_post_count, count($data));
        $this->assertEquals($user_name, $data[0]['name']);
    }
}
