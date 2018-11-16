<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Shop\Payment\YandexPayment as YandexPaymentModel;
use App\Payments\Yandex\YandexPayment;
use DB;

class CheckYandexPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:check-yandex-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка неподтвержденных оплат';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $orderStatuses = [
        'waiting_for_capture' => 2,
        'succeeded' => 3,
        'canceled' => 6,
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $details = YandexPaymentModel::whereNotIn('status', ['succeeded', 'canceled'])
            ->with('payment')
            ->limit(5)
            ->get();

        foreach ($details as $d) {
            $status = (new YandexPayment)->getPaymentStatus($d->yandex_payment_id);

            if ($status !== $d->status) {
                if (isset($this->orderStatuses[$status])) {
                    DB::transaction(function () use($d, $status) {
                        $d->status = $status;
                        $d->save();

                        $d->payment->order()->first()->setStatus($this->orderStatuses[$status]);
                    });
                }
            }
        }
    }
}
