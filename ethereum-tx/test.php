<?php 
require 'vendor/autoload.php';
use Web3p\EthereumTx\Transaction;

$private_key = "8E53B7CC70767A68551DD50F1A418F7FEDC1A9B7D80C3A19E892A123A70E5AE5";

// without chainId
$transaction = new Transaction([
    'nonce' => '0x01',
    'from' => '0xb60e8dd61c5d32be8058bb8eb970870f07233155',
    'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
    'gas' => '0x76c0',
    'gasPrice' => '0x9184e72a000',
    'value' => '0x9184e72a',
    'data' => '0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675'
]);
echo $transaction;
$signedTransaction = $transaction->sign($private_key);
echo $signedTransaction;

// with chainId
$transaction = new Transaction([
    'nonce' => '0x01',
    'from' => '0xb60e8dd61c5d32be8058bb8eb970870f07233155',
    'to' => '0xd46e8dd67c5d32be8058bb8eb970870f07244567',
    'gas' => '0x76c0',
    'gasPrice' => '0x9184e72a000',
    'value' => '0x9184e72a',
    'chainId' => 1,
    'data' => '0xd46e8dd67c5d32be8d46e8dd67c5d32be8058bb8eb970870f072445675058bb8eb970870f072445675'
]);

// hex encoded transaction
$transaction = new Transaction('0xf86c098504a817c800825208943535353535353535353535353535353535353535880de0b6b3a76400008025a028ef61340bd939bc2195fe537567866003e1a15d3c71ff63e1590620aa636276a067cbe9d8997f761aecb703304b3800ccf555c9f3dc64214b297fb1966a3b6d83');
?>