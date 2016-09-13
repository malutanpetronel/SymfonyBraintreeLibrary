<?php

namespace AppBundle\Libraries;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Braintree\ClientToken as Braintree_ClientToken;
use Braintree\Configuration as Braintree_Configuration;
use Braintree\Transaction as Braintree_Transaction;
use Braintree\Customer as Braintree_Customer;
use Braintree\CreditCard as Braintree_CreditCard;
use Braintree\PaymentMethod as Braintree_PaymentMethod;
use Braintree\Subscription as Braintree_Subscription;
use Braintree\SettlementBatchSummary as Braintree_SettlementBatchSummary;
use DateTime; 
use Braintree\Discount as Braintree_Discount;
use Braintree\Plan as Braintree_Plan;
use Braintree\TransactionSearch as Braintree_TransactionSearch;
use Braintree\SubscriptionSearch as Braintree_SubscriptionSearch;


class BrainTreeLibrary {

    private $container;

    public function __construct(ContainerInterface $container) {

        $this->container = $container;

        $data = require_once dirname(__DIR__) . '/../../vendor/braintree/braintree_php/lib/Braintree.php';

        Braintree_Configuration::environment($this->container->getParameter('braintree_environment'));
        Braintree_Configuration::merchantId($this->container->getParameter('braintree_merchantid'));
        Braintree_Configuration::publicKey($this->container->getParameter('braintree_publickey'));
        Braintree_Configuration::privateKey($this->container->getParameter('braintree_privateKey'));
    }

    public function createCustomer($customerInfo, $isObject) {
        
        
        $result = Braintree_Customer::create($customerInfo);
         
        if ($result->success && $result->customer->id) {
            
            
         if ($isObject) {
                return $result;
            }

            $returnArray = array('status' => 1,
                'custmerId' => $result->customer->id,
                'createdAt' => $result->customer->createdAt,
            );
        } else {

            $returnArray = array('status' => 0,
                'message' => $result->message,
            );
        }
        
        return $returnArray ;

    }
    
    
    public function customerDelete($customerId, $isObject) {

        $result = Braintree_Customer::delete($customerId);

        if ($result->success) {
            
               
         if ($isObject) {
                return $result;
            }
            

            $returnArray = array('status' => 1
            );
        } else {

            $returnArray = array('status' => 0,
                'message' => $result->message,
            );
        }

        return $returnArray;
    }
    
    
    public function customerFind($customerId,$isObject=false) {
        
        $customer  = Braintree_Customer::find($customerId);
       
        if ( !empty($customer) &&  $customer->id) {

           
            $returnArray = [   
                'status'        => 1,
                'id'            => $customer->id,
                'merchantId'    => $customer->merchantId,
                'firstName'     => $customer->firstName,
                'lastName'      => $customer->lastName,
                'company'       => $customer->company,
                'email'         => $customer->email,
                'phone'         => $customer->phone,
                'fax'           => $customer->fax,
                'website'       => $customer->website];
            
             
            if ($isObject) {

                $returnArray = $customer;
            }
        } else {

            $returnArray = array('status' => 0);
        }

        return $returnArray;
    }
    
    
    public function customerUpdate($customerId, $customerInfo, $isObject){
        
        $updateResult = Braintree_Customer::update( $customerId, $customerInfo );

        
            if ($isObject) {

                return $updateResult;
            }
        
        
        if ($updateResult->success && $updateResult->customer->id) {

            $returnArray = array(   'status' => 1,
                                    'custmerId' => $updateResult->customer->id,
                                    'updatedAt' => $updateResult->customer->updatedAt,
                                );
            
           return $returnArray;
        }
        
    }
    
    
    public function createCustmerWithCCAndAdrs($customerInfo, $isObject=false) {

        $result = Braintree_Customer::create($customerInfo);
     
        
         if ($isObject) {

                return $result;
            }
        
        

        if ($result->success && $result->customer->id) {

            $returnArray = array('status'               => 1,
                                'custmerId'             => $result->customer->id,
                                'paymentMethodsToken'   => $result->customer->paymentMethods[0]->token,
                                'createdAt'             => $result->customer->createdAt,
                                );
        } else {
            
            $errMsg = '';
            
            foreach ($result->errors->deepAll() AS $error) {
                
                $errMsg .= $error->code . ": " . $error->message . "\n";
            }


            $returnArray = array('status'   => 0,
                                 'message'  => $errMsg,
                                );
        }

        return $returnArray;
    }
    
