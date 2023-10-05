<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">
    <title>Aidepos</title>
    <style>
      html body {
        font-family: 'Open Sans', sans-serif!important;
        color: #373A3C;
      }
      p.heading {
        font-weight: 500;
        letter-spacing: 0.5px;
        margin:10px;
        font-family: 'Open Sans', sans-serif;
        font-size: 25px;
      }
      p {
        font-size: 12.5px;
        margin-bottom: 30px;
      }
      table {  
        font-family: arial, sans-serif;  
        border-collapse: collapse;  
        width: 100%;
        margin: 0px auto;
        border: 2px solid #e6e6e6;
      }
      #htmlContent{
        font-family: 'Open Sans', sans-serif;
        text-align: center;
      }
      .table thead > th {
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        background-color: #f5f5f5
      }
      td, th {  
        border: 2px solid #e6e6e6;
        text-align: left; 
        font-size: 14px;
        padding: 8px;  
      }
      @font-face {
        font-family: 'Open Sans', sans-serif;
        font-style: normal;
        font-weight: normal;
      }
    </style>  
</head>
<body>
  <div id="htmlContent">
    <p class="heading"><?= $heading; ?></p>  
    <p><?= $date; ?></p>  
    <table class="table">  
      <thead> 
        <tr>  
          <th>Contract</th>
          <th>Store</th>
          <th>Customer Name</th>
          <th>Amount</th>
          <th>Balance</th>
          <th>Paid Amount</th>
          <th>Date Last Paid</th>
          <th>Due Date</th>
          <th>Status</th>
        </tr>
      </thead>  
      <tbody>  
        <?php 
        if(count($report_data) > 0) {
          foreach($report_data as $k => $v) { 
        ?>
        <tr>  
            <td><?= 'LAY-000'.$v['contract']; ?></td>
            <td><?= $v['store_name']; ?></td>
            <td><?= $v['customer_name']; ?></td>
            <td><?= $v['amount']; ?></td>
            <td><?= $v['balance']; ?></td>
            <td><?= $v['paid_amount']; ?></td>
            <td><?= $v['date_last_paid']; ?></td>
            <td><?= $v['due_date']; ?></td>
            <td><?= $v['status']; ?></td>
        </tr>
          <?php } } else {  ?>
          <tr>
            <td colspan="9" style="text-align: center;">No Data Found</td>
          </tr>
        <?php } ?>
      </tbody>  
    </table>    
  </div>
</body>
</html>