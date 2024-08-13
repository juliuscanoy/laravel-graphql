<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final readonly class AuthMutator
{
    /** @param  array{}  $args */
    public function login(null $_, array $args)
    {
        $user = User::where('email', $args['email'])->first();
     
        if (! $user || ! Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        return $user->createToken('web')->plainTextToken;
    }

    /** @param  array{}  $args */
    public function logout(null $_, array $args, GraphQLContext $context)
    {
        $context->user()->tokens()->delete();

        return 'Logged out successfully';

    }
}