    public function createCriditCard($criditCardInfo, $isObject) {

        $result = Braintree_PaymentMethod::create($criditCardInfo);

        
        
         if ($isObject) {

                return $result;
            }
        
        
        
        
        if ($result->success && $result->paymentMethod->token) {

            $returnArray = array('status' => 1,
                'custmerId' => $result->paymentMethod->customerId,
                'paymentMethodsToken' => $result->paymentMethod->token,
                'createdAt' => $result->paymentMethod->createdAt,
                'cardType' => $result->paymentMethod->cardType,
                'maskedNumber' => $result->paymentMethod->maskedNumber,
            );
        } else {

            $returnArray = array('status' => 0,
                                  'message' => $result->message,
                                );
        }
        
        return $returnArray;
    }
    
    
    
    public function editCriditCard($paymentToken, $criditCardinfo, $isObject) {
        
        $result = Braintree_PaymentMethod::update($paymentToken,$criditCardinfo);
        
        if ($isObject) {

                return $result;
            }
        
        
        
        
        if ($result->success && $result->paymentMethod->token) {

            $returnArray = array('status' => 1,
                'custmerId' => $result->paymentMethod->customerId,
                'paymentMethodsToken' => $result->paymentMethod->token,
                'updatedAt' => $result->paymentMethod->updatedAt,
                'cardType' => $result->paymentMethod->cardType,
                'maskedNumber' => $result->paymentMethod->maskedNumber,
            );
        } else {

            $returnArray = array('status' => 0,
                                  'message' => $result->message,
                                );
        }
        
        return $returnArray;
        
    }
    
    
    public function findCriditCard($paymentToken,$isObject=false) {

        $result = Braintree_PaymentMethod::find($paymentToken);
     
        if ($result) {

            if ($isObject) {
                
                $returnArray = $result;
                
            } else {

                $returnArray = array(
                 'status' => 1,
                 'expirationMonth'  => $result->expirationMonth,
                 'expirationYear'   => $result->expirationYear,
                 'cardType'         => $result->cardType,
                 'cardholderName'   => $result->cardholderName,
                 'customerId'       => $result->customerId,
                 'customerLocation' => $result->customerLocation,
                 'expirationDate'   => $result->expirationDate,
                 'maskedNumber'     => $result->maskedNumber,
                 'updatedAt'        => $result->updatedAt,
                 'createdAt'        => $result->createdAt,
                );
            }
            
            
        } else {

            $returnArray = array('status' => 0,
                'message' => $result->message,
            );
        }

        return $returnArray;
    }
    
    
    public function deleteCriditCard($paymentToken, $isObject){
        
        $result = Braintree_PaymentMethod::delete($paymentToken);
        
         
        if ($isObject) {

                return $result;
            }
        
        
        
        if ($result->success) {

            $returnArray = array('status' => 1,
                                );
        } 

        return $returnArray;
        
    }
    
    
    public function subcripitonCreate($subscritpionInfo, $isObject=false) {
        
        $result = Braintree_Subscription::create($subscritpionInfo);
        
        
        

        if ($result->success) {

            if ($isObject) {
                
                $returnArray = $result;
                
            } else {
                
        
               
                $discount = array();
                
                if(isset($result->subscription->discounts[0])){
                    
                    $discount['amount'] = $result->subscription->discounts[0]->amount;
                    $discount['currentBillingCycle'] = $result->subscription->discounts[0]->currentBillingCycle;
                    $discount['id'] = $result->subscription->discounts[0]->id; 
                    $discount['name'] = $result->subscription->discounts[0]->name; 
                    $discount['neverExpires'] = $result->subscription->discounts[0]->neverExpires;
                    $discount['numberOfBillingCycles'] = $result->subscription->discounts[0]->numberOfBillingCycles;  
                    $discount['quantity'] = $result->subscription->discounts[0]->quantity;
                }

                $returnArray = array(
                 'status' => 1,
                 'balance'                  => $result->subscription->balance,
                 'billingDayOfMonth'        => $result->subscription->billingDayOfMonth,
                 'billingPeriodEndDate'     => $result->subscription->billingPeriodEndDate,
                 'billingPeriodStartDate'   => $result->subscription->billingPeriodStartDate,
                 'createdAt'                => $result->subscription->createdAt,
                 'updatedAt'                => $result->subscription->updatedAt,
                 'currentBillingCycle'      => $result->subscription->currentBillingCycle,
                 'daysPastDue'              => $result->subscription->daysPastDue,
                 'discounts'                => $discount,
                 'firstBillingDate'         => $result->subscription->firstBillingDate,
                 'failureCount'             => $result->subscription->failureCount,
                 'id'                       => $result->subscription->id,
                 'nextBillAmount'           => $result->subscription->nextBillAmount,  
                 'nextBillingPeriodAmount'  => $result->subscription->nextBillingPeriodAmount,  
                 'nextBillingDate'          => $result->subscription->nextBillingDate,     
                 'paidThroughDate'          => $result->subscription->paidThroughDate,
                 'paymentMethodToken'       => $result->subscription->paymentMethodToken,  
                 'planId'                   => $result->subscription->planId,  
                 'price'                    => $result->subscription->price,  
                 'status'                   => $result->subscription->status,
                 'trialDuration'            => $result->subscription->trialDuration,     
                 'trialPeriod'              => $result->subscription->trialPeriod,
                 'trialDurationUnit'        => $result->subscription->trialDurationUnit,  
                 'trialPeriod'              => $result->subscription->trialPeriod,     
                );
                
              
                
            }
            
            
        } else {

            $returnArray = array('status' => 0,
                'message' => $result->message,
            );
        }
       
        
        return $returnArray ;
        
    }
    
    
    public function cancelSubscription($subscriptionID, $isObject) {


        $result = Braintree_Subscription::cancel($subscriptionID);

   
        if ($isObject) {

            $returnArray = $result;
            
        } else {


            if ($result->success) {

                $returnArray = array(
                            'status'                => 1,
                            'subscription_status'   => $result->subscription->status,
                            'balance'               => $result->subscription->balance,
                            'id'                    => $result->subscription->id,
                            'subscription_status'   => $result->subscription->status,
                            'balance'               => $result->subscription->balance,
                            'id'                    => $result->subscription->id,
                    
                            );
            }

            return $returnArray;
        }
    }
    
    
    
