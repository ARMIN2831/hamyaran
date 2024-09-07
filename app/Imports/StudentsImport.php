<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Country;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Morilog\Jalali\Jalalian;

class StudentsImport implements ShouldQueue,ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithEvents
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

            if (!$row['firstname']) $errors['firstname'] = 'نام وارد نشده است';
            if (!$row['lastname']) $errors['lastname'] = 'نام خانوادگی وارد نشده است';
            if (!$row['country']) $errors['country'] = 'کشور وارد نشده است';
            if (!$row['city']) $errors['city'] = 'شهر وارد نشده است';
            if (!$row['nationality']) $errors['nationality'] = 'ملیت وارد نشده است';
            if (!$row['language']) $errors['language'] = 'زبان وارد نشده است';
            if (!$row['birthyear']) $errors['birthyear'] = 'سال تولد وارد نشده است';
            if (!$row['sex']) $errors['sex'] = 'جنسیت وارد نشده است';
            if (!$row['ismarried']) $errors['ismarried'] = 'وضعیت تأهل وارد نشده است';
            if (!$row['job']) $errors['job'] = 'شغل وارد نشده است';
            if (!$row['education']) $errors['education'] = 'تحصیلات وارد نشده است';
            if (!$row['email']) $errors['email'] = 'ایمیل وارد نشده است';
            if (!$row['mobile']) $errors['mobile'] = 'شماره موبایل وارد نشده است';
            if (!$row['religion1']) $errors['religion1'] = 'دین اول وارد نشده است';
            if (!$row['religion2']) $errors['religion2'] = 'دین دوم وارد نشده است';
            if (!$row['address']) $errors['address'] = 'آدرس وارد نشده است';
            if (!$this->user) if (!$row['setby']) $errors['setby'] = 'تنظیم‌کننده وارد نشده است';
            if (!$row['startts']) {
                $errors['startts'] = 'تاریخ شروع وارد نشده است';
            } else {
                try {
                    Jalalian::fromFormat('Y/n/j', $row['startts'])->getTimestamp();
                } catch (Exception $e) {
                    $errors['startts'] = 'فرمت تاریخ شروع نادرست است';
                }
            }
            if (!$row['ismanageable']) $errors['ismanageable'] = 'وضعیت مدیریت‌پذیری وارد نشده است';
            if (!$row['candoact']) $errors['candoact'] = 'قابلیت اقدام وارد نشده است';
            if (!$row['publicrelation']) $errors['publicrelation'] = 'روابط عمومی وارد نشده است';
            if (!$row['opinionaboutiran']) $errors['opinionaboutiran'] = 'نظر درباره ایران وارد نشده است';
            if (!$row['donation']) $errors['donation'] = 'کمک مالی وارد نشده است';
            if (!$row['character']) $errors['character'] = 'ویژگی شخصیت وارد نشده است';
            if (!$row['aboutstudent']) $errors['aboutstudent'] = 'اطلاعات درباره دانشجو وارد نشده است';
            if (!$row['skill']) $errors['skill'] = 'مهارت وارد نشده است';
            if (!$row['allergie']) $errors['allergie'] = 'آلرژی وارد نشده است';
            if (!$row['ext']) $errors['ext'] = 'مقدار اضافی وارد نشده است';


            $now = Jalalian::now()->format('Y/m/d H:i:s');

            if ($this->errorHandling == 'notSetAll' && $errors) {
                //Log::error("خطاهایی در ردیف یافت شد: " . implode(', ', $errors));
                Storage::append('upload_log.txt', "خطاهایی در ردیف " . $this->lineNumber . " یافت شد. ایمپورت در " . $now . " متوقف شد (خطاها: " . implode(', ', $errors) . ")\n");
                $this->lineNumber++;
                return null;
            }

            if ($this->errorHandling == 'notSetStu' && $errors) {
                //Log::warning("دانشجو در ردیف " . $lineNumber . " به دلیل وجود خطاها رد شد: " . implode(', ', $errors));
                Storage::append('upload_log.txt', "خطاهایی در ردیف " . $this->lineNumber . " یافت شد. ایمپورت در " . $now . " متوقف شد (خطاها: " . implode(', ', $errors) . ")\n");
                $this->lineNumber++;
                return null;
            }

            if ($row['mobile'] && Student::where('mobile', $row['mobile'])->exists()) {
                Log::warning("دانشجو به دلیل تکراری بودن شماره موبایل در ردیف " . $this->lineNumber . " رد شد");
                Storage::append('upload_log.txt', "دانشجو به دلیل تکراری بودن شماره موبایل در ردیف " . $this->lineNumber . " رد شد. ایمپورت در " . $now . " متوقف شد.\n");
                $this->lineNumber++;
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
            //Log::info("Student successfully imported in row: " . $lineNumber);
            //Storage::append('upload_log.txt', "----Student in row: " . $lineNumber . " successfully imported at " . $now . "\n");
            $this->lineNumber++;
            $this->successCount++;
            return new Student($studentData);

        } catch (Exception $e) {
            Log::error("ایمپورت دانشجو با شکست مواجه شد: " . $e->getMessage());
            Storage::append('upload_log.txt', "ایمپورت دانشجو با شکست مواجه شد: " . $e->getMessage() . " در " . $now . "\n");
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
        Storage::append('upload_log.txt', "فرایند ایمپورت در " . now() . " آغاز شد.\n");
    }

    public function afterImport()
    {
        Storage::append('upload_log.txt', "پردازش فایل با موفقیت در " . now() . " انجام شد.\n");
        Storage::append('upload_log.txt', $this->successCount . " رکورد با موفقیت وارد شدند.\n");
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => [$this, 'beforeImport'],
            AfterImport::class => [$this, 'afterImport']
        ];
    }
}
