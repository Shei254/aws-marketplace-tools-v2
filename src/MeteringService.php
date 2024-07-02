<?php

namespace Shei\AwsMarketplaceTools;

use Aws\MarketplaceMetering\MarketplaceMeteringClient;

class MeteringService
{
    private MarketplaceMeteringClient $client;
    public function __construct(MarketplaceMeteringClient $client)
    {
        $this->client = $client;
    }

    public function resolveCustomer (string $token): \Aws\Result
    {
        return $this->client->resolveCustomer([
            'RegistrationToken' => $token,
        ]);
    }
}
