<?php

namespace App\Observers;

use App\Models\Meja;
use App\Models\Log;

class LogMeja
{
    /**
     * Handle the Meja "created" event.
     *
     * @param  \App\Models\Meja  $meja
     * @return void
     */
    public function created(Meja $meja)
    {
        Log::create([
            "deskripsi" => "Meja $meja->no_meja telah di tambahkan oleh ".auth()->user()->name.'_'.auth()->user()->name
        ]);
    }

    /**
     * Handle the Meja "updated" event.
     *
     * @param  \App\Models\Meja  $meja
     * @return void
     */
    public function updated(Meja $meja)
    {
        Log::create([
            "deskripsi" => "Meja $meja->no_meja telah di diubah oleh ".auth()->user()->name.'_'.auth()->user()->name
        ]);
    }

    /**
     * Handle the Meja "deleted" event.
     *
     * @param  \App\Models\Meja  $meja
     * @return void
     */
    public function deleted(Meja $meja)
    {
        Log::create([
            "deskripsi" => "Meja $meja->no_meja telah di diubah oleh ".auth()->user()->name.'_'.auth()->user()->name
        ]);
    }

    /**
     * Handle the Meja "restored" event.
     *
     * @param  \App\Models\Meja  $meja
     * @return void
     */
    public function restored(Meja $meja)
    {
        //
    }

    /**
     * Handle the Meja "force deleted" event.
     *
     * @param  \App\Models\Meja  $meja
     * @return void
     */
    public function forceDeleted(Meja $meja)
    {
        Log::create([
            "deskripsi" => "Meja $meja->no_meja telah di diubah oleh ".auth()->user()->name.'_'.auth()->user()->name
        ]);
    }
}
