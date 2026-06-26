<?php

namespace Tests\Unit;

use App\Models\History;
use App\Models\HistorySave;
use App\Models\WorktimeLogs;
use PHPUnit\Framework\TestCase;

class ModelAccessorTest extends TestCase
{
    public function test_history_full_time_accessor_joins_start_and_end_times(): void
    {
        $history = new History(['stime' => '08:30', 'etime' => '10:00']);
        $historySave = new HistorySave(['stime' => '13:00', 'etime' => '14:30']);

        $this->assertSame('08:30 - 10:00', $history->full_time);
        $this->assertSame('13:00 - 14:30', $historySave->full_time);
    }

    public function test_worktime_log_accessors_include_available_times(): void
    {
        $log = new WorktimeLogs([
            'old_stime' => '09:00',
            'old_etime' => '18:00',
            'new_stime' => '10:00',
            'new_etime' => null,
        ]);

        $this->assertStringContainsString('09:00', $log->old_full_time);
        $this->assertStringContainsString('18:00', $log->old_full_time);
        $this->assertStringContainsString('10:00', $log->new_full_time);
    }

    public function test_worktime_log_accessors_report_missing_times_without_throwing(): void
    {
        $log = new WorktimeLogs();

        $this->assertIsString($log->old_full_time);
        $this->assertIsString($log->new_full_time);
        $this->assertNotSame('', $log->old_full_time);
        $this->assertNotSame('', $log->new_full_time);
    }
}
