<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Institute;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Morilog\Jalali\Jalalian;

class InstitutesImport implements ShouldQueue,ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithEvents
{
    private $errorHandling;
    private $user;
    private $countries;
    private $users;
    private $successCount;
    private $lineNumber;

    public function __construct($errorHandling, $user)
    {
        $this->errorHandling = $errorHandling;
        $this->user = $user;
        $this->countries = Country::pluck('id', 'ISO2')->toArray();
        $this->users = $this->user ? User::pluck('id', 'username')->toArray() : [];
        $this->successCount = 0;
        $this->lineNumber = 0;
    }

    public function model(array $row)
    {
        set_time_limit(60000);
        ignore_user_abort(true);
        ini_set('max_execution_time', '60000');
        ini_set('memory_limit', '2048M');
        try {
            $errors = [];

            if (!$row['nameinstitute']) $errors['nameinstitute'] = 'نام مؤسسه نامعتبر است';
            if (!$row['country']) $errors['country'] = 'کشور نامعتبر است';
            if (!$row['city']) $errors['city'] = 'شهر نامعتبر است';
            if (!$row['address']) $errors['address'] = 'آدرس نامعتبر است';
            if (!$row['mobile']) $errors['mobile'] = 'شماره موبایل نامعتبر است';
            if (!$row['whatsapp']) $errors['whatsapp'] = 'واتساپ نامعتبر است';
            if (!$row['email']) $errors['email'] = 'ایمیل نامعتبر است';
            if (!$row['admin']) $errors['admin'] = 'نام مدیر نامعتبر است';
            if (!$row['adminmail']) $errors['adminmail'] = 'ایمیل مدیر نامعتبر است';
            if (!$row['interface']) $errors['interface'] = 'واسط نامعتبر است';
            if (!$row['interfacemail']) $errors['interfacemail'] = 'ایمیل واسط نامعتبر است';
            if (!$row['aboutinstitute']) $errors['aboutinstitute'] = 'اطلاعات درباره مؤسسه نامعتبر است';
            if (!$row['description']) $errors['description'] = 'توضیحات نامعتبر است';
            if (!$row['typeinstitute']) $errors['typeinstitute'] = 'نوع مؤسسه نامعتبر است';
            if (!$row['modelinstitute']) $errors['modelinstitute'] = 'مدل مؤسسه نامعتبر است';
            if (!$row['activity']) $errors['activity'] = 'فعالیت نامعتبر است';
            if (!$row['contacts']) $errors['contacts'] = 'تماس‌ها نامعتبر است';
            if (!$row['religion']) $errors['religion'] = 'دین نامعتبر است';
            if (!$row['religion2']) $errors['religion2'] = 'دین دوم نامعتبر است';
            if (!$row['language']) $errors['language'] = 'زبان نامعتبر است';
            if (!$row['assessment']) $errors['assessment'] = 'ارزیابی نامعتبر است';
            if (!$row['company']) $errors['company'] = 'شرکت نامعتبر است';
            if (!$row['support']) $errors['support'] = 'پشتیبانی نامعتبر است';
            if (!$row['supportinterface']) $errors['supportinterface'] = 'واسط پشتیبانی نامعتبر است';
            if (!$row['timeinterface']) $errors['timeinterface'] = 'زمان واسط نامعتبر است';
            if (!$row['resultinterface']) $errors['resultinterface'] = 'نتیجه واسط نامعتبر است';
            if (!$this->user && !$row['setby']) $errors['setby'] = 'تنظیم‌کننده نامعتبر است';
            if (!$row['startts']) {
                $errors['startts'] = 'زمان شروع نامعتبر است';
            } else {
                try {
                    Jalalian::fromFormat('Y/n/j', $row['startts'])->getTimestamp();
                } catch (Exception $e) {
                    $errors['startts'] = 'فرمت زمان شروع نامعتبر است';
                }
            }
            if (!$row['endts']) {
                $errors['endts'] = 'زمان پایان نامعتبر است';
            } else {
                try {
                    Jalalian::fromFormat('Y/n/j', $row['endts'])->getTimestamp();
                } catch (Exception $e) {
                    $errors['endts'] = 'فرمت زمان پایان نامعتبر است';
                }
            }

            $now = Jalalian::now()->format('Y/m/d H:i:s');

            if ($this->errorHandling == 'notSetAll' && $errors) {
                //Log::error("خطاهایی در ردیف یافت شد: " . implode(', ', $errors));
                Storage::append('upload_log_institute.txt', "خطاهایی در ردیف " . $this->lineNumber . " یافت شد. ایمپورت در " . $now . " متوقف شد (خطاها: " . implode(', ', $errors) . ")\n");
                $this->lineNumber++;
                return null;
            }

            if ($this->errorHandling == 'notSetStu' && $errors) {
                //Log::warning("دانشجو در ردیف " . $lineNumber . " به دلیل وجود خطاها رد شد: " . implode(', ', $errors));
                Storage::append('upload_log_institute.txt', "خطاهایی در ردیف " . $this->lineNumber . " یافت شد. ایمپورت در " . $now . " متوقف شد (خطاها: " . implode(', ', $errors) . ")\n");
                $this->lineNumber++;
                return null;
            }

            $country_id = $this->countries[$row['country']] ?? null;
            $user_id = '';
            if (!$this->user) {
                if ($row['setby']) {
                    $user_id = $this->users[$row['setby']] ?? null;
                }
            }

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
            //Log::info("Student successfully imported in row: " . $lineNumber);
            //Storage::append('upload_log.txt', "----Student in row: " . $lineNumber . " successfully imported at " . $now . "\n");
            $this->lineNumber++;
            $this->successCount++;
            return new Institute($instituteData);

        } catch (Exception $e) {
            Log::error("ایمپورت موسسه با شکست مواجه شد: " . $e->getMessage());
            Storage::append('upload_log_institute.txt', "ایمپورت موسسه با شکست مواجه شد: " . $e->getMessage() . " در " . $now . "\n");
        }
    }



    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
    public function beforeImport()
    {
        Storage::append('upload_log_institute.txt', "فرایند ایمپورت در " . now() . " آغاز شد.\n");
    }

    public function afterImport()
    {
        Storage::append('upload_log_institute.txt', "پردازش فایل با موفقیت در " . now() . " انجام شد.\n");
        Storage::append('upload_log_institute.txt', $this->successCount . " رکورد با موفقیت وارد شدند.\n");
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => [$this, 'beforeImport'],
            AfterImport::class => [$this, 'afterImport']
        ];
    }
}
