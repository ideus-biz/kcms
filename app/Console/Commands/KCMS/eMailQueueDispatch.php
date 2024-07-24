<?php

namespace App\Console\Commands\KCMS;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kcms\App\Entity_eMail_Letter_Queue;
use Kcms\Core\Date;
use Kcms\Core\KCMS;
use Kcms\Core\Timer;


/**
 * Class eMailQueueDispatch
 *
 * [*] Higher priority number - higher priority processing
 * 
 * @package    App\Console\Commands\KCMS *
 * @author     Andrew Potapov <andrew@ideus.biz>
 * @copyright  2010-2023  Andrew Potapov <andrew@ideus.biz> aka ultimus
 * @since      V.2023
 * @version    5.3.2023.0531
 * @version    5.3.2023.0801
 * @version    5.5.2024.0723
 */
class eMailQueueDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:queue-dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends queued email letters from mail pool';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$tm = Timer::Instance(__METHOD__);
		$tm->finish = 59;
		
		do
		{
			$que = Entity_eMail_Letter_Queue::Instance()->find()
				->where('status', Entity_eMail_Letter_Queue::STATUS_QUEUED)
				->open('dateStart')->isNull()->or('dateStart')->lte(Date::Now())->close()
				->orderBy('priority', 'asc')
				->one();
			if ($que->pk())
			{
				$que->set_status(Entity_eMail_Letter_Queue::STATUS_DISPATCHING)->save();
				
				try
				{
					$letter = $que->letter();
					$to = $letter->to()->toArray();
					
					$sentCount = $que->sentCount >= 0 ? (int)$que->sentCount : 0;
					for ($i = $sentCount, $n = count($to); $i < $n; $i++)
					{
						try
						{
							if ($to[$i]->address != '')
							{
								$letter->to('')->to($to[$i]);
								
								$letter->send();
								
								$this->info("Letter ID {$que->pk()}: Sent to address #$i");
								
								$que->sentCount = $que->sentCount + 1;
								$que->save();
							}
						}
						catch (\Exception $E)
						{
							$this->error("Letter ID {$que->pk()}: Error - {$E->getMessage()}");
							$que->errors = $que->errors.PHP_EOL."#$i: {$to[$i]->address} - ".$E->getMessage();
							$que->save();
						}
					}
					
					if ($i === count($to))
					{
						if ($que->deleteOnComplete) $que->delete();
						else $que->set_status(Entity_eMail_Letter_Queue::STATUS_SENT)->set_dateCompleted(Date::Now())->save();
					}

				}
				catch (\Exception $E)
				{
					if ($que->pk()) $que->set_status(Entity_eMail_Letter_Queue::STATUS_QUEUED)->save();
					$this->error("Letter ID {$que->pk()}: Error - {$E->getMessage()}");
					Log::error(__METHOD__.': '.$E->getMessage());
				}
			}
		} while ($tm->remain > 1 && $que->pk());
    }
    
}
