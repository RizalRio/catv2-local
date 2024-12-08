<html>

<head>
  <style>
    table {
      width: 100%;
    }

    .img-logo {
      width: 220px;
    }

    td.td-table-information::before {
      height: 1.2em;
      content: "";
    }

    td.td-table-information {
      padding-top: 2rem
    }

    .header,
    .footer {
      width: 100%;
      position: fixed;
      font-weight: normal;
    }

    .header {
      top: 0px;
      text-align: right;
    }

    .footer {
      bottom: 0px;
    }

    .table-logo {
      margin-top: 2rem;
    }

    .line-one {
      color: #687eff;
      height: 14px;
    }
  </style>
</head>

<body>
  <table class="table-logo">
    <tr>
      <td style="padding-top: 1rem;text-align: right;"><img src="assets/media/logos/logo.jpg" class="img-logo"></td>
    </tr>
  </table>
  <table class="table-information">
    <tr class="tr-table-information">
      <td class="td-table-information" colspan="2">
        <hr class="line-one" />
      </td>
    </tr>
    <tr>
      <td class="td-table-information" style="text-align: left">
        <p style="font-size: 26px; letter-spacing: 3px; font-weight: bold">
          TITIAN INDONESIA
        </p>
        <p style="font-size: 16px; padding: 0">
          For Better Quality Of Human Life
        </p>
      </td>
    </tr>
    <tr class="tr-table-information">
      <td class="td-table-information" colspan="2">
        <hr style="color: #98e4ff; height: 8px" />
      </td>
    </tr>
    <tr class="td-table-information">
      <td class="td-table-information" style="text-align: right">
        <p style="font-size: 18px;font-weight: bold;">
          <?= $name ?>
        </p>
        <br>
        <p style="font-size: 18px"><?= $username ?></p>
        <br>
        <p style="font-size: 16px"><?= date("d F Y", strtotime($start)) ?></p>
      </td>
    </tr>
  </table>
</body>

</html>