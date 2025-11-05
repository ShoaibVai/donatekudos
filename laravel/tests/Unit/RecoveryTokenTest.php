<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\RecoveryToken;
use Illuminate\Support\Str;

class RecoveryTokenTest extends TestCase
{
    /**
     * Test recovery token creation
     */
    public function test_recovery_token_creation(): void
    {
        $userId = Str::uuid();
        $secret = 'JBSWY3DPEBLW64TMMQ======';

        $token = RecoveryToken::create([
            'id' => Str::uuid(),
            'user_id' => $userId,
            'token' => $secret,
            'is_enabled' => true,
            'is_verified' => true,
        ]);

        $this->assertNotNull($token->id);
        $this->assertEquals($userId, $token->user_id);
        $this->assertTrue($token->is_enabled);
        $this->assertTrue($token->is_verified);
    }

    /**
     * Test recovery token is hidden by default
     */
    public function test_recovery_token_is_hidden(): void
    {
        $token = RecoveryToken::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'token' => 'SECRETTOKEN',
            'is_enabled' => true,
        ]);

        $tokenArray = $token->toArray();
        $this->assertArrayNotHasKey('token', $tokenArray);
    }

    /**
     * Test user_id uniqueness in recovery tokens
     */
    public function test_recovery_token_user_id_uniqueness(): void
    {
        $userId = Str::uuid();

        RecoveryToken::create([
            'id' => Str::uuid(),
            'user_id' => $userId,
            'token' => 'TOKEN1',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        RecoveryToken::create([
            'id' => Str::uuid(),
            'user_id' => $userId,
            'token' => 'TOKEN2',
        ]);
    }

    /**
     * Test recovery token enable/disable
     */
    public function test_recovery_token_enable_disable(): void
    {
        $token = RecoveryToken::create([
            'id' => Str::uuid(),
            'user_id' => Str::uuid(),
            'token' => 'TESTTOKEN',
            'is_enabled' => true,
        ]);

        $this->assertTrue($token->is_enabled);

        $token->update(['is_enabled' => false]);
        $token->refresh();

        $this->assertFalse($token->is_enabled);
    }
}
