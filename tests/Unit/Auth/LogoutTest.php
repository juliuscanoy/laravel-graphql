<?php declare(strict_types=1);

namespace Tests\Unit\Auth;

use App\GraphQL\Mutations\AuthMutator;
use App\Models\User;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Mockery;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testLogoutSuccessful()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $user->shouldReceive('tokens')->andReturnSelf();
        $user->shouldReceive('delete')->once();

        $context = Mockery::mock(GraphQLContext::class);
        $context->shouldReceive('user')->andReturn($user);

        $authMutator = new AuthMutator();

        // Act
        $message = $authMutator->logout(null, [], $context);

        // Assert
        $this->assertEquals('Logged out successfully', $message);
    }
}
