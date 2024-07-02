<?php

namespace Shei\AwsMarketplaceTools\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Shei\AwsMarketplaceTools\{EntitlementService, MeteringService, Models\AwsCustomer, Models\AwsSubscription};

class AwsMarketplaceController extends Controller
{
    protected MeteringService $meteringService;
    protected EntitlementService $entitlementService;
    public function __construct(MeteringService $meteringService, EntitlementService $entitlementService) {
        $this->meteringService = $meteringService;
        $this->entitlementService = $entitlementService;
    }

    public function resolveCustomer (Request $request) {
        try {
            $validate = Validator::make($request->all(), [
                'x-amzn-marketplace-token' => 'required',
            ]);

            if ($validate->fails()) {
                return redirect("/register")->with('error', "Error validating marketplace token");
            }

            $customer_results = $this->meteringService->resolveCustomer($request['x-amzn-marketplace-token']);
            if (!$customer_results["CustomerIdentifier"]) {
                throw new Exception("Error resolving customer");
            }

            //Check if Aws Customer Already Exists
            $aws_customer = AwsCustomer::where("customer_id", $customer_results["CustomerIdentifier"])->first();
            if ($aws_customer) {
                throw new Exception("You already have an account with us");
            }

            $entitlement_results = $this->entitlementService->getCustomerEntitlements($customer_results["CustomerIdentifier"], $customer_results["ProductCode"]);
            if (!count($entitlement_results['Entitlements'])) {
                throw new Exception('Could not find an active subscription. If you already registered please try again');
            }

            $aws_customer = AwsCustomer::create([
               "customer_id" => $customer_results["CustomerIdentifier"],
            ]);


            foreach ($entitlement_results['Entitlements'] as $entitlement) {
                AwsSubscription::create([
                   "aws_customer_id" => $aws_customer->id,
                   "dimension" => $entitlement['Dimension'],
                   "quantity" => $entitlement['Value']['IntegerValue']
                ]);
            }

            return redirect('/aws/register?customer_id='.$customer_results['CustomerIdentifier']);
        } catch (\Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }

    }

}