    public function subscriptionUpdate($subscriptionID, $subscritpionInfo, $isObject) {

        $result = Braintree_Subscription::update($subscriptionID, $subscritpionInfo);

       
        if ($isObject) {
           return $result;
        }


        if ($result->success) {
            
             $discount = array();
                
                if(isset($result->subscription->discounts[0])){
                    
                    $discount['amount'] = $result->subscription->discounts[0]->amount;
                    $discount['currentBillingCycle'] = $result->subscription->discounts[0]->currentBillingCycle;
                    $discount['id'] = $result->subscription->discounts[0]->id; 
                    $discount['name'] = $result->subscription->discounts[0]->name; 
                    $discount['neverExpires'] = $result->subscription->discounts[0]->neverExpires;
                    $discount['numberOfBillingCycles'] = $result->subscription->discounts[0]->numberOfBillingCycles;  
                    $discount['quantity'] = $result->subscription->discounts[0]->quantity;
                }

                $returnArray = array(
                 'status'                   => 1,
                 'balance'                  => $result->subscription->balance,
                 'billingDayOfMonth'        => $result->subscription->billingDayOfMonth,
                 'billingPeriodEndDate'     => $result->subscription->billingPeriodEndDate,
                 'billingPeriodStartDate'   => $result->subscription->billingPeriodStartDate,
                 'createdAt'                => $result->subscription->createdAt,
                 'updatedAt'                => $result->subscription->updatedAt,
                 'currentBillingCycle'      => $result->subscription->currentBillingCycle,
                 'daysPastDue'              => $result->subscription->daysPastDue,
                 'discounts'                => $discount,
                 'firstBillingDate'         => $result->subscription->firstBillingDate,
                 'failureCount'             => $result->subscription->failureCount,
                 'id'                       => $result->subscription->id,
                 'nextBillAmount'           => $result->subscription->nextBillAmount,  
                 'nextBillingPeriodAmount'  => $result->subscription->nextBillingPeriodAmount,  
                 'nextBillingDate'          => $result->subscription->nextBillingDate,     
                 'paidThroughDate'          => $result->subscription->paidThroughDate,
                 'paymentMethodToken'       => $result->subscription->paymentMethodToken,  
                 'planId'                   => $result->subscription->planId,  
                 'price'                    => $result->subscription->price,  
                 'status'                   => $result->subscription->status,
                 'trialDuration'            => $result->subscription->trialDuration,     
                 'trialPeriod'              => $result->subscription->trialPeriod,
                 'trialDurationUnit'        => $result->subscription->trialDurationUnit,  
                 'trialPeriod'              => $result->subscription->trialPeriod,     
                );
            
            
        } else {

            $returnArray = array('status' => 0,
                'message' => $result->message,
            );
        }
        
        return $returnArray;
    }
    
    
    public function subscriptionFind($subscriptionID, $isObject){
        
      $result = Braintree_Subscription::find($subscriptionID);


        if ($isObject) {
            return $result;
        }


        if (!empty($result)) {
            
             $discount = array();
                
                if(isset($result->discounts[0])){
                    
                    $discount['amount'] = $result->discounts[0]->amount;
                    $discount['currentBillingCycle'] = $result->discounts[0]->currentBillingCycle;
                    $discount['id'] = $result->discounts[0]->id; 
                    $discount['name'] = $result->discounts[0]->name; 
                    $discount['neverExpires'] = $result->discounts[0]->neverExpires;
                    $discount['numberOfBillingCycles'] = $result->discounts[0]->numberOfBillingCycles;  
                    $discount['quantity'] = $result->discounts[0]->quantity;
                }

                $returnArray = array(
                 'status'                   => 1,
                 'balance'                  => $result->balance,
                 'billingDayOfMonth'        => $result->billingDayOfMonth,
                 'billingPeriodEndDate'     => $result->billingPeriodEndDate,
                 'billingPeriodStartDate'   => $result->billingPeriodStartDate,
                 'createdAt'                => $result->createdAt,
                 'updatedAt'                => $result->updatedAt,
                 'currentBillingCycle'      => $result->currentBillingCycle,
                 'daysPastDue'              => $result->daysPastDue,
                 'discounts'                => $discount,
                 'firstBillingDate'         => $result->firstBillingDate,
                 'failureCount'             => $result->failureCount,
                 'id'                       => $result->id,
                 'nextBillAmount'           => $result->nextBillAmount,  
                 'nextBillingPeriodAmount'  => $result->nextBillingPeriodAmount,  
                 'nextBillingDate'          => $result->nextBillingDate,     
                 'paidThroughDate'          => $result->paidThroughDate,
                 'paymentMethodToken'       => $result->paymentMethodToken,  
                 'planId'                   => $result->planId,  
                 'price'                    => $result->price,  
                 'trans_status'             => $result->status,
                 'trialDuration'            => $result->trialDuration,     
                 'trialPeriod'              => $result->trialPeriod,
                 'trialDurationUnit'        => $result->trialDurationUnit,  
                 'trialPeriod'              => $result->trialPeriod,     
                );
                
                return $returnArray;
            
            
        }
        
    }
    
    
    public function retryCharge($subscritpionId, $subscritpionAmount, $isObject){
        
        
         $retryResult = Braintree_Subscription::retryCharge($subscritpionId, $subscritpionAmount);

        if ($retryResult->success) {
            $result = Braintree_Transaction::submitForSettlement(
                            $retryResult->transaction->id
            );



            if ($result->success) {
                $returnArray = array('status' => 1,
                );
            } else {
                $returnArray = array('status' => 0,
                    'message' => $result->message,
                );
            }
        } else {
            $returnArray = array('status' => 0,
                'message' => $retryResult->message,
            );
        }

        return $returnArray;
    }
    
    
    public function transcation($transcationInfo, $isObject) {
        
        //$transcationInfo
        $result = Braintree_Transaction::sale($transcationInfo);


        if ($isObject) {
            return $result;
        }
        
        if ($result->success) {
            
            $returnArray = array(
                                    'status'        => 1,
                                    'id'            => $result->transaction->id,
                                    'trans_status'  => $result->transaction->status,   
                                    'type'          => $result->transaction->type,
                                    'amount'        => $result->transaction->amount,
                                    'createdAt'     => $result->transaction->createdAt,
                                    'refundId'      => $result->transaction->refundId,
                                    'processorResponseText'=> $result->transaction->processorResponseText,
                                    'paymentInstrumentType' => $result->transaction->paymentInstrumentType,
                                    
                                );
            
        } else {
            
            $returnArray = array('status' => 0,
                'message' => $result->message,
            );
        }

        return $returnArray;

        
    }
    
    
    public function transcationSettlement($transcationId, $isObject) {
        
    
        $result = Braintree_Transaction::submitForSettlement($transcationId);

        if ($isObject) {

            return $result;
        }

            if ($result->success) {
                
                   $returnArray = array(
                                    'status'                    => 1,
                                    'id'                        => $result->transaction->id,
                                    'trans_status'              => $result->transaction->status,   
                                    'type'                      => $result->transaction->type,
                                    'amount'                    => $result->transaction->amount,
                                    'createdAt'                 => $result->transaction->createdAt,
                                    'refundId'                  => $result->transaction->refundId,
                                    'processorResponseText'     => $result->transaction->processorResponseText,
                                    'paymentInstrumentType'     => $result->transaction->paymentInstrumentType,
                                    
                                );
                
            } else {
                
                $returnArray = array(   'status' => 0,
                                        'message' => $result->message,
                                    );
            }
       

        return $returnArray;
        
    }
    
    
    public function transcationCancel($transcationId, $isObject) {
        
        $result = Braintree_Transaction::void($transcationId);
        
        if ($isObject) {

            return $result;
        }

            if ($result->success) {
                
                   $returnArray = array(
                                    'status'                    => 1,
                                    'id'                        => $result->transaction->id,
                                    'trans_status'              => $result->transaction->status,   
                                    'type'                      => $result->transaction->type,
                                    'amount'                    => $result->transaction->amount,
                                    'createdAt'                 => $result->transaction->createdAt,
                                    'refundId'                  => $result->transaction->refundId,
                                    'processorResponseText'     => $result->transaction->processorResponseText,
                                    'paymentInstrumentType'     => $result->transaction->paymentInstrumentType,
                                    
                                );
                
            } else {
                
                $returnArray = array(   'status' => 0,
                                        'message' => $result->message,
                                    );
            }
       

        return $returnArray;
        
    }
    
