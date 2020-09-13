<?php $template = '<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>' . $title . '</title>
  <style>
    .invoice-box {
      max-width: 1191px;
      margin: auto;
      padding: 30px;
      font-size: 16px;
      line-height: 24px;
      font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
      color: #555;
            
      <tr class="item last">
          <td>
              Domain name (1 year)
          </td>
          
          <td>
              $10.00
          </td>
      </tr>
    }
    
    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: left;
    }
    
    .invoice-box table td {
      padding: 5px;
      vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
      text-align: right;
    }
    
    .invoice-box table tr.top table td {
      padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
      font-size: 45px;
      line-height: 45px;
      color: #333;
    }
    
    .invoice-box table tr.information table td {
      padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
      background: #eee;
      border-bottom: 1px solid #ddd;
      font-weight: bold;
    }
    
    .invoice-box table tr.details td {
      padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
      border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
      border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
      border-top: 2px solid #eee;
      font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
      .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
      }
        
      .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
      }
    }
    </style>
</head>
<body>
  <div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
      <tr class="top">
        <td colspan="2">
          <table>
            <tr>
              <td class="title">';
              if (isset($fields->logo)):
                $template += '<img src="' . $fields->logo . '" style="width:100%; max-width:300px;">';
              endif;
              $template += '</td>
              <td>
                ' . $internationalization->title . $fields->invoicenumber . '<br>
                ' . $internationalization->date . ' January 1, 2015<br>
                ' . $internationalization->dueDate . ' February 1, 2015
              </td>
            </tr>
          </table>
        </td>
      </tr>     
      <tr class="information">
        <td colspan="2">
          <table>
            <tr>
              <td>
                Sparksuite, Inc.<br>
                12345 Sunny Road<br>
                Sunnyville, CA 12345
              </td>                 
              <td>
                Acme Corp.<br>
                John Doe<br>
                john@example.com
              </td>
            </tr>
          </table>
        </td>
      </tr>      
      <tr class="heading">
        <td>
        </td>
        <td>
        </td>
      </tr>
      <tr class="details">
        <td>
          Check
        </td>
        <td>
        </td>
      </tr>
      <tr class="heading">
        <td>
          Item
        </td>
        <td>
          Price
        </td>
      </tr>
      <tr class="item">
        <td>
          Website design
        </td>
        <td>
          $300.00
        </td>
      </tr>
      <tr class="total">
        <td>
        </td>
        <td>
          Total: $385.00
        </td>
      </tr>
    </table>
  </div>
</body>
</html>';
return $template;