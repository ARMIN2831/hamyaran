<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Institute;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class InstitutesImport implements ToCollection
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
                        Storage::append('upload_log_institute.txt', "Errors found at row $rowIndex. Import aborted at " . now() . " (errors :" . implode(', ', $errors) . ")\n");
                        return;
                    }

                    if ($this->errorHandling == 'notSetStu' && $errors) {
                        Log::warning("Skipping institute at row $rowIndex due to errors: " . implode(', ', $errors));
                        Storage::append('upload_log_institute.txt', "Errors found at row $rowIndex. Import aborted at " . now() . " (errors :" . implode(', ', $errors) . ")\n");
                        continue;
                    }
                    $country_id = '';
                    if ($row[1]){
                        foreach ($countries as $country)
                            if ($country->ISO2 == $row[1]){
                                $country_id = $country->id;
                                break;
                            }
                    }

                    $user_id = '';
                    if ($this->user){
                        $startTS = $row[26];
                        $endTS = $row[27];
                    }else{
                        if ($row[26]){
                            foreach ($users as $user)
                                if ($user->email == $row[26]){
                                    $user_id = $user->id;
                                    break;
                                }
                        }
                        $startTS = $row[27];
                        $endTS = $row[28];
                    }

                    $InstituteData = [
                        'name' => $row[0],
                        'country_id' => $country_id,
                        'city' => $row[2],
                        'address' => $row[3],
                        'mobile' => $row[4],
                        'whatsapp' => $row[5],
                        'email' => $row[6],
                        'admin' => $row[7],
                        'adminmail' => $row[8],
                        'interface' => $row[9],
                        'interfacemail' => $row[10],
                        'AboutInstitute' => $row[11],
                        'description' => $row[12],
                        'classInstituteType_s' => $row[13],
                        'modelinstitute' => $row[14],
                        'ActivityInstitute_s' => $row[15],
                        'contacts' => $row[16],
                        'religious_s' => $row[17],
                        'religion2_s' => $row[18],
                        'language_s' => $row[19],
                        'AssessmentInstitute_s' => $row[20],
                        'company' => $row[21],
                        'support' => $row[22],
                        'supportinterface' => $row[23],
                        'timeinterface' => $row[24],
                        'resultinterface' => $row[25],
                        'user_id' => $user_id,
                        'startTS' => $startTS,
                        'endTS' => $endTS,
                        'excel' => 1,
                    ];

                    if ($this->errorHandling == 'set' && $errors) {
                        foreach ($errors as $field => $error) {
                            unset($InstituteData[$field]);
                        }
                    }

                    Institute::create($InstituteData);

                    Log::info("Institute at row $rowIndex successfully imported.");
                } catch (Exception $e) {
                    Log::error("Failed to import institute at row $rowIndex: " . $e->getMessage());
                    Storage::append('upload_log_institute.txt', "Failed to import institute at row $rowIndex: " . $e->getMessage() . " at " . now() . "\n");
                }
            }
        });

        Storage::append('upload_log_institute.txt', "File processed successfully at " . now() . "\n");
    }

    private function validateRow($row)
    {
        $errors = [];

        if (!$row[0]) $errors['name'] = 'Invalid name';
        if (!$row[1]) $errors['country'] = 'Invalid country';
        if (!$row[2]) $errors['city'] = 'Invalid city';
        if (!$row[3]) $errors['address'] = 'Invalid address';
        if (!$row[4]) $errors['mobile'] = 'Invalid mobile';
        if (!$row[5]) $errors['whatsapp'] = 'Invalid whatsapp';
        if (!$row[6]) $errors['email'] = 'Invalid email';
        if (!$row[7]) $errors['admin'] = 'Invalid admin';
        if (!$row[8]) $errors['adminmail'] = 'Invalid adminmail';
        if (!$row[9]) $errors['interface'] = 'Invalid interface';
        if (!$row[10]) $errors['interfacemail'] = 'Invalid interfacemail';
        if (!$row[11]) $errors['AboutInstitute'] = 'Invalid AboutInstitute';
        if (!$row[12]) $errors['description'] = 'Invalid description';
        if (!$row[13]) $errors['typeinstitute'] = 'Invalid typeinstitute';
        if (!$row[14]) $errors['modelinstitute'] = 'Invalid modelinstitute';
        if (!$row[15]) $errors['activity'] = 'Invalid activity';
        if (!$row[16]) $errors['contacts'] = 'Invalid contacts';
        if (!$row[17]) $errors['religion'] = 'Invalid religion';
        if (!$row[18]) $errors['religion2'] = 'Invalid religion2';
        if (!$row[19]) $errors['language'] = 'Invalid language';
        if (!$row[20]) $errors['assessment'] = 'Invalid assessment';
        if (!$row[21]) $errors['company'] = 'Invalid company';
        if (!$row[22]) $errors['support'] = 'Invalid support';
        if (!$row[23]) $errors['supportinterface'] = 'Invalid supportinterface';
        if (!$row[24]) $errors['timeinterface'] = 'Invalid timeinterface';
        if (!$row[25]) $errors['resultinterface'] = 'Invalid resultinterface';
        if (!$this->user) if (!$row[26]) $errors['setBy'] = 'Invalid setBy';
        if (!$row[27]) $errors['startTS'] = 'Invalid startTS';
        if (!$row[28]) $errors['endTS'] = 'Invalid endTS';
        return $errors;
    }
}
