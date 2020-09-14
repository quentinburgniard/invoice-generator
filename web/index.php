<?php require __DIR__ . '/../vendor/autoload.php';

$fields = $title = '';
$internationalization = (object) [];
$format = 'html';
if (isset($_POST['fields'])) {
  $fields = $_POST['fields'];
  $fields = json_decode($fields);
}
if (isset($_GET['format'])) $format = $_GET['format'];

if (!$fields) {
  $fields = (object) [
    'currency' => 'EUR',
    'date' => '2016-01-01',
    'invoicenumber' => '001',
    'recipientname' => 'Recipient Name',
    'recipientdetails' => 'Details',
    'sendername' => 'Sender Name',
    'senderdetails' => 'Details'
  ];
}

$language = 'en';
if (isset($fields->language)) $language = $fields->language;
if (isset($_GET['language'])) $language = $_GET['language'];

if (isset($fields->invoicenumber) && isset($fields->sendername)) {
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
  $title = $fields->sendername . ' - ' . $internationalization->title . $fields->invoicenumber;
}

function formatNumber($currency, $amount) {
  $amount = number_format($amount, 2);
  switch ($currency) {
    case 'CHF':
      $amount = $amount . '.-';
      break;
    case 'EUR':
      $amount = $amount . '€';
      break;
    case 'USD':
      $amount = '$' . $amount;
      break;
    default:
  }
  return $amount;
}

$template = include '../template.php';

switch ($format) {
  case 'html':
    echo $template;
    break;
  case 'pdf':
    $mpdf = new \Mpdf\Mpdf([
      // 'default_font' => 'lato',
      'dpi' => 300,
      // 'fontdata' => [
      // 	'catamaran' => [
      // 		'R' => 'Catamaran-ExtraLight.ttf'
      // 	],
      // 	'lato' => [
      // 		'R' => 'Lato-Regular.ttf',
      // 		'B' => 'Lato-Bold.ttf',
      // 		'I' => 'Lato-Italic.ttf',
      // 	],
      // 	'fontawesome' => [
      // 		'R' => 'fontawesome-webfont.ttf',
      // 	]
      // ],
      // 'fontDir' => __DIR__ . '/../fonts',
      'img_dpi' => 300,
      'progressBar' => true
    ]);
    
    $mpdf->SetTitle($title);
    if (isset($fields->sendername)) $mpdf->SetAuthor($fields->sendername);
    $mpdf->SetSubject($title);
    $mpdf->SetDisplayMode('fullpage');
    
    $mpdf->WriteHTML($template);
    
    $mpdf->Output($title + '.pdf', 'I');
    break;
  default:
    http_response_code(404);
}