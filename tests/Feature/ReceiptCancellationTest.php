<?php

namespace Tests\Feature;

use App\Models\Receipt;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReceiptCancellationTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $this->user = User::create([
            'name' => 'Receipt cancellation test user',
            'email' => 'receipt-cancellation-'.uniqid().'@example.com',
            'password' => bcrypt('test-password'),
            'level' => 1,
        ]);
        $this->actingAs($this->user);
    }

    public function test_issued_receipt_is_cancelled_without_being_deleted(): void
    {
        $receipt = $this->createReceipt();

        $this->patchJson(route('receipts.cancel', $receipt->id), [
            'reason' => 'Duplicate payment record',
        ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'cancelled');

        $this->assertDatabaseHas('receipts', [
            'id' => $receipt->id,
            'receipt_number' => 'TEST2608001',
            'receipt_customer_number' => 'TEST001',
            'cancle' => 1,
            'cancelled_by' => $this->user->id,
            'cancel_reason' => 'Duplicate payment record',
        ]);
    }

    public function test_cancellation_requires_a_reason(): void
    {
        $receipt = $this->createReceipt();

        $this->patchJson(route('receipts.cancel', $receipt->id), [])
            ->assertStatus(422);

        $this->assertDatabaseHas('receipts', [
            'id' => $receipt->id,
            'cancle' => 0,
        ]);
    }

    public function test_cancelled_receipt_cannot_be_cancelled_twice_or_edited(): void
    {
        $receipt = $this->createReceipt();

        $this->patchJson(route('receipts.cancel', $receipt->id), [
            'reason' => 'Initial cancellation',
        ])->assertOk();

        $this->patchJson(route('receipts.cancel', $receipt->id), [
            'reason' => 'Second cancellation',
        ])->assertStatus(422);

        $this->getJson(route('receipts.edit', [
            'id' => $receipt->id,
            'type' => 1,
        ]))->assertStatus(422);
    }

    public function test_issued_receipt_delete_endpoint_is_rejected(): void
    {
        $receipt = $this->createReceipt();

        $this->deleteJson(route('receipts.destroy', $receipt->id))
            ->assertStatus(405);

        $this->assertDatabaseHas('receipts', ['id' => $receipt->id]);
    }

    private function createReceipt(): Receipt
    {
        return Receipt::create([
            'type' => 1,
            'sfield' => '17',
            'submission_date' => '2026-08-24',
            'receipt_number' => 'TEST2608001',
            'receipt_customer_number' => 'TEST001',
            'first_name' => 'Cancel',
            'last_name' => 'Customer',
            'cancle' => false,
        ]);
    }
}
