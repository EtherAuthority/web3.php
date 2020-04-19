<?php error_reporting(E_ALL); ini_set(disply_errors, 1);
include "vendor/autoload.php";
include 'config.php';
use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

$web3 = new Web3(new HttpProvider(new HttpRequestManager('https://ropsten.infura.io/R4ZOS5AoF9gJMfGMuqJm',5)));

$web3->clientVersion(function ($err, $version) {
    if ($err !== null) {
        // do something
        echo $err->getMessage();
        return;
    }
    if (isset($version)) {
        //echo 'Client version: ' . $version;
    }
});

$eth = $web3->eth;

//echo 'Eth Get Account and Balance' . PHP_EOL;
$web3->eth->accounts(function ($err, $accounts) use ($eth) {
    if ($err !== null) {
        echo 'Error: ' . $err->getMessage();
        return;
    }
    foreach ($accounts as $account) {
        echo 'Account: ' . $account . PHP_EOL;

        $eth->getBalance($account, function ($err, $balance) {
            if ($err !== null) {
                echo 'Error: ' . $err->getMessage();
                return;
            }
            echo 'Balance: ' . $balance . PHP_EOL;
        });
    }
});

$contract = new Contract($web3->provider, CONTRACT_ABI);

// get function data
$userAccountAddress = '0x90C17d5D39299419983A5f5332072442Fb6e04D6';
$functionName = 'getPrice';
$params = array ('addr',$userAccountAddress);
$functionData = $contract->at(CONTRACT_ADDRESS)->getData($functionName);
//$ether = toEther($functionData, 'ether'); 
    list($bnq, $bnr) = Utils::toEther('1', 'kether'); 
    //echo $bnq->toString(); // 1000
  //	echo jsonMethodToString($functionData); 
    
print_r($functionData);
exit;
// get balance
    $eth->getBalance($userAccountAddress, function ($err, $balance) use($userAccountAddress) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            return;
        }      
        echo $userAccountAddress.' Balance: '.$balance.PHP_EOL;
    });


exit;
$web3->eth->accounts(function ($err, $accounts) use ($contract, $testBytecode) {
    if ($err === null) {
        if (isset($accounts)) {
            $accounts = $accounts;
            print_r($accounts);
        } else {
            throw new RuntimeException('Please ensure you have access to web3 json rpc provider.');
        }
        // $fromAccount = $accounts[0];
        // $toAccount = $accounts[1];
        // $contract->bytecode($testBytecode)->new(1000000, 'Game Token', 1, 'GT', [
        //     'from' => $fromAccount,
        //     'gas' => '0x200b20'
        // ], function ($err, $result) use ($contract, $fromAccount, $toAccount) {
        //     if ($err !== null) {
        //         throw $err;
        //     }
        //     if ($result) {
        //         echo "\nTransaction has made:) id: " . $result . "\n";
        //     }
        //     $transactionId = $result;

        //     $contract->eth->getTransactionReceipt($transactionId, function ($err, $transaction) use ($contract, $fromAccount, $toAccount) {
        //         if ($err !== null) {
        //             throw $err;
        //         }
        //         if ($transaction) {
        //             $contractAddress = $transaction->contractAddress;
        //             echo "\nTransaction has mind:) block number: " . $transaction->blockNumber . "\n";

        //             $contract->at($contractAddress)->send('transfer', $toAccount, 16, [
        //                 'from' => $fromAccount,
        //                 'gas' => '0x200b20'
        //             ], function ($err, $result) use ($contract, $fromAccount, $toAccount) {
        //                 if ($err !== null) {
        //                     throw $err;
        //                 }
        //                 if ($result) {
        //                     echo "\nTransaction has made:) id: " . $result . "\n";
        //                 }
        //                 $transactionId = $result;

        //                 $contract->eth->getTransactionReceipt($transactionId, function ($err, $transaction) use ($fromAccount, $toAccount) {
        //                     if ($err !== null) {
        //                         throw $err;
        //                     }
        //                     if ($transaction) {
        //                         echo "\nTransaction has mind:) block number: " . $transaction->blockNumber . "\nTransaction dump:\n";
        //                         var_dump($transaction);
        //                     }
        //                 });
        //             });
        //         }
        //     });
        // });
    }
});
?>