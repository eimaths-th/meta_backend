<?php

namespace Tests\Unit;

use App\Services\StatusServiceOptimized;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class StatusServiceOptimizedTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_it_returns_none_receipt_when_student_has_no_school_prices(): void
    {
        Carbon::setTestNow('2026-06-15');

        $statuses = (new StatusServiceOptimized())->determineStatus($this->student(), collect());

        $this->assertSame('None Receipt', $statuses[0]['N']['status']);
        $this->assertNull($statuses[0]['N']['schoolprice_id']);
    }

    public function test_it_marks_current_month_receipt_as_new_student(): void
    {
        Carbon::setTestNow('2026-06-15');

        $statuses = (new StatusServiceOptimized())->determineStatus($this->student(), collect([
            $this->schoolPrice(10, 'M', '2026-06', '2026-06-01'),
        ]));

        $this->assertSame('New Student', $statuses[0]['M']['status']);
        $this->assertSame(10, $statuses[0]['M']['schoolprice_id']);
    }

    public function test_it_marks_active_older_receipt_as_studying(): void
    {
        Carbon::setTestNow('2026-06-15');

        $statuses = (new StatusServiceOptimized())->determineStatus($this->student(), collect([
            $this->schoolPrice(11, 'M', '2026-05 - 2026-07', '2026-05-01'),
        ]));

        $this->assertSame('studying . . .', $statuses[0]['M']['status']);
    }

    public function test_it_marks_long_expired_receipt_as_drop(): void
    {
        Carbon::setTestNow('2026-06-15');

        $statuses = (new StatusServiceOptimized())->determineStatus($this->student(), collect([
            $this->schoolPrice(12, 'M', '2026-01', '2026-01-01'),
        ]));

        $this->assertSame('drop', $statuses[0]['M']['status']);
    }

    private function student(): object
    {
        return (object) [
            'id' => 1,
            'status_log' => new Collection(),
        ];
    }

    private function schoolPrice(int $id, string $group, string $period, string $submissionDate): object
    {
        return (object) [
            'id' => $id,
            'group' => $group,
            'period' => $period,
            'rec_school' => (object) [
                'submission_date' => $submissionDate,
            ],
        ];
    }
}
