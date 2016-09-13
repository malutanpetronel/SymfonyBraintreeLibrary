<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Form\UserInfoType;
use AppBundle\Libraries\BrainTreeLibrary;
use \Symfony\Component\VarDumper\Test\VarDumperTestTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class BrainTreeController extends Controller
{
    
    

    /**
     * 
     * @Route("/braintree/create_customer/{userId}/{isObject}", name="createcustomer")
     */
    
    public function braintree($userId='',$isObject=false)
    {
       
       $braintreeLibrary = $this->get('app.braintree_library');

        $customerInfo = array(
            'firstName' => 'Raja Ram',
            'lastName' => 'Thavalam',
            'company' => 'Raja Ram Company',
            'email' => 'rajaram.tavalam@gmail.com',
            'phone' => '1111111111',
            'fax' => '',
            'website' => '',
        );
        
        if (!empty($userId)) {
            $customerInfo['id'] = $userId;
        }
        
        $result = $braintreeLibrary->createCustomer($customerInfo, $isObject);
        
         if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        }
        
        
        //if $result['status'] = 0 and  $result['message'] 
        //if $result['status'] = 1 and  $result['custmerId'] ,$result['createdAt'] 
        return new JsonResponse($result);
    }
    
    
    
    /**
     * 
     * @Route("/braintree/customer_delete/{userId}/{isObject}", name="customerdelete")
     */
    
    public function customerDelete($userId='', $isObject=false)
    {
       
       $braintreeLibrary = $this->get('app.braintree_library');

       
        if (empty($userId)) {
          $userId = 123;
        }

        $result = $braintreeLibrary->customerDelete($userId, $isObject);
        //if $result['status'] = 0 and  $result['message'] 
        //if $result['status'] = 1 
        
         if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        }
        
        
        return new JsonResponse($result);
    }
    
    
    /**
     * 
     * @Route("/braintree/customer_find/{userId}/{isObject}", name="customer_find")
     */
    
    public function customerFind($userId='',$isObject=false)
    {
       
       $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($userId)) {
          $userId = 123;
        }

        $result = $braintreeLibrary->customerFind($userId,$isObject);
        //if $result['status'] = 0 and  $result['message'] 
        //if $result['status'] = 1 
        
        if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        } else {
            return new JsonResponse($result);
        }
    }
    
    
    /**
     * 
     * @Route("/braintree/customer_update/{userId}/{isObject}", name="customer_update")
     */
    
    public function customerUpdate($userId='', $isObject=false)
    {
       
       $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($userId)) {
          $userId = 123;
        }
        
        $customerInfo = array(
            'firstName' => 'Raja Ram',
            'lastName' => 'Thavalam',
            'company' => 'Raja Ram Company',
            'email' => 'rajaram.tavalam@gmail.com',
            'phone' => '7386249801',
            'fax' => '',
            'website' => '',
        );

        $result = $braintreeLibrary->customerUpdate($userId, $customerInfo, $isObject);
        //if $result['status'] = 0 and  $result['message'] 
        //if $result['status'] = 1 
        
         if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        }
        
        
         return new JsonResponse($result);
        
    }
    
    
    
    /**
     * 
     * @Route("/braintree/create_customer_with_cc_adrs/{userId}/{isObject}", name="create_custmer_with_cc_adrs")
     */
    
    public function createCustmerWithCCAndAdrs($userId='', $isObject=false)
    {
       
       $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($userId)) {
          $userId = 123;
        }
        
        $braintreeLibrary = $this->get('app.braintree_library');

        $customerInfo = [
                        'firstName'             => 'Raja Ram',
                        'lastName'              => 'Thavalam',
                        'company'               => 'Raja Ram Company',
                        'email'                 => 'raja.thavalam@g.com',
                        'phone'                 => '7386249801',
                        'fax'                   => '',
                        'website'               => '',
                        'paymentMethodNonce'    => 'nonce-from-the-client',
                        'creditCard'            => [
                                                    'billingAddress' => [
                                                                        'firstName'     => 'Raja Ram',
                                                                        'lastName'      => 'Thavalam',
                                                                        'company'       => 'Hyderabad',
                                                                        'streetAddress' => '123 Hyderabad',
                                                                        'locality'      => 'Hyderabad',
                                                                        'region'        => 'Telangana',
                                                                        'postalCode'    => '12345'
                                                                        ],
                            
                                                    'cardholderName'   => 'T Raja Rama Mohan',
                                                    'cvv'              => '123',
                                                    'expirationMonth'  => '10',
                                                    'expirationYear'   => '2019',
                                                    'number'           => '4111111111111111',
                                                    'options'          => [
                                                                            'makeDefault' => true,
                                                                            'verifyCard' => true,
                                                                        ]
                                                
                                                ],
                      

        ];
        
        if (!empty($userId)) {
            $customerInfo['id'] = $userId;
        }

        $result = $braintreeLibrary->createCustmerWithCCAndAdrs($customerInfo, $isObject);
        
         if ($isObject == true) {
            echo '<pre>';
            dump($result);
            exit;
        }
        
        
        
        //if $result['status'] = 0 and  $result['message'] 
        //if $result['status'] = 1 and  $result['custmerId'] ,$result['createdAt'] 
        return new JsonResponse($result);
        
        
    }
    
    /**
     * 
     * @Route("/braintree/update_customer_with_cc_adrs/{userId}/{paymentToken}/{isObject}", name="update_custmer_with_cc_adrs")
     */
    
    public function updateCustmerWithCCAndAdrs($userId='', $paymentToken='',$isObject=false)
    {
       
       
        
       $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($userId)) {
          $userId = 123;
          
        }
        
        if (empty($paymentToken)) {
            $customer       = $braintreeLibrary->customerFind($userId,true);
            $paymentToken   = $customer->creditCards[0]->token;
        }
        

        $braintreeLibrary = $this->get('app.braintree_library');

        $customerInfo = [
                        'firstName'             => 'Raja Ram',
                        'lastName'              => 'Thavalam',
                        'company'               => 'Raja Ram Company',
                        'email'                 => 'raja@ram.com',
                        'phone'                 => '7386249801',
                        'fax'                   => '',
                        'website'               => '',
                        'paymentMethodNonce'    => 'nonce-from-the-client',
                        'creditCard'            => [
                                                    'billingAddress' => [
                                                                        'firstName'     => 'Raja Ram Updated',
                                                                        'lastName'      => 'Thavalam Updated',
                                                                        'company'       => 'Hyderabad Updated',
                                                                        'streetAddress' => '123 Hyderabad Updated',
                                                                        'locality'      => 'Hyderabad Updated',
                                                                        'region'        => 'Telangana Updated',
                                                                        'postalCode'    => '12345',
                                                                        'options'       => [
                                                                                            'updateExisting' => true
                                                                                            ]
                                                                        ],
                            
                                                    'cardholderName'   => 'T Raja Rama Mohan Test',
                                                    'cvv'              => '321',
                                                    'expirationMonth'  => '01',
                                                    'expirationYear'   => '2020',
                                                    'number'           => '4500600000000061',
                                                    'options'          => [
                                                                            'updateExistingToken'   => $paymentToken,
                                                                            'makeDefault'           => true,
                                                                            'verifyCard'            => true,
                                                                        ]
                                                
                                                ],
              

        ];
        
        
        $result = $braintreeLibrary->customerUpdate($userId, $customerInfo, $isObject);
        
         if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        }
        
        
        //if $result['status'] = 0 and  $result['message'] 
        //if $result['status'] = 1 and  $result['custmerId'] ,$result['createdAt'] 
        return new JsonResponse($result);
        
        
    }
    
    
    /**
     * 
     * @Route("/braintree/create_cridit_card/{userId}/{isObject}", name="create_cridit_card")
     */
       public function createCriditCard($userId = '',$isObject=false) {

        $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($userId)) {
            $userId = 123;
        }
        
         $criditCardinfo= [
                            'customerId' => $userId,
                          
                            'billingAddress' => [
                                                   'firstName' => 'Raja Ram Updated',
                                                   'lastName' => 'Thavalam Updated',
                                                   'company' => 'Hyderabad Updated',
                                                   'streetAddress' => '123 Hyderabad Updated',
                                                   'locality' => 'Hyderabad Updated',
                                                   'region' => 'Telangana Updated',
                                                   'postalCode' => '12345',
                                               ],
                           'cardholderName'    => 'T Raja Rama Mohan Test',
                           'cvv'               => '321',
                           'expirationMonth'   => '01',
                           'expirationYear'    => '2020',
                           'number'            => '5555555555554444',
                           'options'           => [
                                                       'makeDefault' => true,
                                                       'verifyCard' => true,
                                                   ],
                            'paymentMethodNonce' => 'nonce-from-the-client',
                        ];
         
         
        $result = $braintreeLibrary->createCriditCard($criditCardinfo, $isObject);
        
        
         if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        }
        
        
        
        return new JsonResponse($result);

    }
    
     /**
     * 
     * @Route("/braintree/edit_cridit_card/{criditCardToken}/{isObject}", name="edit_cridit_card")
     */
       public function editCriditCard($criditCardToken = '', $isObject=false) {

        $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($criditCardToken)) {
            $userId         = 123;
            $customer       = $braintreeLibrary->customerFind($userId,true);
            $criditCardToken   = $customer->creditCards[0]->token;
        }
        
         $criditCardinfo= [
                          
                            'billingAddress' => [
                                                   'firstName' => 'Raja Ram Updated',
                                                   'lastName' => 'Thavalam Updated',
                                                   'company' => 'Hyderabad Updated',
                                                   'streetAddress' => '123 Hyderabad Updated',
                                                   'locality' => 'Hyderabad Updated',
                                                   'region' => 'Telangana Updated',
                                                   'postalCode' => '12345',
                                               ],
                           'cardholderName'    => 'T Raja Rama Mohan Test',
                           'cvv'               => '321',
                           'expirationMonth'   => '01',
                           'expirationYear'    => '2020',
                           'number'            => '5555555555554444',
                           'options'           => [
                                                       'makeDefault' => true,
                                                       'verifyCard' => true,
                                                   ],
                            'paymentMethodNonce' => 'nonce-from-the-client',
                        ];
         
         
        $result = $braintreeLibrary->editCriditCard($criditCardToken, $criditCardinfo, $isObject);
        
        if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        } 
        
        
        
        return new JsonResponse($result);

    }
    
    
        
     /**
     * 
     * @Route("/braintree/find_cridit_card/{criditCardToken}/{isObject}", name="find_cridit_card")
     */
       public function findCriditCard($criditCardToken = '', $isObject=false) {

        $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($criditCardToken)) {
            $userId          = 123;
            $customer        = $braintreeLibrary->customerFind($userId,true);
            $criditCardToken = $customer->creditCards[0]->token;
        }
      
         
        $result = $braintreeLibrary->findCriditCard($criditCardToken, $isObject);
        if ($isObject) {
            
            dump($result);
            exit;
            
        } else {
            
            return new JsonResponse($result);
        }
        
    }
    
    /**
     * 
     * @Route("/braintree/delete_cridit_card/{criditCardToken}/{isObject}", name="delete_cridit_card")
     */
       public function deleteCriditCard($criditCardToken = '', $isObject=false) {

        $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($criditCardToken)) {
            $userId          = 123;
            $customer        = $braintreeLibrary->customerFind($userId, true);
            $criditCardToken = $customer->creditCards[0]->token;
        }
      
         
        $result = $braintreeLibrary->deleteCriditCard($criditCardToken, $isObject);
       
         
        if ($isObject) {
            echo '<pre>';
            dump($result);
            exit;
        } 
        
        
        return new JsonResponse($result);
        
    }
    
    
    /**
     * 
     * @Route("/braintree/subcripiton_create/{criditCardToken}/{planId}/{subscriptionID}/{isObject}", name="subcripiton_create")
     */
    
    public function subcripitonCreate($criditCardToken='',$planId='', $subscriptionID='', $isObject=false) {

        $braintreeLibrary = $this->get('app.braintree_library');

        if (empty($criditCardToken)) {
            $userId = 123;
            $customer = $braintreeLibrary->customerFind($userId, $isObject = true);
            $criditCardToken = $customer->creditCards[0]->token;
        }
        
        if (empty($planId)) {
            $planId = 2;
        }
        //'numberOfBillingCycles'
        // 'options' 'startImmediately' 'doNotInheritAddOnsOrDiscounts'
        //'price'                 => '10.00',
        
        $subscritpionInfo  = [
                                'paymentMethodToken'    => $criditCardToken,
                                'planId'                => $planId,
                                'trialPeriod'           => false,
                                'trialDuration'         => 0,
                                'trialDurationUnit'     => 'month',
                                'neverExpires'          => true,
                              ];
        
        
        if(!empty($subscriptionID)){
           $subscritpionInfo['id'] = $subscriptionID ;
        }
        


        $result = $braintreeLibrary->subcripitonCreate($subscritpionInfo, $isObject);

         if ($isObject) {
            
            dump($result);
            exit;
            
        } else {
            
            return new JsonResponse($result);
        }
    }
    
    
    
     /**
     * 
     * @Route("/braintree/subcripiton_create_full_example/{criditCardToken}/{isObject}", name="subcripiton_create_full_example")
     */
    
    public function subcripitonCreateFullExample($criditCardToken='',$isObject=false) {

        $braintreeLibrary = $this->get('app.braintree_library');

        if (empty($criditCardToken)) {
            $userId = 123;
            $customer = $braintreeLibrary->customerFind($userId, $isObject = true);
            $criditCardToken = $customer->creditCards[0]->token;
        }

        $subscritpionInfo  = [
                                'paymentMethodToken'    => $criditCardToken,
                                'planId'                => '2',
                                'trialPeriod'           => true,
                                'trialDuration'         => 1,
                                'trialDurationUnit'     => 'month',
                                //'id'                  => 'custom_subscription_id',
                                //'price'               => 'custom_price',
                                'neverExpires'          => true,
                                //'numberOfBillingCycles' => '10',
                                'discounts'             => [
                                                                'add' => [
                                                                            [
                                                                                'inheritedFromId'       => '1',
                                                                                'amount'                => '20.00',
                                                                                'numberOfBillingCycles' => 1,
                                                                                'quantity'              => 1,
                                                                                'neverExpires'          => false,
                                                                            ]
                                                                        ],
                                    
                                                               /* 'update' => [
                                                                                [
                                                                                    'existingId'        => 'ExistingID',
                                                                                    'amount'            => '15.00',
                                                                                    'neverExpires'      => true,
                                                                                    'quantity'          => 3
                                                                                ]
                                                                            ], 
                                                                  'remove' => ['ExistingID2']
                                                                */
                                    
                                    
                                                                ],
                                     /*'addOns'             => [
                                                                'add' => [
                                                                            [
                                                                                'inheritedFromId'       => 'Addon_id',
                                                                                'amount'                => '20.00',//optional
                                                                            ]
                                                                        ],
                                    
                                                               'update' => [
                                                                                [
                                                                                    'existingId'        => 'ExistingID',
                                                                                    'amount'            => '15.00',
                                                                                    'neverExpires'      => true,
                                                                                    'quantity'          => 3
                                                                                ]
                                                                            ], 
                                                                  'remove' => ['ExistingID2']
                                                                
                                    
                                    
                                                                ]*/
                                /*'options' => [
                                                'startImmediately'              => true,
                                                'doNotInheritAddOnsOrDiscounts'  => true,
                                             ] 
                                 */
          
                              ];
        
       
       

        $result = $braintreeLibrary->subcripitonCreate($subscritpionInfo, $isObject);

         if ($isObject) {
            
            dump($result);
            exit;
            
        } else {
            
            return new JsonResponse($result);
        }
    }
    
    
   
     /**
     * 
     * @Route("/braintree/subcripiton_cancel/{subscriptionID}/{isObject}", name="subcripiton_cancel")
     */ 
    public function cancelSubscription($subscriptionID,$isObject=false){
        
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->cancelSubscription($subscriptionID, $isObject); 
        if ($isObject) {
            
            dump($result);
            exit;
            
        } else {
            
            return new JsonResponse($result);
        }

    }
    
    
    /**
     * 
     * @Route("/braintree/subcripiton_update/{subscriptionID}/{isObject}", name="subcripiton_cancel")
     */ 
    public function subscriptionUpdate($subscriptionID,$isObject=false) {
        
        
        $braintreeLibrary = $this->get('app.braintree_library');

        $subscritpionInfo  = [
                                //'paymentMethodToken'    => $criditCardToken,
                                'planId'                => '4', //please check your updating plan and previous plan billing cycle should be same
                                //'id'                  => 'custom_subscription_id',
                                'price'                 => '1.0',
                                'neverExpires'          => true,
                                //'numberOfBillingCycles' => '10',
                               /*  'discounts'             => [
                                                                'add' => [
                                                                            [
                                                                                'inheritedFromId'       => '1',
                                                                                'amount'                => '20.00',
                                                                                'numberOfBillingCycles' => 1,
                                                                                'quantity'              => 1,
                                                                                'neverExpires'          => false,
                                  cancel                                          ]
                                                                        ],
                                    
                                                               'update' => [
                                                                                [
                                                                                    'existingId'        => 'ExistingID',
                                                                                    'amount'            => '15.00',
                                                                                    'neverExpires'      => true,
                                                                                    'quantity'          => 3
                                                                                ]
                                                                            ], 
                                                                  'remove' => ['ExistingID2']
                                                                
                                    
                                    
                                                                ],*/
                                     /*'addOns'             => [
                                                                'add' => [
                                                                            [
                                                                                'inheritedFromId'       => 'Addon_id',
                                                                                'amount'                => '20.00',//optional
                                                                            ]
                                                                        ],
                                    
                                                               'update' => [
                                                                                [
                                                                                    'existingId'        => 'ExistingID',
                                                                                    'amount'            => '15.00',
                                                                                    'neverExpires'      => true,
                                                                                    'quantity'          => 3
                                                                                ]
                                                                            ], 
                                                                  'remove' => ['ExistingID2']
                                                                
                                    
                                    
                                                                ]*/
                                'options' => [
                                                'replaceAllAddOnsAndDiscounts' => true
                                             ] 
                                 
          
                              ];
        
       
       

         $result = $braintreeLibrary->subscriptionUpdate($subscriptionID, $subscritpionInfo, $isObject);

         if ($isObject) {
            
            dump($result);
            exit;
            
        } else {
            
            return new JsonResponse($result);
        }
        
    }
    
   
    
        
    /**
     * 
     * @Route("/braintree/subcripiton_find/{subscriptionID}/{isObject}", name="subcripiton_find")
     */ 
    public function subscriptionFind($subscriptionID,$isObject=false) {
        
         $braintreeLibrary = $this->get('app.braintree_library');
         $result = $braintreeLibrary->subscriptionFind($subscriptionID, $isObject);

         if ($isObject) {
            
            dump($result);
            exit;
            
        } else {
            
            return new JsonResponse($result);
        }
        
    }
    
     /**
     * 
     * @Route("/braintree/retry_charge/{subscriptionID}/{subscritpionAmount}/{isObject}", name="retry_charge")
     */ 
    public function retryCharge($subscriptionID,$subscritpionAmount='10.00', $isObject=false) {
        
         $braintreeLibrary = $this->get('app.braintree_library');
         $result = $braintreeLibrary->retryCharge($subscriptionID, $subscritpionAmount, $isObject);

         if ($isObject) {
            
            dump($result);
            exit;
            
        } else {
            
            return new JsonResponse($result);
        }
        
    }
    
    
     /**
     * 
     * @Route("/braintree/get_user_subscription_transcations/{userId}/{isObject}", name="get_user_subscription_transcations")
     */ 
    
    public function getUserTranscations($userId=123, $isObject=true) {
        
       $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($userId)) {
          $userId = 123;
        }

        $result = $braintreeLibrary->customerFind($userId,$isObject);
       
        dump($result->creditCards[0]->subscriptions[0]->transactions);
        exit;
          
    }
    
    
      /**
     * 
     * @Route("/braintree/get_user_subscription_history/{userId}/{isObject}", name="get_user_subscription_history")
     */ 
    
    public function getUserTransHistory($userId=123, $isObject=true) {
        
       $braintreeLibrary = $this->get('app.braintree_library');
        if (empty($userId)) {
          $userId = 123;
        }

        $result = $braintreeLibrary->customerFind($userId,$isObject);
       
        dump($result->creditCards[0]->subscriptions[0]->statusHistory);
        exit;
          
    }
    
    
    /**
     * 
     * @Route("/braintree/add_transcation/{criditCardToken}/{isObject}", name="add_transcation")
     */ 
    public function transcationWithCriditToken($criditCardToken='', $isObject=false) {
        
        $braintreeLibrary = $this->get('app.braintree_library');
        
        if (empty($criditCardToken)) {
           $userId = 123;
           $customer = $braintreeLibrary->customerFind($userId, $isObject = true);
           $criditCardToken = $customer->creditCards[0]->token;
        }
        
        
        $transcationInfo = ['paymentMethodToken' =>  $criditCardToken,
                            'amount'             => '10.00',
            
                            ];

        $result = $braintreeLibrary->transcation($transcationInfo,$isObject);
        
         if ($isObject) {

            dump($result);
            exit;
        } else {

            return new JsonResponse($result);
        }
    }
    
    
    
    
    /**
     * 
     * @Route("/braintree/add_transcation_with_consumer/{consumerID}/{isObject}", name="add_transcation")
     */ 
    public function transcationWithConsumerID($consumerID='', $isObject=false) {
        
        $braintreeLibrary = $this->get('app.braintree_library');
        
        if (empty($consumerID)) {
           $consumerID = 123;
        
        }
        
        
        $transcationInfo = ['customerId'    =>  $consumerID,
                            'amount'        => '10.00',
                            ];

        $result = $braintreeLibrary->transcation($transcationInfo,$isObject);
        
         if ($isObject) {

            dump($result);
            exit;
        } else {

            return new JsonResponse($result);
        }
    }
    
    
    /**
     * 
     * @Route("/braintree/transcation_settlement/{transcationID}/{isObject}", name="transcation_settlement")
     */ 
    public function transcationSettlement($transcationID='', $isObject=false) {
        
        $braintreeLibrary = $this->get('app.braintree_library');
        
     
        $result = $braintreeLibrary->transcationSettlement($transcationID, $isObject);
        
         if ($isObject) {

            dump($result);
            exit;
        } else {

            return new JsonResponse($result);
        }
        
    }
    
    
    /**
     * 
     * @Route("/braintree/transcation_cancel/{transcationID}/{isObject}", name="transcation_cancel")
     */ 
    public function transcationCancel($transcationID='', $isObject=false) {
        
        $braintreeLibrary = $this->get('app.braintree_library');
        
     
        $result = $braintreeLibrary->transcationCancel($transcationID, $isObject);
        
         if ($isObject) {

            dump($result);
            exit;
        } else {

            return new JsonResponse($result);
        }
        
    }
    
    
    
    
    
    /**
     * 
     * @Route("/braintree/transcation_refund/{transcationID}/{isObject}", name="transcation_refund")
     */ 
    public function transcationRefund($transcationID='', $isObject=false) {
        
        $braintreeLibrary = $this->get('app.braintree_library');
        
     
        $result = $braintreeLibrary->transcationRefund($transcationID,$refoundAmount='1.00', $isObject);
        
         if ($isObject) {

            dump($result);
            exit;
        } else {

            return new JsonResponse($result);
        }
        
    }
    
    
    /**
     * 
     * @Route("/braintree/transcation_find/{transcationID}/{isObject}", name="transcation_find")
     */ 
    public function transcationFind($transcationID, $isObject=false) {
        
        $braintreeLibrary = $this->get('app.braintree_library');
        
     
        $result = $braintreeLibrary->transcationFind($transcationID, $isObject);
        
         if ($isObject) {

            dump($result);
            exit;
        } else {

            return new JsonResponse($result);
        }
        
    }
    
    /**
     * 
     * @Route("/braintree/settlement_batch_summary/{date}/{isObject}", name="settlement_batch_summary")
     */ 
    public function settlementBatchSummary($date='', $isObject=false) {
        
        $date = date('Y-m-d');
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->settlementBatchSummary($date, $isObject);

         if ($isObject) {

            dump($result);
            exit;
        } else {

            return new JsonResponse($result);
        }
        
        
    }
    
    
    
    /**
     * 
     * @Route("/braintree/discounts", name="discounts")
     */ 
    public function discounts(){
        
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->discounts();
        dump($result);
        exit;
        
    }
    
    
     /**
     * 
     * @Route("/braintree/plans", name="plans")
     */ 
    public function plans(){
        
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->plans();
        dump($result);
        exit;
        
    }
    
    /**
     * 
     * @Route("/braintree/user_transcation_list/{consumerID}", name="user_transcation_list")
     */ 
   
    public function transcationList($consumerID){
        
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->transcationList($consumerID);
        
        foreach ($result as $transaction) {
            dump($transaction);
        }
        
        exit;


        //dump($result);
        
    }
    
    
    /**
     * 
     * @Route("/braintree/transcation_list", name="transcation_list")
     */ 
    
    public function allTranscations(){
         
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->allTranscations();
        
        foreach ($result as $transaction) {
            dump($transaction);
        }
        
        exit;

  
    }
    
    
    
    /**
     * 
     * @Route("/braintree/subscripitons", name="subscripitons")
     */ 
    
    public function allSubscripitons(){
         
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->allSubscripitons();
        
        foreach ($result as $subscripitons) {
            dump($subscripitons);
        }
        
        exit;

  
    }
    
    
    
    
    /**
     * 
     * @Route("/braintree/customers", name="customers")
     */ 
    
    public function allCustomers(){
         
        $braintreeLibrary = $this->get('app.braintree_library');
        $result = $braintreeLibrary->allCustomers();
        
        foreach ($result as $customers) {
            dump($customers);
        }
        
        exit;

  
    }
    
    
    
    
    
    
    
    
    
    
    

}