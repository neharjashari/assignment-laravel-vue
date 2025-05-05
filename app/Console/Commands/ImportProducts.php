<?php

namespace App\Console\Commands;

use App\Modules\Products\Interfaces\ProductServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportProducts extends Command
{
    protected $signature = 'app:import-products';

    protected $description = 'Import or sync products from Fake Store API';

    public function __construct(protected ProductServiceInterface $service)
    {
        parent::__construct();
    }

    public function handle()
    {
        $response = Http::get(config('app.fake_store_api') . '/products');

        if ($response->failed()) {
            $this->error('Failed to fetch products from API.');
            return;
        }

        $products = collect($response->json());

        $this->service->import($products);

        $this->info('Products imported/synced successfully.');
    }
}
