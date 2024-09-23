<?php

namespace App\Observers;

use App\Models\Credit;
use App\Services\CreditService;

class CreditObserver
{
    /**
     * Handle the Credit "created" event.
     */
    public function created(Credit $credit)
    {
        (new CreditService())->generateSerialNumber($credit);
    }

    /**
     * Handle the Credit "updated" event.
     */
    public function updated(Credit $credit): void
    {
        //
    }

    /**
     * Handle the Credit "deleted" event.
     */
    public function deleted(Credit $credit): void
    {
        //
    }

    /**
     * Handle the Credit "restored" event.
     */
    public function restored(Credit $credit): void
    {
        //
    }

    /**
     * Handle the Credit "force deleted" event.
     */
    public function forceDeleted(Credit $credit): void
    {
        //
    }
}