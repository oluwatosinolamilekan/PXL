<?php

namespace App\Actions;

use App\Models\Account;
use Carbon\Carbon;
use Exception;

class StoreProcess
{
    const Age = [18, 65];

    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        //get json file..
        $collections =  $this->formatKeys();

        $lastAccount = Account::orderBy('created_at','desc')->first() ?? [];
        if($lastAccount){
            $i = 0;
            do {
                echo $i;
            } while ($i > 0);

        }else{
            foreach ($collections as $collection){
                Account::create($collection);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function loadUniqueDataFromFile(): array
    {
        $file = public_path() . "/{$this->filename}";
        if(!$file) throw new Exception("{$this->filename} does not exist on the public folder");
        $collection = json_decode(file_get_contents($file), TRUE);
        return collect($collection)->unique('account')->values()->all(); // return unique result..
    }

    /**
     * @throws Exception
     */
    private function formatKeys(): array
    {
        $results = [];
        foreach ($this->loadUniqueDataFromFile() as $value){
           if(array_key_exists('date_of_birth', $value)) $value['date_of_birth'] = $this->convertDateOfBirth($value['date_of_birth']);
            $results[] = $value;
        }
        //load age is between 18 and 65
        return collect($results)->whereBetween('date_of_birth', self::Age)->all();
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
     * @param $currentData
     * @param $incomingData
     * @return array
     */
    private function getDataDiff($currentData, $incomingData): array
    {
        return array_diff($currentData, $incomingData);
    }
}
