<?php require __DIR__ . '/../vendor/autoload.php';

$fields = $title = '';
$format = 'html';
if (isset($_POST['fields'])) {
  $fields = $_POST['fields'];
  $fields = json_decode($fields);
}
if (isset($_GET['format'])) $format = $_GET['format'];

if (!$fields) {
  $fields = (object) [
    'language' => 'en',
    'sendername' => 'Sender Name'
  ];
}

if ($fields->sendername) {
  switch ($fields->language) {
    case 'en':
      $title = 'Invoice';
      break;
    case 'fr':
      $title = 'Facture';
      break;
  }
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
    
    $mpdf->SetTitle($fields->sendername . ' - ' . $title . ' #' . $fields->invoicenumber);
    $mpdf->SetAuthor($fields->sendername);
    $mpdf->SetSubject($title);
    $mpdf->SetDisplayMode('fullpage');
    
    $mpdf->WriteHTML($template);
    
    $mpdf->Output($fields->prenom . '-' . $fields->nom . '-CV.pdf', 'I');
    break;
  default:
    http_response_code(404);
}
