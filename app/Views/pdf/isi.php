<html>
  <head>
    <style>
      .main-table {
        border-collapse: collapse;
        border: 0.5px solid black;
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        font-size: 10pt;
        font-family: Arial, sans-serif;
      }
      .main-header > td {
        border: 0.5px solid black;
        text-align: center;
      }
      .main-table > tr > td {
        border: 0.2px solid black;
        padding: 8px;
      }
    </style>
  </head>
  <body>
    <table style="padding: 10px 0 10px 0;">
      <?php if (isset($dimension['RIASEC'])) {
        echo view('pdf/riasec', ['dimension' => $dimension]);
      } ?>
      <?php if (isset($dimension['MBTI'])) {
        echo view('pdf/mbti', ['dimension' => $dimension]);
      } ?>
    </table>
  </body>
</html>