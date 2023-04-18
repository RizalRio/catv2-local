<tr>
  <td><b>B. Skala 2: Profil Kapasitas Kognitif</b></td>
</tr>
<tr>
  <td>
    <table border="1" style="font-size: 11pt; text-align: center;">
      <tr>
        <td style="width: 20%;"><b>Dimensi</b></td>
        <td style="width: 60%;" colspan="4"><b>Kecenderungan</b></td>
        <td style="width: 20%;"><b>Dimensi</b></td>
      </tr>
      <tr>
        <td>Extravert</td>
        <?php $e = (isset($dimension['MBTI']) && isset($dimension['MBTI']['E'])) ? $dimension['MBTI']['E'] : '0'; ?>
        <td style="width: 25%; text-align: right;">
          <?php
          if ($e > 0)
            echo '<img src="/assets/media/bg/bar-' . $e . '.png" width="' . ($e * 20) . 'px" height="6px">&nbsp;&nbsp;';
          ?>
        </td>
        <td style="width: 5%;"><?= $e; ?></td>
        <?php $i = (isset($dimension['MBTI']) && isset($dimension['MBTI']['I'])) ? $dimension['MBTI']['I'] : '0'; ?>
        <td style="width: 5%;"><?= $i; ?></td>
        <td style="width: 25%; text-align: left;">
          <?php
          if ($i > 0)
            echo '<img src="/assets/media/bg/bar-' . $i . '.png" width="' . ($i * 20) . 'px" height="6px">';
          ?>
        </td>
        <td>Introvert</td>
      </tr>
      <tr>
        <td>Sensing</td>
        <?php $s = (isset($dimension['MBTI']) && isset($dimension['MBTI']['S'])) ? $dimension['MBTI']['S'] : '0'; ?>
        <td style="width: 25%; text-align: right;">
          <?php
          if ($s > 0)
            echo '<img src="/assets/media/bg/bar-' . $s . '.png" width="' . ($s * 20) . 'px" height="6px">&nbsp;&nbsp;';
          ?>
        </td>
        <td style="width: 5%;"><?= $s; ?></td>
        <?php $n = (isset($dimension['MBTI']) && isset($dimension['MBTI']['N'])) ? $dimension['MBTI']['N'] : '0'; ?>
        <td style="width: 5%;"><?= $n; ?></td>
        <td style="width: 25%; text-align: left;">
          <?php
          if ($n > 0)
            echo '<img src="/assets/media/bg/bar-' . $n . '.png" width="' . ($n * 20) . 'px" height="6px">';
          ?>
        </td>
        <td>iNtution</td>
      </tr>
      <tr>
        <td>Thinking</td>
        <?php $t = (isset($dimension['MBTI']) && isset($dimension['MBTI']['T'])) ? $dimension['MBTI']['T'] : '0'; ?>
        <td style="width: 25%; text-align: right;">
          <?php
          if ($t > 0)
            echo '<img src="/assets/media/bg/bar-' . $t . '.png" width="' . ($t * 20) . 'px" height="6px">&nbsp;&nbsp;';
          ?>
        </td>
        <td style="width: 5%;"><?= $t; ?></td>
        <?php $f = (isset($dimension['MBTI']) && isset($dimension['MBTI']['F'])) ? $dimension['MBTI']['F'] : '0'; ?>
        <td style="width: 5%;"><?= $f; ?></td>
        <td style="width: 25%; text-align: left;">
          <?php
          if ($f > 0)
            echo '<img src="/assets/media/bg/bar-' . $f . '.png" width="' . ($f * 20) . 'px" height="6px">';
          ?>
        </td>
        <td>Feeling</td>
      </tr>
      <tr>
        <td>Judging</td>
        <?php $j = (isset($dimension['MBTI']) && isset($dimension['MBTI']['J'])) ? $dimension['MBTI']['J'] : '0'; ?>
        <td style="width: 25%; text-align: right;">
          <?php
          if ($j > 0)
            echo '<img src="/assets/media/bg/bar-' . $j . '.png" width="' . ($j * 20) . 'px" height="6px">&nbsp;&nbsp;';
          ?>
        </td>
        <td style="width: 5%;"><?= $j; ?></td>
        <?php $p = (isset($dimension['MBTI']) && isset($dimension['MBTI']['P'])) ? $dimension['MBTI']['P'] : '0'; ?>
        <td style="width: 5%;"><?= $p; ?></td>
        <td style="width: 25%; text-align: left;">
          <?php
          if ($p > 0)
            echo '<img src="/assets/media/bg/bar-' . $p . '.png" width="' . ($p * 20) . 'px" height="6px">';
          ?>
        </td>
        <td>Perceiving</td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td><b>Deskripsi Hasil : </b></td>
</tr>
<tr>
  <td><?= $narration['MBTI'] ?></td>
</tr>
<tr>
  <td></td>
</tr>