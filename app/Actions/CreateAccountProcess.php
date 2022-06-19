<?php

namespace App\Actions;

use App\Models\Account;
use Illuminate\Support\Facades\DB;

class CreateAccountProcess
{
    public object $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @throws \Throwable
     */
    public function run()
    {
        DB::beginTransaction();
        Account::create($this->result);
        DB::commit();
        return $this->result;
    }
}
