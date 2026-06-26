<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_user_has_role_returns_admin_type_only_for_level_one(): void
    {
        $this->assertSame(User::DEFAULT_TYPE, (new User(['level' => 0]))->hasRole());
        $this->assertSame(User::ADMIN_TYPE, (new User(['level' => 1]))->hasRole());
        $this->assertSame(User::DEFAULT_TYPE, (new User(['level' => 2]))->hasRole());
        $this->assertSame(User::DEFAULT_TYPE, (new User(['level' => 99]))->hasRole());
    }

    public function test_user_has_role_sets_session_level_marker(): void
    {
        (new User(['level' => 1]))->hasRole();

        $this->assertSame(User::DEFAULT_TYPE, session('level'));
    }
}
