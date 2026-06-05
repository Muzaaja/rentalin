<?php

namespace Database\Seeders;

use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Membuat data pembayaran dummy berdasarkan rental.
     *
     * payment_type:
     * - full = bayar penuh
     * - paylater = cicilan
     *
     * installment_plan:
     * - 2 = cicilan 2x selama 14 hari
     * - 4 = cicilan 4x selama 14 hari
     */
    public function run(): void
    {
        $payments = [
            'TRX-20260901-0042' => [
                'payment_method' => 'COD',
                'payment_type' => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
                'payment_status' => 'paid',
                'status' => 'paid',
            ],

            'TRX-20260828-0187' => [
                'payment_method' => 'Paylater',
                'payment_type' => 'paylater',
                'installment_plan' => 2,
                'installment_paid' => 1,
                'installment_due_days' => 14,
                'next_due_date' => '2026-09-11',
                'payment_status' => 'partially_paid',
                'status' => 'pending',
            ],

            'TRX-20260901-0043' => [
                'payment_method' => 'Paylater',
                'payment_type' => 'paylater',
                'installment_plan' => 4,
                'installment_paid' => 2,
                'installment_due_days' => 14,
                'next_due_date' => '2026-09-15',
                'payment_status' => 'partially_paid',
                'status' => 'pending',
            ],

            'TRX-20260901-0044' => [
                'payment_method' => 'Transfer Bank',
                'payment_type' => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
                'payment_status' => 'paid',
                'status' => 'paid',
            ],

            'TRX-20260828-0188' => [
                'payment_method' => 'COD',
                'payment_type' => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
                'payment_status' => 'pending',
                'status' => 'failed',
            ],

            'TRX-20260901-0045' => [
                'payment_method' => 'Paylater',
                'payment_type' => 'paylater',
                'installment_plan' => 2,
                'installment_paid' => 2,
                'installment_due_days' => 14,
                'next_due_date' => null,
                'payment_status' => 'paid',
                'status' => 'paid',
            ],

            'TRX-20260901-0046' => [
                'payment_method' => 'Transfer Bank',
                'payment_type' => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
                'payment_status' => 'paid',
                'status' => 'paid',
            ],

            'TRX-20260828-0189' => [
                'payment_method' => 'Paylater',
                'payment_type' => 'paylater',
                'installment_plan' => 4,
                'installment_paid' => 1,
                'installment_due_days' => 14,
                'next_due_date' => '2026-09-12',
                'payment_status' => 'partially_paid',
                'status' => 'pending',
            ],

            'TRX-20260828-0190' => [
                'payment_method' => 'COD',
                'payment_type' => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
                'payment_status' => 'paid',
                'status' => 'paid',
            ],

            'TRX-20260901-0047' => [
                'payment_method' => 'Paylater',
                'payment_type' => 'paylater',
                'installment_plan' => 4,
                'installment_paid' => 4,
                'installment_due_days' => 14,
                'next_due_date' => null,
                'payment_status' => 'paid',
                'status' => 'paid',
            ],

            'TRX-20260901-0048' => [
                'payment_method' => 'COD',
                'payment_type' => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
                'payment_status' => 'pending',
                'status' => 'failed',
            ],

            'TRX-20260901-0049' => [
                'payment_method' => 'Transfer Bank',
                'payment_type' => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
                'payment_status' => 'paid',
                'status' => 'paid',
            ],

            'TRX-20260901-0050' => [
                'payment_method' => 'Paylater',
                'payment_type' => 'paylater',
                'installment_plan' => 2,
                'installment_paid' => 0,
                'installment_due_days' => 14,
                'next_due_date' => '2026-09-14',
                'payment_status' => 'pending',
                'status' => 'pending',
            ],
        ];

        foreach ($payments as $rentalCode => $data) {
            $rental = Rental::where('rental_code', $rentalCode)->first();

            if (!$rental) {
                continue;
            }

            Payment::updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'payment_method' => $data['payment_method'],
                    'payment_type' => $data['payment_type'],
                    'installment_plan' => $data['installment_plan'],
                    'installment_paid' => $data['installment_paid'],
                    'installment_due_days' => $data['installment_due_days'],
                    'next_due_date' => $data['next_due_date'],
                    'payment_status' => $data['payment_status'],
                    'amount' => $rental->total_price,
                    'status' => $data['status'],
                ]
            );
        }
    }
}