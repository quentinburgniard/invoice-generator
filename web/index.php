<?php $fields = $title = '';
$internationalization = (object) [];
$format = 'html';
if (isset($_POST['fields'])) {
  $fields = $_POST['fields'];
  $fields = json_decode($fields);
}
if (isset($fields->format) && $fields->format) $format = $fields->format;
if (isset($_GET['format'])) $format = $_GET['format'];

if (!isset($fields->currency)) $fields->currency = 'eur';
if (!isset($fields->date)) $fields->date = '2020-01-01';
if (!isset($fields->invoicenumber)) $fields->invoicenumber = '001';
if (!isset($fields->recipientname)) $fields->recipientname = 'Recipient Name';
if (!isset($fields->recipientdetails)) $fields->recipientdetails = 'Details';
if (!isset($fields->sendername)) $fields->sendername = 'Sender Name';
if (!isset($fields->senderdetails)) $fields->senderdetails = 'Details';

$language = 'en';
if (isset($fields->language) && $fields->language) $language = $fields->language;
if (isset($_GET['language'])) $language = $_GET['language'];


switch ($language) {
  case 'en':
    $internationalization->date = 'Date:';
    $internationalization->dueDate = 'Due:';
    $internationalization->item = 'Item';
    $internationalization->paymentMethod = 'Payment Method';
    $internationalization->price = 'Price';
    $internationalization->title = 'Invoice #';
    $internationalization->total = 'Total:';
    break;
  case 'fr':
    $internationalization->date = 'Date :';
    $internationalization->dueDate = 'Échéance :';
    $internationalization->item = 'Objet';
    $internationalization->paymentMethod = 'Méthode de paiement';
    $internationalization->price = 'Montant';
    $internationalization->title = 'Facture #';
    $internationalization->total = 'Total :';
    break;
}

if (isset($fields->invoicenumber) && isset($fields->sendername)) {
  $title = $fields->sendername . ' - ' . $internationalization->title . $fields->invoicenumber;
} else {
  $title = $internationalization->title;
}

function formatNumber($currency, $amount) {
  $amount = number_format($amount, 2);
  switch ($currency) {
    case 'chf':
      $amount = $amount . '.-';
      break;
    case 'eur':
      $amount = $amount . '€';
      break;
    case 'usd':
      $amount = '$' . $amount;
      break;
    default:
  }
  return $amount;
}

$template = include '../template.php';

switch ($format) {
  case 'html':
  case 'pdf':
    echo $template;
    break;
  default:
    http_response_code(404);
}