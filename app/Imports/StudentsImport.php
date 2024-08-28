<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Country;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Morilog\Jalali\Jalalian;

class StudentsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    private $errorHandling;
    private $user;
    private $countries;
    private $users;
    private $batchSize = 500;

    public function __construct($errorHandling, $user)
    {
        $this->errorHandling = $errorHandling;
        $this->user = $user;
        $this->countries = Country::pluck('id', 'ISO2')->toArray();
        $this->users = $this->user ? User::pluck('id', 'username')->toArray() : [];
    }

    public function model(array $row)
    {
        set_time_limit(0);
        ini_set('max_execution_time', '300');
        ini_set('memory_limit', '2048M');
        static $lineNumber = 1;
        try {
            $errors = $this->validateRow($row);
            $now = Jalalian::now()->format('Y/m/d H:i:s');

            if ($this->errorHandling == 'notSetAll' && $errors) {
                //Log::error("Errors found in row: " . implode(', ', $errors));
                Storage::append('upload_log.txt', "Errors found in row ".$lineNumber." Import aborted at " . $now . " (errors :" . implode(', ', $errors) . ")\n");
                $lineNumber++;
                return null;
            }

            if ($this->errorHandling == 'notSetStu' && $errors) {
                //Log::warning("Skipping student in row: ".$lineNumber." due to errors: " . implode(', ', $errors));
                Storage::append('upload_log.txt', "Errors found in row ".$lineNumber." Import aborted at " . $now . " (errors :" . implode(', ', $errors) . ")\n");
                $lineNumber++;
                return null;
            }

            if ($row['mobile'] && Student::where('mobile', $row['mobile'])->exists()) {
                //Log::warning("Skipping student due to duplicate mobile number in row: ".$lineNumber);
                Storage::append('upload_log.txt', "Skipping student due to duplicate mobile number in row: ".$lineNumber."\n");
                $lineNumber++;
                return null;
            }

            $country_id = $this->countries[$row['country']] ?? null;
            $nationality_id = $this->countries[$row['nationality']] ?? null;

            $user_id = '';
            $startTS = '';

            if ($this->user) {
                if (!isset($errors['startts'])) {
                    $startTS = Jalalian::fromFormat('Y/n/j', $row['startts'])->getTimestamp();
                }
            } else {
                if ($row['setby']) {
                    $user_id = $this->users[$row['setby']] ?? null;
                }
                if (!isset($errors['startts'])) {
                    $startTS = Jalalian::fromFormat('Y/n/j', $row['startts'])->getTimestamp();
                }
            }

            $studentData = [
                'firstName' => $row['firstname'],
                'lastName' => $row['lastname'],
                'country_id' => $country_id,
                'city' => $row['city'],
                'nationality_id' => $nationality_id,
                'language_s' => $row['language'],
                'birthYear' => $row['birthyear'],
                'sex_s' => $row['sex'],
                'isMarried' => $row['ismarried'] == 'مجرد' ? 0 : 1,
                'job' => $row['job'],
                'education_s' => $row['education'],
                'email' => $row['email'],
                'mobile' => $row['mobile'],
                'religious_s' => $row['religion1'],
                'religion2_s' => $row['religion2'],
                'address' => $row['address'],
                'user_id' => $user_id,
                'startTS' => $startTS,
                'isManageable' => $row['ismanageable'] == 'ندارد' ? 0 : 1,
                'canDoAct' => $row['candoact'] == 'ندارد' ? 0 : 1,
                'publicRelation' => $row['publicrelation'] == 'ضعیف' ? 0 : 1,
                'opinionAboutIran' => $row['opinionaboutiran'],
                'donation' => $row['donation'],
                'character' => $row['character'],
                'aboutStudent' => $row['aboutstudent'],
                'skill' => $row['skill'],
                'allergie' => $row['allergie'],
                'ext' => $row['ext'],
                'excel' => 1,
            ];

            if ($this->errorHandling == 'set' && $errors) {
                foreach ($errors as $field => $error) {
                    unset($studentData[$field]);
                }
            }
            Log::info("Student successfully imported in row: " . $lineNumber);
            Storage::append('upload_log.txt',"----Student in row: ". $lineNumber ." successfully imported at " . $now . "\n");
            $lineNumber++;
            return new Student($studentData);

        } catch (Exception $e) {
            Log::error("Failed to import student: " . $e->getMessage());
            Storage::append('upload_log.txt', "Failed to import student: " . $e->getMessage() . " at " . $now . "\n");
        }

        return null;
    }

    public function chunkSize(): int
    {
        return $this->batchSize;
    }

    private function validateRow($row)
    {
        $errors = [];

        if (!$row['firstname']) $errors['firstname'] = 'Invalid first name';
        if (!$row['lastname']) $errors['lastname'] = 'Invalid last name';
        if (!$row['country']) $errors['country'] = 'Invalid country';
        if (!$row['city']) $errors['city'] = 'Invalid city';
        if (!$row['nationality']) $errors['nationality'] = 'Invalid nationality';
        if (!$row['language']) $errors['language'] = 'Invalid language';
        if (!$row['birthyear']) $errors['birthyear'] = 'Invalid birthYear';
        if (!$row['sex']) $errors['sex'] = 'Invalid sex';
        if (!$row['ismarried']) $errors['ismarried'] = 'Invalid isMarried';
        if (!$row['job']) $errors['job'] = 'Invalid job';
        if (!$row['education']) $errors['education'] = 'Invalid education';
        if (!$row['email']) $errors['email'] = 'Invalid email';
        if (!$row['mobile']) $errors['mobile'] = 'Invalid mobile';
        if (!$row['religion1']) $errors['religion1'] = 'Invalid religion1';
        if (!$row['religion2']) $errors['religion2'] = 'Invalid religion2';
        if (!$row['address']) $errors['address'] = 'Invalid address';
        if (!$this->user) if (!$row['setby']) $errors['setby'] = 'Invalid setBy';
        if (!$row['startts']) {
            $errors['startts'] = 'Invalid startTS';
        } else {
            try {
                Jalalian::fromFormat('Y/n/j', $row['startts'])->getTimestamp();
            } catch (Exception $e) {
                $errors['startts'] = 'Invalid format startTS';
            }
        }
        if (!$row['ismanageable']) $errors['ismanageable'] = 'Invalid isManageable';
        if (!$row['candoact']) $errors['candoact'] = 'Invalid canDoAct';
        if (!$row['publicrelation']) $errors['publicrelation'] = 'Invalid publicRelation';
        if (!$row['opinionaboutiran']) $errors['opinionaboutiran'] = 'Invalid opinionAboutIran';
        if (!$row['donation']) $errors['donation'] = 'Invalid donation';
        if (!$row['character']) $errors['character'] = 'Invalid character';
        if (!$row['aboutstudent']) $errors['aboutstudent'] = 'Invalid aboutStudent';
        if (!$row['skill']) $errors['skill'] = 'Invalid skill';
        if (!$row['allergie']) $errors['allergie'] = 'Invalid allergie';
        if (!$row['ext']) $errors['ext'] = 'Invalid ext';


        return $errors;
    }
}
