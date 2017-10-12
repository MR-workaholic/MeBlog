<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Merchandise;

class MerchandiseData extends Job implements SelfHandling
{
    private $mid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mid = NULL)
    {
      $this->mid = $mid;
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
      if($this->mid){

      }else{
        return $this->allMerchandiseData();
      }
    }

  protected function allMerchandiseData(){
    $merchandises = Merchandise::all();
    foreach($merchandises as $merchandise){
      $merchandise['tags'] = $merchandise->merchandisetags()->get();
    }

    return $merchandises;

  }
}
