<?php

namespace App\Actions;

use App\Models\Account;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class StoreProcess
{
    const AGE = [18, 65];

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
        $results = $collection = collect($this->formatKeys())->toArray();
        DB::beginTransaction();
        foreach ($results as $result){
            Account::create($result);
        }
        DB::commit();
//        $collections =  $this->proceedNewData();
//        dd($collections);
//
//        $lastAccount = Account::orderBy('created_at','desc')->first() ?? null;
//        if($lastAccount){
//            $i = 0;
//            do {
//                echo $i;
//            } while ($i > 0);
//
//        }else{
//            foreach ($collections as $collection){
////                Account::create($collection);
//            }
//        }
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
            if (!empty($value['date_of_birth'])) {
                $value['age'] = $this->convertDateOfBirth($value['date_of_birth']);
            }
            else{
                $value['age'] = 'unknown';
            }
            $results[] = $value;
        }
        //load age is between 18 and 65 or unknown
       return collect($results)->filter(function ($value, $key){
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
     * @return array
     * @throws Exception
     */
    private function getAlreadyStoreData(): array
    {
        $collection = collect($this->formatKeys())->toArray();
        $storeData = Account::pluck('account')->toArray();
        return array_diff_assoc($collection, $storeData);
    }

    private function proceedNewData()
    {
        $collection = $this->formatKeys();

        $results = collect($collection)->toArray();
        $currentData = $this->getAlreadyStoreData();
       foreach($currentData as $data){

       }
    }
}