    public function transcationRefund($transcationId, $refoundAmount, $isObject) {
        
        $result = Braintree_Transaction::refund($transcationId, $refoundAmount);
        
        if ($isObject) {

            return $result;
        }

            if ($result->success) {
                
                   $returnArray = array(
                                    'status'                    => 1,
                                    'id'                        => $result->transaction->id,
                                    'trans_status'              => $result->transaction->status,   
                                    'type'                      => $result->transaction->type,
                                    'amount'                    => $result->transaction->amount,
                                    'createdAt'                 => $result->transaction->createdAt,
                                    'refundId'                  => $result->transaction->refundId,
                                    'processorResponseText'     => $result->transaction->processorResponseText,
                                    'paymentInstrumentType'     => $result->transaction->paymentInstrumentType,
                                    
                                );
                
            } else {
                
                $returnArray = array(   'status' => 0,
                                        'message' => $result->message,
                                    );
            }
       

        return $returnArray;
        
    }
    
    
       
    public function transcationFind($transcationId,$isObject) {
        
        $result = Braintree_Transaction::find($transcationId);
        
        if ($isObject) {

            return $result;
        }

            if (count($result)) {
                
                   $returnArray = array(
                                    'status'                    => 1,
                                    'id'                        => $result->id,
                                    'trans_status'              => $result->status,   
                                    'type'                      => $result->type,
                                    'amount'                    => $result->amount,
                                    'createdAt'                 => $result->createdAt,
                                    'refundId'                  => $result->refundId,
                                    'processorResponseText'     => $result->processorResponseText,
                                    'paymentInstrumentType'     => $result->paymentInstrumentType,
                                    
                                    
                                );
                
            } else {
                
                $returnArray = array(   'status' => 0,
                                        'message' => $result->message,
                                    );
            }
       

        return $returnArray;
        
    }
    
    
    public function settlementBatchSummary($date, $isObject) {

        $today = $today = new Datetime($date);

        $result = Braintree_SettlementBatchSummary::generate(
                        $today->format("Y-m-d")
        );
        dump($result);
        exit;
       
        if ($isObject) {

            return $result;
        }

            if (count($result)) {
                
                   $returnArray = array(
                                    'status'                    => 1,
                                    'id'                        => $result->id,
                                    'trans_status'              => $result->status,   
                                    'type'                      => $result->type,
                                    'amount'                    => $result->amount,
                                    'createdAt'                 => $result->createdAt,
                                    'refundId'                  => $result->refundId,
                                    'processorResponseText'     => $result->processorResponseText,
                                    'paymentInstrumentType'     => $result->paymentInstrumentType,
                                    
                                    
                                );
                
            } else {
                
                $returnArray = array(   'status' => 0,
                                        'message' => $result->message,
                                    );
            }
       

        return $returnArray;
        
        
        
    }
    
    
    public function discounts(){
        
   
        $discounts = Braintree_Discount::all();
        return $discounts;
    }
    
    
      public function plans(){
        
   
        $discounts = Braintree_Plan::all();
        return $discounts;
    }
    
    
    public function transcationList($consumerID){
        
        $collection = Braintree_Transaction::search([
                        Braintree_TransactionSearch::customerId()->is($consumerID),
                      ]);
        return $collection;
        
        
    }
    
