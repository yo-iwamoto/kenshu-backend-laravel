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

        $this->service->execute(
            name: $this->faker->name(),
            email: $email,
            password: $this->faker->password(),
            file: $file,
        );

        $data = User::where('email', $email)->get()->toArray();

        $this->assertEquals(count($data), 1);
    }
}
