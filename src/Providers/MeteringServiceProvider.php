<?php

namespace Shei\AwsMarketplaceTools\Providers;

use Aws\Credentials\Credentials;
use Aws\MarketplaceMetering\MarketplaceMeteringClient;
use Illuminate\Support\ServiceProvider;
class MeteringServiceProvider extends ServiceProvider
{
    public function register () {
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $this->app->bind(MarketplaceMeteringClient::class,function () use ($credentials) {
            return new MarketplaceMeteringClient([
                'version' => 'latest',
                'region' => 'us-east-1',
                'credentials' => $credentials,
            ]);
        });
    }
}
