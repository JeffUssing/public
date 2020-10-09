<?php
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

public function getListOfSubscriptions($searchType)
{
  /* Create a merchantAuthenticationType object with authentication details
	 retrieved from the env file */
  // error_reporting(~E_DEPRECATED);
  $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
  $merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
  $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));

  // Set the transaction's refId
  $refId = 'ref' . time();

  $sorting = new AnetAPI\ARBGetSubscriptionListSortingType();
  $sorting->setOrderBy("id");
  $sorting->setOrderDescending(false);

  $paging = new AnetAPI\PagingType();
  $paging->setLimit("1000");
  $paging->setOffset("1");

  $request = new AnetAPI\ARBGetSubscriptionListRequest();
  $request->setMerchantAuthentication($merchantAuthentication);
  $request->setRefId($refId);
  $request->setSearchType($searchType);
  $request->setSorting($sorting);
  $request->setPaging($paging);


  $controller = new AnetController\ARBGetSubscriptionListController($request);

  return $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
}