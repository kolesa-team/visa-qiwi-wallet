Visa Qiwi Wallet checkout
=========================

Client library for Visa Qiwi Wallet checkout process integration.

# Installation

    composer require kolesa-team/visa-qiwi-wallet
    
# Create bill

    $client = new \Qiwi\Client($providerId, $login, $password);

    $ttl = new \DateTime();
    $ttl->add(new \DateInterval('PT1H'));
    
    $bill = new Bill();
    $bill->setId(str_pad('1', 10, '0', STR_PAD_LEFT))
        ->setAccount('test account')
        ->setAmount('99.95')
        ->setComment('Invoice from ShopName')
        ->setCurrency('USD')
        ->setPaySource('qw')
        ->setLifetime($ttl->format('Y-m-d\TH:i:s'))
        ->setProviderName('Test provider')
        ->setUser('tel:+79161231212')
        ->setExtras(['A' => 'valueA', 'b' => 'valueB']);
        
    $result = $client->createBill($bill);
    
    var_dump($result);

# Get bill status

    $client = new \Qiwi\Client($providerId, $login, $password);
    $result = $client->billStatus(str_pad('1', 10, '0', STR_PAD_LEFT));
    
    var_dump($result);
    
# Reject bill

    $client = new \Qiwi\Client($providerId, $login, $password);
    $result = $client->billReject(str_pad('1', 10, '0', STR_PAD_LEFT));
    
    var_dump($result);

