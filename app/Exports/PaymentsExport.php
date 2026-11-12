<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Carbon;

class PaymentsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;
    protected $classId;
    protected $fromDate;
    protected $toDate;
    protected $status;
    protected $paymentMethod;
    protected $studentId;
    private $rowNumber = 0;

    public function __construct($search = null, $classId = null, $fromDate = null, $toDate = null, $status = null, $paymentMethod = null, $studentId = null)
    {
        $this->search = $search;
        $this->classId = $classId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->status = $status;
        $this->paymentMethod = $paymentMethod;
        $this->studentId = $studentId;
    }

    public function query()
    {
        $query = Transaction::with(['student.groundPartner', 'class'])->latest('created_at');

        if (!empty($this->studentId)) {
            $query->where('student_id', $this->studentId);
        }

        if (!empty($this->search)) {
            $search = trim($this->search);
            $query->where(function ($q) use ($search) {
                $q->where('razorpay_payment_id', 'like', "%{$search}%")
                  ->orWhere('razorpay_order_id', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('student_name', 'like', "%{$search}%")
                         ->orWhere('student_id', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('mobile', 'like', "%{$search}%");
                  })
                  ->orWhereHas('class', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($this->classId)) {
            $query->where('class_id', $this->classId);
        }

        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->fromDate)->startOfDay(),
                Carbon::parse($this->toDate)->endOfDay()
            ]);
        } elseif (!empty($this->fromDate)) {
            $query->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay());
        } elseif (!empty($this->toDate)) {
            $query->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->paymentMethod)) {
            $query->where('payment_method', $this->paymentMethod);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'SL',
            'Transaction ID',
            'Razorpay Payment ID',
            'Razorpay Order ID',
            'Student ID',
            'Student Name',
            'Email',
            'Phone',
            'Class',
            'Amount (INR)',
            'Payment Method',
            'Status',
            'Referred By (GP)',
            'Payment Date & Time',
        ];
    }

    public function map($tx): array
    {
        $this->rowNumber++;

        $gpInfo = 'N/A';
        if ($tx->student && $tx->student->groundPartner) {
            $gpInfo = $tx->student->groundPartner->name . ' (' . ($tx->student->groundPartner->code ?? 'GP') . ')';
        }

        return [
            $this->rowNumber,
            $tx->id,
            $tx->razorpay_payment_id ?? 'N/A',
            $tx->razorpay_order_id ?? 'N/A',
            $tx->student->student_id ?? 'N/A',
            $tx->student->student_name ?? 'N/A',
            $tx->student->email ?? 'N/A',
            $tx->student->mobile ?? 'N/A',
            $tx->class->name ?? 'N/A',
            number_format($tx->amount, 2, '.', ''),
            $tx->payment_method ? ucfirst($tx->payment_method) : 'Online',
            ucfirst($tx->status ?? 'success'),
            $gpInfo,
            $tx->created_at ? $tx->created_at->format('d-m-Y h:i A') : 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '696CFF'], // Sneat primary purple
                ],
            ],
        ];
    }
}

