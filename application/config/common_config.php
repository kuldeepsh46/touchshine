<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['status'] = array(0 => 'Inactive', 1 => 'Active');

    
$config['payworld_credentials']=array(
    'merchantId'=>'623504232',
    'merchantKey'=>'YAns9JyUBdspb/lnyz4O2fEZHaBNWa2DoOfOAtPJOLQ=',
    'head_key'=>'1Vx1IGJMp/8Y7oMQtJcr0gj3gMsIEUy0SyDMkousZ0c=',
    'contentSecretKey'=>'1uIDjfj4j3lG5QQDeSTPoad3BR5ZMjy3moQ/zOcuQJg=',
    'onboardedAgentId'=>'AR526117',
);


/*AG_ID: Aggregator ID, Session ID: actual session of identification, ME_ID: Merchant
identification, UID: Unique Identification similar to ME_ID.*/
$config['safex_credentials']=array(
    'defaultkey'=>'9v6ZyFBzNYoP2Un8H5cZq5FeBwxL6itqNZsm7lisGBQ=',
    'allApiKey'=>'/yQkzO9jeKgSyd0j0GFEikaJT5mz+6DzuoJAg7wimr4=',
    'agid'=>'DIST1136395719',
    'mid'=>'DIST1136395719',
    'sessionId'=>'DIST1136395719',
    'uId'=>'DIST1136395719',
    'apiurl'=>'https://payout.safexpay.com/agWalletAPI/v2/agg',
);

