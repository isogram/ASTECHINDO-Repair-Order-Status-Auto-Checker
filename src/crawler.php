<?php

/**
* September 2015
* Script by Muhammad Shidiq <emshidiq@gmail.com>
*/

require dirname(__FILE__) . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

// define mandrill api
define('MANDRILL_USERNAME', 'YOUR MANDRILL USERNAME');
define('MANDRILL_PASSWORD', 'YOUR MANDRILL API KEY');

// define string to match 
$defaultMessage = md5('UNIT WAS IN THE PROCESS OF UNDER REPAIR');
$url = 'http://astech.co.id:66/Default.aspx';

$client = new GuzzleHttp\Client();

// required params
// change this with yours
$mCareForm = [
  'first' => 'A',
  'second' => 'JAS1',
  'third' => '3029',
  'checkstatus' => 'Check Status',
  'four' => '0915'
];

// do request
$response = $client->request('POST', $url, [
    'form_params' => $mCareForm
]);

$htmlResponse = $response->getBody()->__toString();

// process the response
$parse = new Crawler();
$parse->addContent($htmlResponse);

$tableRow =  $parse->filter('body > #d2 > table > tr')->each(
	function ($node, $i) {
		return $node->text();
	});

$mCareMessage = trim($tableRow[1]);

// compare defined string with crawled string
// if doesn't match send email to me!
if (md5($mCareMessage) !== $defaultMessage) {

	$subject = 'Your Status Repair!';
	$from = array('from@example.com' =>'From Example');
	$to = ['to@example.com'];
	$body = "Hi Boss, your repair order status is <strong>$mCareMessage</strong>";

	$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
	$transport->setUsername(MANDRILL_USERNAME);
	$transport->setPassword(MANDRILL_PASSWORD);

	$swift = Swift_Mailer::newInstance($transport);

	$message = new Swift_Message($subject);
	$message->setFrom($from);
	$message->setBody($body, 'text/html');
	$message->setTo($to);

	if ($recipients = $swift->send($message, $failures))
	{
	 echo 'Message successfully sent!';
	} else {
	 echo "There was an error:\n";
	 print_r($failures);
	}

}