<?php

namespace Shei\AwsMarketplaceTools;

use Aws\MarketplaceEntitlementService\MarketplaceEntitlementServiceClient;

class EntitlementService
{
    private MarketplaceEntitlementServiceClient $client;

    /**
     * @param $client
     */
    public function __construct(MarketplaceEntitlementServiceClient $client)
    {
        $this->client = $client;
    }

    public function getCustomerEntitlements (string $customerId, string $productCode): \Aws\Result
    {
        return $this->client->getEntitlements([
            'CustomerIdentifier' => $customerId,
            'ProductCode' => $productCode,
        ]);
    }
}
