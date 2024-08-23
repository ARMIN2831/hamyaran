<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection,WithHeadings
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students;
    }

    public function headings(): array
    {
        return [
            'id',
            'firstName',
            'lastName',
            'country_id',
            'city',
            'nationality_id',
            'language',
            'birthYear',
            'sex',
            'isMarried',
            'job',
            'education',
            'email',
            'mobile',
            'profileImg',
            'passportImg',
            'evidenceImg',
            'religious',
            'religion2',
            'opinionAboutIran',
            'isManageable',
            'canDoAct',
            'publicRelation',
            'financialSituation',
            'donation',
            'character',
            'aboutStudent',
            'skill',
            'allergie',
            'address',
            'ext',
            'user_id',
            'startTS',
            'endTS',
            //'created_at',
            //'updated_at',
        ];
    }
}
