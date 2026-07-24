<?php

namespace App\Exports;

use App\Models\Referral;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;

class ReferralsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $search;
    protected $fromDate;
    protected $toDate;

    public function __construct($search = null, $fromDate = null, $toDate = null)
    {
        $this->search = $search;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function query()
    {
        $query = Referral::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('student_id', 'like', '%' . $this->search . '%')
                  ->orWhere('referral_code', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->fromDate)->startOfDay(),
                Carbon::parse($this->toDate)->endOfDay()
            ]);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Student ID',
            'Referral Code',
            'Screenshot Path',
            'Submitted At',
        ];
    }

    public function map($referral): array
    {
        return [
            $referral->id,
            $referral->student_id,
            $referral->referral_code,
            $referral->screenshot,
            $referral->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
