# SymfonyBraintreeLibrary
Symfony 3 Bundle for Braintree's PHP client library, Symfony 3  latest Braintree Library

## Requirements

1. PHP 5.4 or greater
2. Symfony 3.0+
3. Braintree Server SDK
4. Braintree sandbox account

## Installation

Drag and drop the **src/AppBundle/Libraries/BrainTreeLibrary.php** , **app/config/services.yml**,**app/config/parameters.yml** and **composer.json** in root folder, files into your application's directories. To config your `braintree_environment ,braintree_merchantid, braintree_publickey,braintree_privateKey` in ` parameters.yml`. 


#### Important note : if you are not using ant or composer.json , directly  Drag and drop the files into your application's directories

## Testing 

Please check the BrainTreeController in your **src/AppBundle/Controller/BrainTreeController.php** 

#### Create customer: /braintree/create_customer/{userId}/{isObject}

{userId} : Your custom user ID
{isObject} : boolean true or false

example : baseurl/braintree/create_customer/123/true
          baseurl/braintree/create_customer
          
#### Customer delete: /braintree/customer_delete/{userId}/{isObject}        
example : baseurl/braintree/create_customer/123/true

#### Customer find: /braintree/customer_find/{userId}/{isObject}  
example : baseurl/braintree/customer_find/123/true


#### Customer find: /braintree/customer_update/{userId}/{isObject}   
example : baseurl/braintree/customer_update/123/true

#### Create Customer with Cridit Card and Address: /braintree/create_customer_with_cc_adrs/{userId}/{isObject}  
example : baseurl/braintree/create_customer_with_cc_adrs/123/true

#### Update Customer with Cridit Card and Address: /braintree/update_customer_with_cc_adrs/{userId}/{paymentToken}/{isObject}
example : baseurl/braintree/update_customer_with_cc_adrs/123/token/true


#### Create cridit Card: /braintree/create_cridit_card/{userId}/{isObject}  
example : baseurl/braintree/create_cridit_card/123/true

#### Edit cridit Card: /braintree/edit_cridit_card/{criditCardToken}/{isObject}  
example : baseurl/braintree/criditCardToken/token/true

#### Find cridit Card: /braintree/find_cridit_card/{criditCardToken}/{isObject}  
example : baseurl/braintree/find_cridit_card/token/true

#### Find cridit Card: /braintree/delete_cridit_card/{criditCardToken}/{isObject}  
example : baseurl/braintree/delete_cridit_card/token/true


#### Create Subcripiton : /braintree/subcripiton_create/{criditCardToken}/{planId}/{subscriptionID}/{isObject}
example : /braintree/subcripiton_create/token/1/1/true


#### Create Subcripiton with full features : /braintree/subcripiton_create_full_example/{criditCardToken}/{isObject}
example : /braintree/subcripiton_create_full_example/token/1/true


#### Canel Subcripiton : /braintree/subcripiton_cancel/{subscriptionID}/{isObject}
example : /braintree/subcripiton_cancel/token/1/true


#### Update Subcripiton : /braintree/subcripiton_update/{subscriptionID}/{isObject}
example : /braintree/subcripiton_update/token/123/true


#### Find Subcripiton : /braintree/subcripiton_find/{subscriptionID}/{isObject}
example : /braintree/subcripiton_find/token/123/true

#### retry charge : /braintree/retry_charge/{subscriptionID}/{subscritpionAmount}/{isObject}

#### User Transcations :/braintree/get_user_subscription_transcations/{userId}/{isObject}
example : /braintree/get_user_subscription_transcations/123/true


#### User Transcations History:/braintree/get_user_subscription_history/{userId}/{isObject}
example : /braintree/get_user_subscription_history/123/true


#### Create/Add Transcations:/braintree/add_transcation/{criditCardToken}/{isObject}
example : /braintree/add_transcation/toekn/true


#### Create/Add Transcations With User ID :/braintree/add_transcation_with_consumer/{consumerID}/{isObject}
example : /braintree/add_transcation_with_consumer/123/true



#### Transcations Settlement : /braintree/transcation_settlement/{transcationID}/{isObject}



#### Cancel Transcations  :/braintree/transcation_cancel/{transcationID}/{isObject}
example : /braintree/transcation_cancel/123/true


#### Refund Transcations  :/braintree/transcation_refund/{transcationID}/{isObject}
example : /braintree/transcation_refund/123/true



#### Find Transcation  :/braintree/transcation_find/{transcationID}/{isObject}
example : /braintree/transcation_find/123/true


#### settlement batch summary  :/braintree/settlement_batch_summary/{date}/{isObject}


#### Discounts  :/braintree/discounts

#### Plans  :/braintree/plans

#### user transcation list  :/braintree/user_transcation_list/{consumerID}

#### All Transcations :/braintree/transcation_list


#### All subscripitons :/braintree/subscripitons


#### All customers :/braintree/customers




#### Offical Symfony Documentation
http://symfony.com/

#### Offical Braintree Documentation
https://developers.braintreepayments.com/start/overview



## Help/Assistance

Email Us : rajaram.tavalam@gmail.com                   
Contact US :  +91-7386249801


## License

[MIT](LICENSE)




