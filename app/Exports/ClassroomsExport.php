<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClassroomsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $classroomId;

    public function __construct($classroomId)
    {
        $this->classroomId = $classroomId;
    }

    public function collection()
    {
        return Student::whereHas('classroom', function($query) {
            $query->where('classroom_id', $this->classroomId)
                ->whereIn('score', ['عالی', 'خوب']);
        })->get();
    }
    public function headings(): array
    {
        return [
            'name',
            'father_name',
            'mobile',
            'birth_date',
        ];
    }

    public function map($student): array
    {
        return [
            $student->firstName.' '.$student->lastName,
            $student->fatherName,
            explode('-',$student->mobile,2)[1],
            $student->birthDate,
        ];
    }
}