    public function allTranscations(){
          
        $collection = Braintree_Transaction::search([
                        Braintree_TransactionSearch::merchantAccountId()->is('senecaglobalinc'),
                      ]);
        return $collection;
    }
    
    
     public function allSubscripitons(){
          
        $collection = Braintree_Subscription::search([
                        Braintree_SubscriptionSearch::merchantAccountId()->is("senecaglobalinc")
                      ]);
        
        return $collection;
    }
    
    
    
    
    public function allCustomers(){
        
         $collection = Braintree_Customer::all();
        
        return $collection;
        
        
    }
    
    
        public function getPlanDetails($planID){
        
  
        $result  = Braintree_Plan::all();
        $plans = [];
        foreach ($result as $key){
          $plans[$key->id] = $key; 
        }
        
        if(!empty($plans[$planID]) && isset($plans[$planID]->id)){
            return $plans[$planID];
        } else {
            return false;
        }
        
        
        
    }
    
    
    
    
    public function getActivesubscription($result){
        

        
        foreach ($result as $key){

             if($key->status == Braintree_Subscription::CANCELED || $key->status == Braintree_Subscription::EXPIRED){

                 
             } else {
                 
                 return $key;
             }
        }
        
        return FALSE;
        
        
       
        
        
    }
    
    
    
    

}
