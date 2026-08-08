<?php

namespace Tests\Unit;

use App\Helpers\LogActivity;
use PHPUnit\Framework\TestCase;

class LogActivityTest extends TestCase
{
    public function test_it_truncates_long_in_app_browser_user_agents_to_database_limit(): void
    {
        $userAgent = str_repeat('Facebook-iOS;', 30);

        $truncated = TestableLogActivity::truncateUserAgentForTest($userAgent);

        $this->assertSame(255, mb_strlen($truncated));
        $this->assertSame(mb_substr($userAgent, 0, 255), $truncated);
    }

    public function test_it_keeps_missing_user_agent_nullable(): void
    {
        $this->assertNull(TestableLogActivity::truncateUserAgentForTest(null));
    }
}

class TestableLogActivity extends LogActivity
{
    public static function truncateUserAgentForTest(?string $userAgent): ?string
    {
        return parent::truncateUserAgent($userAgent);
    }
}
