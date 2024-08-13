<?php declare(strict_types=1);

namespace Tests\Unit\Auth;

use App\GraphQL\Mutations\AuthMutator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class LoginTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testLoginSuccessful()
    {
        // Arrange
        $email = 'graphql@example.com';
        $password = 'secret';
        $hashedPassword = Hash::make($password);

        // Mock the User model
        $user = Mockery::mock(User::class);
        $user->shouldReceive('createToken')->with('web')->andReturn((object)['plainTextToken' => 'token']);
        $user->shouldReceive('getAttribute')->with('password')->andReturn($hashedPassword);

        // Mock the User query
        $userModel = Mockery::mock(User::class);
        $userModel->shouldReceive('where')->with('email', $email)->andReturnSelf();
        $userModel->shouldReceive('first')->andReturn($user);

        // Mock the Hash facade
        $authMutator = new AuthMutator();

        // Act
        $token = $authMutator->login(null, ['email' => $email, 'password' => $password]);

        // Assert
        $this->assertNotNull($token);
    }

    public function testLoginFailsWithInvalidCredentials()
    {
        // Arrange
        $email = 'test@example.com';
        $password = 'wrongpassword';
        $hashedPassword = Hash::make('password');

        // Mock the User model
        $user = Mockery::mock(User::class);
        $user->shouldReceive('where')->with('email', $email)->andReturnSelf();
        $user->shouldReceive('first')->andReturn($user);
        $user->shouldReceive('getAttribute')->with('password')->andReturn($hashedPassword);

        // Mock the Hash facade
        Hash::shouldReceive('check')->with($password, $hashedPassword)->andReturn(false);

        $authMutator = new AuthMutator();

        // Assert
        $this->expectException(ValidationException::class);

        // Act
        $authMutator->login(null, ['email' => $email, 'password' => $password]);
    }
}
