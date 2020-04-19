<?php  error_reporting(E_ALL); ini_set('display_errors',1);

require('config.php');
require('vendor/autoload.php');
require 'ethereum-tx/vendor/autoload.php';
use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3p\EthereumTx\Transaction;

// sam proxy = address
// sam v1 == abi
//print_r($_POST);
//exit;

$web3 = new Web3(new HttpProvider(new HttpRequestManager('https://rinkeby.infura.io/v3/6f8dc3b58cd345cd9a6589821d2c131c',5)));
$eth = $web3->eth;
//main contract abi
$CONTRACT_ABI = CONTRACT_ABI;

//proxy contract address
$contractAddress = CONTRACT_ADDRESS;
//get data from post array
$fromAddress = "0x386975D3f3c6d9df2E1ad88a3358A4Cd1cdBB968";
$private_key = "0xC263E19DFC0FB8604C364A0B747A428CEA641B88372294535FC1BE1D4706C11A";
$businessAddress = "0x386975D3f3c6d9df2E1ad88a3358A4Cd1cdBB968";
$contract = new Contract($web3->provider, $CONTRACT_ABI);

//print_r($_POST);


//add new business wallet
$eth->getTransactionCount($fromAddress, 'pending', function ($err, $nonce) use ($eth,$contract,$fromAddress,$private_key,$contractAddress,$businessAddress) {
    if ($err !== null) {
        echo "Error: " . $err->getMessage();
    }

   $transactionData =  $contract->at($contractAddress)->getData('addNewBusinessWallet',$businessAddress);
  
    $transactionData = '0x'.$transactionData;

    $nonce = '0x'.Utils::toHex($nonce->toString());
	$transaction = new Transaction([
        "from" => $fromAddress,
        "nonce"=> $nonce,
        "gasPrice"=>"0x098bca5a00",
        "gasLimit"=>"0x0493e0",
        //"gasPrice"=>"0x098bca5a00",
        //"gasLimit"=>"0x010dd9",
        "to"=> $contractAddress ,
        //"value"=>"0x038d7ea4c68000",
        //"value"=>"0x0",
        "data"=>$transactionData,
        "chainId"=>4
	]);

    $signedTransaction = $transaction->sign($private_key);
	   $eth->sendRawTransaction('0x'.$signedTransaction, function ($err, $transaction) use ($eth, $fromAddress) {
            if ($err !== null) {
            //    echo 'Error: ' . $err->getMessage();
                $result = array('msg'=>'Error ! '.$err->getMessage(),'result'=>false);
                echo json_encode($result);
            }else{
               //echo 'Tx hash: ' . $transaction . PHP_EOL;
               $result = array('msg'=>'Success ! Business Wallet Added ','result'=>true);
                echo json_encode($result);
	   }
		});
	});


?>
