<?php

namespace Shei\AwsMarketplaceTools\Providers;

use Aws\Credentials\Credentials;
use Aws\MarketplaceEntitlementService\MarketplaceEntitlementServiceClient;
use Illuminate\Support\ServiceProvider;

class EntitlementServiceProvider extends ServiceProvider
{
    public function register () {
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $this->app->singleton(MarketplaceEntitlementServiceClient::class, function () use ($credentials) {
            return new MarketplaceEntitlementServiceClient([
                'version' => 'latest',
                'region' => 'us-east-1',
                'credentials' => $credentials,
            ]);
        });
    }
}
