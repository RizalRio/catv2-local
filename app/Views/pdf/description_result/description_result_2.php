<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    body {
      font-family: "Arial", sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background-color: #f7f9ff;
      color: #333;
    }

    header {
      background-color: #577085;
      color: white;
      padding: 10px 20px;
      text-align: center;
    }

    .section {
      padding: 20px 30px;
      margin: 20px auto;
      max-width: 1200px;
      background: white;
      border: 1px solid #ddd;
      border-radius: 8px;
    }

    h2 {
      background-color: #e6f4f1;
      padding: 10px;
      border-left: 5px solid #577085;
      margin-bottom: 20px;
      margin-top: 0;
    }

    p {
      text-align: justify;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    .table th,
    .table td {
      border: 1px solid #ddd;
      padding: 8px;
    }

    .table th {
      background-color: #577085;
      color: white;
    }

    .table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .kode {
      text-align: center;
    }

    .blue {
      background-color: #007bff;
    }

    .green {
      background-color: #28a745;
    }

    .purple {
      background-color: #6f42c1;
    }

    .orange {
      background-color: #fd7e14;
    }

    .light-orange {
      background-color: #f0ad4e;
    }

    .red {
      background-color: #dc3545;
    }

    .graf_bar {
      width: 100%;
      border-collapse: collapse;
      height: 15px;
      table-layout: fixed;
    }

    .graf_bar td {
      border: none;
      color: white;
      font-weight: bold;
      text-align: right;
      padding: 0 4px;
    }
  </style>
</head>

<body>
  <?php $color = 'default' ?>
  <header>
    <h1 style="margin: 0">Hasil Tes</h1>
  </header>
  <div class="section" style="padding-bottom: 0">
    <h2>A. Deskripsi Tema dan Tema Utama</h2>
    <p style="margin: 0">
      Asesmen berbasis teori RIASEC oleh John Holland dirancang untuk membantu
      Anda memahami hubungan antara minat karir, potensi keterampilan, dan
      pilihan pekerjaan yang sesuai dengan kepribadian Anda. RIASEC terdiri
      dari enam tipe utama: Realistic, Investigative, Artistic, Social,
      Enterprising, dan Conventional, yang masing-masing menggambarkan
      preferensi terhadap aktivitas tertentu, nilai, dan lingkungan kerja.
      <br />
      Penjelasan berikut akan menguraikan masing-masing tipe RIASEC secara
      terperinci, termasuk karakteristik utama, minat, aktivitas pekerjaan,
      keterampilan, dan nilai yang dimiliki oleh setiap tipe. Dengan pemahaman
      yang lebih baik tentang tipe-tipe ini, diharapkan Anda dapat
      mengeksplorasi dan menemukan pilihan karir yang sesuai dengan
      kepribadian dan aspirasi Anda.
    </p>
    <table class="table">
      <tr style="text-align: center">
        <th>Kode</th>
        <th>Tema</th>
        <th>Karakteristik Utama</th>
        <th>Minat dan Aktivitas</th>
        <th>Potensi Keterampilan</th>
        <th>Nilai</th>
      </tr>
      <tr>
        <td class="kode">R</td>
        <td>Realistic</td>
        <td>
          Praktis, suka bekerja dengan objek nyata, alat, dan mesin; lebih
          suka aktivitas fisik.
        </td>
        <td>
          Bekerja di luar ruangan, memperbaiki mesin, atau pekerjaan fisik.
        </td>
        <td>
          Ketangkasan mekanik, koordinasi fisik, kemampuan menggunakan alat.
        </td>
        <td>Kepraktisan, tradisi, dan akal sehat.</td>
      </tr>
      <tr>
        <td class="kode">I</td>
        <td>Investigative</td>
        <td>
          Analitis, logis, dan menyukai penelitian serta pemecahan masalah.
        </td>
        <td>
          Melakukan penelitian, memecahkan masalah abstrak, dan menulis
          laporan.
        </td>
        <td>
          Kemampuan analitis, berpikir kritis, dan melakukan penelitian.
        </td>
        <td>Kemandirian, rasa ingin tahu, dan pembelajaran.</td>
      </tr>
      <tr>
        <td class="kode">A</td>
        <td>Artistic</td>
        <td>
          Kreatif, imajinatif, dan suka mengekspresikan diri melalui seni.
        </td>
        <td>
          Melukis, menggubah musik, menulis cerita, atau menciptakan seni.
        </td>
        <td>Kreativitas, kemampuan seni rupa, musik, dan ekspresi verbal.</td>
        <td>Keindahan, orisinalitas, kemandirian, imajinasi.</td>
      </tr>
      <tr>
        <td class="kode">S</td>
        <td>Social</td>
        <td>Sosial, suka membantu orang lain, dan memiliki empati tinggi.</td>
        <td>
          Mengajar, melatih, memberikan konseling, atau membantu orang lain.
        </td>
        <td>Kemampuan interpersonal, mendengarkan, dan empati.</td>
        <td>Kerja sama, kemurahan hati, dan layanan kepada orang lain.</td>
      </tr>
      <tr>
        <td class="kode">E</td>
        <td>Enterprising</td>
        <td>
          Berani mengambil risiko, suka memimpin, dan memiliki jiwa wirausaha.
        </td>
        <td>Menjual, memimpin, membujuk, dan memotivasi orang lain.</td>
        <td>Kemampuan verbal, memotivasi, dan mengambil inisiatif.</td>
        <td>Pengaruh, status, keberanian mengambil risiko.</td>
      </tr>
      <tr>
        <td class="kode">C</td>
        <td>Conventional</td>
        <td>
          Sistematis, terorganisir, dan menyukai pekerjaan administratif.
        </td>
        <td>
          Mengorganisasi data, menyimpan catatan, atau membuat sistem
          komputer.
        </td>
        <td>
          Kemampuan bekerja dengan angka, perhatian terhadap detail,
          efisiensi.
        </td>
        <td>Stabilitas, ketelitian, dan efisiensi.</td>
      </tr>
    </table>
  </div>

  <div class="section" style="padding-bottom: 0">
    <h2>B. Kode Utama</h2>
    <div
      style="
          padding: 0.5rem 2rem 0.5rem 2rem;
          text-align: left;
          border: 1px solid #ddd;
          background-color: #dbe8e6;
          border: 1px solid #ddd;
          border-radius: 8px;
        ">
      <table style="text-align: left; border-collapse: collapse; width: 100%">
        <tr>
          <th style="text-align: left; width: 70%">
            TEMA DOMINAN ANDA
            <hr />
          </th>
          <th style="text-align: left; width: 30%">
            KODE TEMA ANDA
            <hr />
          </th>
        </tr>
        <?php if (isset($scoring['Minat Karir'])) : ?>
          <tr>
            <td>
              <?php
              $dominantTheme = [];
              foreach ($scoring['Minat Karir']['dominan'] as $value) {
                if ($value == 'R') {
                  array_push($dominantTheme, 'Realistic');
                } elseif ($value == 'I') {
                  array_push($dominantTheme, 'Investigative');
                } elseif ($value == 'A') {
                  array_push($dominantTheme, 'Artistic');
                } elseif ($value == 'S') {
                  array_push($dominantTheme, 'Social');
                } elseif ($value == 'E') {
                  array_push($dominantTheme, 'Enterprising');
                } elseif ($value == 'C') {
                  array_push($dominantTheme, 'Conventional');
                }
              }

              echo implode(',', $dominantTheme);
              ?>
            </td>
            <td><?= implode('', $scoring['Minat Karir']['dominan']) ?></td>
          </tr>
        <?php endif; ?>
      </table>
    </div>
    <?php if (isset($scoring['Minat Karir'])) : ?>
      <table class="table">
        <tr>
          <th style="width: 15%">TEMA</th>
          <th style="width: 5%">KODE</th>
          <th style="width: 55%">SKOR</th>
          <th style="width: 15%">SKOR</th>
        </tr>
        <?php
        $counter = 0;
        foreach ($scoring['Minat Karir']['data'] as $keyKarir => $valueKarir) :
          if ($counter >= 3) break;
          if ($keyKarir == 'R' || $keyKarir == 'I' || $keyKarir == 'A' || $keyKarir == 'S' || $keyKarir == 'E' || $keyKarir == 'C') :
            $counter++;
        ?>
            <tr>
              <td>
                <?php
                if ($keyKarir == 'R') {
                  echo 'Realistic';
                  $color = 'green';
                } elseif ($keyKarir == 'I') {
                  echo 'Investigative';
                  $color = 'blue';
                } elseif ($keyKarir == 'A') {
                  echo 'Artistic';
                  $color = 'purple';
                } elseif ($keyKarir == 'S') {
                  echo 'Social';
                  $color = 'red';
                } elseif ($keyKarir == 'E') {
                  echo 'Enterprising';
                  $color = 'orange';
                } elseif ($keyKarir == 'C') {
                  echo 'Conventional';
                  $color = 'light-orange';
                }
                ?>
              </td>
              <td class="kode"><?= $keyKarir ?></td>
              <td>
                <table class="graf_bar">
                  <tr>
                    <td class="<?= $color ?>" style="width: <?= $valueKarir['percentage'] ?>%"><?= $valueKarir['percentage'] ?>%</td>
                    <td></td>
                    <td></td>
                  </tr>
                </table>
              </td>
              <td class="kode"><?= $valueKarir['percentage'] ?></td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
    <?php if (isset($scoring['Minat Karir'])) : ?>
      <p style="margin: 0">Deskripsi Tema Dominan dan Pendukung:</p>
      <ul
        style="
          padding-left: 1.5rem;
          margin: 0.2rem 0;
          line-height: 1.4;
          text-align: justify;
        ">
        <?php foreach ($scoring['Minat Karir']['dominan'] as $valueDominant) : ?>
          <?php if ($valueDominant == 'R' || $valueDominant == 'I' || $valueDominant == 'A' || $valueDominant == 'S' || $valueDominant == 'E' || $valueDominant == 'C') : ?>
            <?php
            if ($valueDominant == 'R') {
              $theme = 'Realistic';
              $description = 'Mewakili sifat yang pragmatis dan konvensional. Orang dengan skor tinggi cenderung berbakat secara mekanik atau teknis, cenderung kurang interaksi sosial, dan tegas.';
            } elseif ($valueDominant == 'I') {
              $theme = 'Investigative';
              $description = 'Mewakili sifat yang rasional dan intelektual. Orang dengan skor tinggi cenderung condong pada bidang ilmiah, rasa ingin tahu tinggi, dan mandiri.';
            } elseif ($valueDominant == 'A') {
              $theme = 'Artistic';
              $description = 'Mewakili sifat ekspresif dan kreatif. Orang dengan skor tinggi cenderung menyukai seni, sensitif, imajinatif, dan tidak konvensional.';
            } elseif ($valueDominant == 'S') {
              $theme = 'Social';
              $description = 'Mewakili sifat yang ramah dan bertanggung jawab secara sosial. Orang dengan skor tinggi cenderung suka membantu orang lain, ekstrovert, dan kooperatif.';
            } elseif ($valueDominant == 'E') {
              $theme = 'Enterprising';
              $description = 'Mewakili sifat yang dominan secara sosial dan penuh petualangan. Orang dengan skor tinggi cenderung suka memimpin, energik, dan antusias.';
            } elseif ($valueDominant == 'C') {
              $theme = 'Conventional';
              $description = 'Mewakili sifat yang sesuai dengan keteraturan dan kesesuaian. Orang dengan skor tinggi cenderung menyukai aktivitas yang terorganisir atau berbasis data.';
            }
            ?>
            <li>
              Tema dominan adalah <?= $theme ?> (<?= $valueDominant ?>) : <?= $description ?>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</body>

</html>