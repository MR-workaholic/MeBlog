<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Merchandise;

class MerchandiseIndexData extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $merchandises = Merchandise::all();
        foreach ($merchandises as $merchandise){
            $merchandise['data_tags'] = join(",", $merchandise->merchandisetags()->lists('tag')->all());
            // $merchandise['data_tags'] = join(",", ['a', 'b']);
        }

        return [
            'title' => config('merchandise.title'),
            'header' => config('merchandise.header'),
            'merchandises' => $merchandises,
            'WXname' => config('merchandise.WXname'),
        ];

    }
}
