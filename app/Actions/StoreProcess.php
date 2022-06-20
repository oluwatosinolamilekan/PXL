<?php

namespace App\Actions;

use App\Jobs\StoreProcessJob;
use App\Models\Account;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class StoreProcess
{
    const AGE = [18, 65];

    /**
     * @var string
     */
    protected string $filename;

    /**
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @throws Exception|Throwable
     */
    public function run()
    {
        $results = $this->proceedNewData();
        $start = microtime(true);

        DB::beginTransaction();
        if (!empty($results)) {
            StoreProcessJob::dispatch($results);
        }
        DB::commit();
        return microtime(true) - $start;
    }

    /**
     * @throws Exception
     */
    private function loadUniqueDataFromFile(): array
    {
        $file = public_path() . "/{$this->filename}";
        if(!$file) throw new Exception("{$this->filename} does not exist on the public folder");
        $collection = json_decode(file_get_contents($file), TRUE); //this process can work XML or CSV file with similar content
        return collect($collection)->unique('account')->values()->all();
    }

    /**
     * @throws Exception
     */
    private function formatKeys(): array
    {
        $results = [];
        foreach ($this->loadUniqueDataFromFile() as $value){
            if (!empty($value['date_of_birth'])) {
                $value['age'] = $this->convertDateOfBirth($value['date_of_birth']);
            }
            else{
                $value['age'] = 'unknown';
            }
            $results[] = $value;
        }
        //load age is between 18 and 65 or unknown
       return collect($results)->filter(function ($value){
            return collect($value)->whereBetween('age', self::AGE)
                || collect($value)->whereNull('date_of_birth');
        })->all();
    }

    /**
     * @param $date
     * @return int
     */
    private function convertDateOfBirth($date): int
    {
        return now()->diffInYears(Carbon::createFromTimestamp(strtotime($date))->format('d-m-Y'));
    }


    /**
     * @throws Exception
     */
    private function proceedNewData(): array
    {
        $results = collect($this->formatKeys())->toArray();
        $currentData = Account::pluck('account')->toArray();
        return $this->checkDataDifference($results, $currentData);
    }

    /**
     * @param $jsonData
     * @param $currentData
     * @return array
     */
    private function checkDataDifference($jsonData, $currentData): array
    {
        $result = [];
        foreach ($jsonData as $key => $data){
            if(isset($currentData[$key])){
                if(is_array($data) && is_array($currentData[$key])){
                    $result[$key] = $this->checkDataDifference($data, $currentData[$key]);
                }
            }else{
                $result[$key] = $data;
            }
        }
        return $result;
    }
}
