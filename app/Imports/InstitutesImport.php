<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Institute;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Morilog\Jalali\Jalalian;

class InstitutesImport implements ToCollection, WithHeadingRow
{
    private $errorHandling;
    private $user;
    private $batchSize = 1000; // حجم دسته‌ها

    public function __construct($errorHandling, $user)
    {
        $this->errorHandling = $errorHandling;
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        $chunks = $rows->chunk($this->batchSize);

        foreach ($chunks as $chunk) {
            DB::transaction(function () use ($chunk) {
                $countries = Country::pluck('id', 'ISO2')->toArray();
                $users = $this->user ? User::pluck('id', 'username')->toArray() : [];

                foreach ($chunk as $rowIndex => $row) {
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

                        $country_id = $countries[$row['country']] ?? null;
                        $user_id = $this->user ? null : ($users[$row['setby']] ?? null);

                        $endTS = '';
                        $startTS = '';
                        if (!isset($errors['startts'])) {
                            $startTS = Jalalian::fromFormat('Y/n/j', $row['startts'])->getTimestamp();
                        }
                        if (!isset($errors['endts'])) {
                            $endTS = Jalalian::fromFormat('Y/n/j', $row['endts'])->getTimestamp();
                        }

                        $instituteData = [
                            'name' => $row['nameinstitute'],
                            'country_id' => $country_id,
                            'city' => $row['city'],
                            'address' => $row['address'],
                            'mobile' => $row['mobile'],
                            'whatsapp' => $row['whatsapp'],
                            'email' => $row['email'],
                            'admin' => $row['admin'],
                            'adminmail' => $row['adminmail'],
                            'interface' => $row['interface'],
                            'interfacemail' => $row['interfacemail'],
                            'AboutInstitute' => $row['aboutinstitute'],
                            'description' => $row['description'],
                            'classInstituteType_s' => $row['typeinstitute'],
                            'modelinstitute' => $row['modelinstitute'],
                            'ActivityInstitute_s' => $row['activity'],
                            'contacts' => $row['contacts'],
                            'religious_s' => $row['religion'],
                            'religion2_s' => $row['religion2'],
                            'language_s' => $row['language'],
                            'AssessmentInstitute_s' => $row['assessment'],
                            'company' => $row['company'],
                            'support' => $row['support'],
                            'supportinterface' => $row['supportinterface'],
                            'timeinterface' => $row['timeinterface'],
                            'resultinterface' => $row['resultinterface'],
                            'user_id' => $user_id,
                            'startTS' => $startTS,
                            'endTS' => $endTS,
                            'excel' => 1,
                        ];

                        if ($this->errorHandling == 'set' && $errors) {
                            foreach ($errors as $field => $error) {
                                unset($instituteData[$field]);
                            }
                        }

                        Institute::create($instituteData);

                        Log::info("Institute at row $rowIndex successfully imported.");
                        Storage::append('upload_log_institute.txt',"----Institute at row $rowIndex successfully imported at " . now() . "\n");
                    } catch (Exception $e) {
                        Log::error("Failed to import institute at row $rowIndex: " . $e->getMessage());
                        Storage::append('upload_log_institute.txt', "Failed to import institute at row $rowIndex: " . $e->getMessage() . " at " . now() . "\n");
                    }
                }
            });
        }
    }

    private function validateRow($row)
    {
        $errors = [];

        if (!$row['nameinstitute']) $errors['nameinstitute'] = 'Invalid nameinstitute';
        if (!$row['country']) $errors['country'] = 'Invalid country';
        if (!$row['city']) $errors['city'] = 'Invalid city';
        if (!$row['address']) $errors['address'] = 'Invalid address';
        if (!$row['mobile']) $errors['mobile'] = 'Invalid mobile';
        if (!$row['whatsapp']) $errors['whatsapp'] = 'Invalid whatsapp';
        if (!$row['email']) $errors['email'] = 'Invalid email';
        if (!$row['admin']) $errors['admin'] = 'Invalid admin';
        if (!$row['adminmail']) $errors['adminmail'] = 'Invalid adminmail';
        if (!$row['interface']) $errors['interface'] = 'Invalid interface';
        if (!$row['interfacemail']) $errors['interfacemail'] = 'Invalid interfacemail';
        if (!$row['aboutinstitute']) $errors['aboutinstitute'] = 'Invalid AboutInstitute';
        if (!$row['description']) $errors['description'] = 'Invalid description';
        if (!$row['typeinstitute']) $errors['typeinstitute'] = 'Invalid typeinstitute';
        if (!$row['modelinstitute']) $errors['modelinstitute'] = 'Invalid modelinstitute';
        if (!$row['activity']) $errors['activity'] = 'Invalid activity';
        if (!$row['contacts']) $errors['contacts'] = 'Invalid contacts';
        if (!$row['religion']) $errors['religion'] = 'Invalid religion';
        if (!$row['religion2']) $errors['religion2'] = 'Invalid religion2';
        if (!$row['language']) $errors['language'] = 'Invalid language';
        if (!$row['assessment']) $errors['assessment'] = 'Invalid assessment';
        if (!$row['company']) $errors['company'] = 'Invalid company';
        if (!$row['support']) $errors['support'] = 'Invalid support';
        if (!$row['supportinterface']) $errors['supportinterface'] = 'Invalid supportinterface';
        if (!$row['timeinterface']) $errors['timeinterface'] = 'Invalid timeinterface';
        if (!$row['resultinterface']) $errors['resultinterface'] = 'Invalid resultinterface';
        if (!$this->user && !$row['setby']) $errors['setby'] = 'Invalid setBy';
        if (!$row['startts']) {
            $errors['startts'] = 'Invalid startTS';
        } else {
            try {
                Jalalian::fromFormat('Y/n/j', $row['startts'])->getTimestamp();
            } catch (Exception $e) {
                $errors['startts'] = 'Invalid format startTS';
            }
        }
        if (!$row['endts']) {
            $errors['endts'] = 'Invalid endTS';
        } else {
            try {
                Jalalian::fromFormat('Y/n/j', $row['endts'])->getTimestamp();
            } catch (Exception $e) {
                $errors['endts'] = 'Invalid format endTS';
            }
        }

        return $errors;
    }
}
