<html>

<body>
  <table>
    <tr>
      <td>
        <table cellpadding="20">
          <tr>
            <td style="height: 150px;"></td>
          </tr>
          <tr>
            <td style="text-align: right; font-size: 72px; height: 150px;">
              <img src="/assets/media/logos/logo.png" width="300px">
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="background-color: cadetblue; height: 20px;"></td>
    </tr>
    <tr>
      <td>
        <table cellpadding="20">
          <tr>
            <td>
              <span><?= $data['name']; ?></span><br>
              <span><?= $data['fullname']; ?></span><br>
              <span><?= tanggal($data['start'], 'dd MMMM yyyy'); ?></span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="background-color: lightblue; height: 10px;"></td>
    </tr>
    <tr>
      <td>
        <table cellpadding="20">
          <tr>
            <td style="height: 100px;"></td>
          </tr>
          <tr>
            <td>
              <img src="/<?= $qrcode; ?>" alt="<?= $data['fullname']; ?>" width="120px" />
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>