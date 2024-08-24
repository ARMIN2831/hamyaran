<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentsImport implements ToCollection
{
    private $errorHandling;
    private $user;

    public function __construct($errorHandling,$user)
    {
        $this->errorHandling = $errorHandling;
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            $countries = Country::get();
            $users = User::get();
            foreach ($rows as $rowIndex => $row) {
                try {
                    $errors = $this->validateRow($row);

                    if ($this->errorHandling == 'notSetAll' && $errors) {
                        Log::error("Errors found at row $rowIndex, skipping entire import. errors: " . implode(', ', $errors));
                        Storage::append('upload_log.txt', "Errors found at row $rowIndex. Import aborted at " . now() . " (errors :" . implode(', ', $errors) . ")\n");
                        return;
                    }

                    if ($this->errorHandling == 'notSetStu' && $errors) {
                        Log::warning("Skipping student at row $rowIndex due to errors: " . implode(', ', $errors));
                        Storage::append('upload_log.txt', "Errors found at row $rowIndex. Import aborted at " . now() . " (errors :" . implode(', ', $errors) . ")\n");
                        continue;
                    }
                    $country_id = '';
                    $nationality_id = '';
                    if ($row[2]){
                        foreach ($countries as $country)
                            if ($country->ISO2 == $row[2]){
                                $country_id = $country->id;
                                break;
                            }
                    }
                    if ($row[4]){
                        foreach ($countries as $country)
                            if ($country->ISO2 == $row[2]){
                                $nationality_id = $country->id;
                                break;
                            }
                    }
                    $user_id = '';
                    if ($this->user){
                        $startTS = $row[16];
                    }else{
                        if ($row[16]){
                            foreach ($users as $user)
                                if ($user->email == $row[16]){
                                    $user_id = $user->id;
                                    break;
                                }
                        }
                        $startTS = $row[17];
                    }

                    $studentData = [
                        'firstName' => $row[0],
                        'lastName' => $row[1],
                        'country_id' => $country_id,
                        'city' => $row[3],
                        'nationality_id' => $nationality_id,
                        'language_s' => $row[5],
                        'birthYear' => $row[6],
                        'sex_s' => $row[7],
                        'isMarried' => $row[8] == 'مجرد' ? 0 : 1,
                        'job' => $row[9],
                        'education_s' => $row[10],
                        'email' => $row[11],
                        'mobile' => $row[12],
                        'religious_s' => $row[13],
                        'religion2_s' => $row[14],
                        'address' => $row[15],
                        'user_id' => $user_id,
                        'startTS' => $startTS,
                        'excel' => 1,
                    ];

                    if ($this->errorHandling == 'set' && $errors) {
                        foreach ($errors as $field => $error) {
                            unset($studentData[$field]);
                        }
                    }

                    Student::create($studentData);

                    Log::info("Student at row $rowIndex successfully imported.");
                } catch (Exception $e) {
                    Log::error("Failed to import student at row $rowIndex: " . $e->getMessage());
                    Storage::append('upload_log.txt', "Failed to import student at row $rowIndex: " . $e->getMessage() . " at " . now() . "\n");
                }
            }
        });

        Storage::append('upload_log.txt', "File processed successfully at " . now() . "\n");
    }

    private function validateRow($row)
    {
        $errors = [];

        if (!$row[0]) $errors['firstName'] = 'Invalid first name';
        if (!$row[1]) $errors['lastName'] = 'Invalid last name';
        if (!$row[2]) $errors['country'] = 'Invalid country';
        if (!$row[3]) $errors['city'] = 'Invalid city';
        if (!$row[4]) $errors['nationality'] = 'Invalid nationality';
        if (!$row[5]) $errors['language'] = 'Invalid language';
        if (!$row[6]) $errors['birthYear'] = 'Invalid birthYear';
        if (!$row[7]) $errors['sex'] = 'Invalid sex';
        if (!$row[8]) $errors['isMarried'] = 'Invalid isMarried';
        if (!$row[9]) $errors['job'] = 'Invalid job';
        if (!$row[10]) $errors['education'] = 'Invalid education';
        if (!$row[11]) $errors['email'] = 'Invalid email';
        if (!$row[12]) $errors['mobile'] = 'Invalid mobile';
        if (!$row[13]) $errors['religion1'] = 'Invalid religion1';
        if (!$row[14]) $errors['religion2'] = 'Invalid religion2';
        if (!$row[15]) $errors['address'] = 'Invalid address';
        if (!$this->user) if (!$row[16]) $errors['setBy'] = 'Invalid setBy';
        if (!$row[17]) $errors['startTS'] = 'Invalid startTS';
        return $errors;
    }
}
