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

    h3 {
      color: #384955;
      margin: 0;
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
      position: relative;
    }

    .table th,
    .tr_table td {
      background-color: #577085;
      color: white;
      text-align: center;
    }

    .tr_table td {
      font-size: 10px;
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

    .light-blue {
      background-color: #17a2b8;
    }

    .yellow {
      background-color: #ffc107;
    }

    .dot {
      font-size: 30px;
      margin: 40%;
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

  <div class="section">
    <?php if (isset($scoring['Minat Karir'])) : ?>
      <h3>1. Minat Karir</h3>
      <div>
        <table
          class="table"
          style="text-align: left; border-collapse: collapse; width: 100%">
          <tr style="text-align: center">
            <th style="width: 20%">Dimensi</th>
            <th style="width: 25%">Rendah (Trait)</th>
            <th style="width: 5%; text-align: center">1</th>
            <th style="width: 5%; text-align: center">2</th>
            <th style="width: 5%; text-align: center">3</th>
            <th style="width: 5%; text-align: center">4</th>
            <th style="width: 5%; text-align: center">5</th>
            <th style="width: 5%; text-align: center">6</th>
            <th style="width: 25%">Kuat (Trait)</th>
          </tr>
          <?php if (isset($scoring['Minat Karir']['data']['R']['percentage'])) : ?>
            <tr>
              <td>Realistic</td>
              <td>Tidak fleksibel, keras kepala, kurang kreatif.</td>
              <td><?= ($scoring['Minat Karir']['data']['R']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['R']['percentage'] >= 16 && $scoring['Minat Karir']['data']['R']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['R']['percentage'] >= 33 && $scoring['Minat Karir']['data']['R']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['R']['percentage'] >= 50 && $scoring['Minat Karir']['data']['R']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['R']['percentage'] >= 67 && $scoring['Minat Karir']['data']['R']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['R']['percentage'] >= 83 && $scoring['Minat Karir']['data']['R']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>Praktis, mandiri, pekerja keras, efisien, logis.</td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['I']['percentage'])) : ?>
            <tr>
              <td>Investigative</td>
              <td>Pesimis, terlalu berhati-hati, kurang sosial.</td>
              <td><?= ($scoring['Minat Karir']['data']['I']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['I']['percentage'] >= 16 && $scoring['Minat Karir']['data']['I']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['I']['percentage'] >= 33 && $scoring['Minat Karir']['data']['I']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['I']['percentage'] >= 50 && $scoring['Minat Karir']['data']['I']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['I']['percentage'] >= 67 && $scoring['Minat Karir']['data']['I']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['I']['percentage'] >= 83 && $scoring['Minat Karir']['data']['I']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>
                Analitis, kritis, penuh rasa ingin tahu, logis, intelektual.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['A']['percentage'])) : ?>
            <tr>
              <td>Artistic</td>
              <td>Tidak terorganisir, impulsif, terlalu idealis.</td>
              <td><?= ($scoring['Minat Karir']['data']['A']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['A']['percentage'] >= 16 && $scoring['Minat Karir']['data']['A']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['A']['percentage'] >= 33 && $scoring['Minat Karir']['data']['A']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['A']['percentage'] >= 50 && $scoring['Minat Karir']['data']['A']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['A']['percentage'] >= 67 && $scoring['Minat Karir']['data']['A']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['A']['percentage'] >= 83 && $scoring['Minat Karir']['data']['A']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>Kreatif, inovatif, sensitif, introspektif, ekspresif.</td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['S']['percentage'])) : ?>
            <tr>
              <td>Social</td>
              <td>
                Kurang empatik, individualistik, menghindari tanggung jawab
                sosial.
              </td>
              <td><?= ($scoring['Minat Karir']['data']['S']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['S']['percentage'] >= 16 && $scoring['Minat Karir']['data']['S']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['S']['percentage'] >= 33 && $scoring['Minat Karir']['data']['S']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['S']['percentage'] >= 50 && $scoring['Minat Karir']['data']['S']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['S']['percentage'] >= 67 && $scoring['Minat Karir']['data']['S']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['S']['percentage'] >= 83 && $scoring['Minat Karir']['data']['S']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>Ramah, empatik, pengertian, sabar, kooperatif.</td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['E']['percentage'])) : ?>
            <tr>
              <td>Enterprising</td>
              <td>Dominan, egois, kurang perhatian pada orang lain.</td>
              <td><?= ($scoring['Minat Karir']['data']['E']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['E']['percentage'] >= 16 && $scoring['Minat Karir']['data']['E']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['E']['percentage'] >= 33 && $scoring['Minat Karir']['data']['E']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['E']['percentage'] >= 50 && $scoring['Minat Karir']['data']['E']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['E']['percentage'] >= 67 && $scoring['Minat Karir']['data']['E']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['E']['percentage'] >= 83 && $scoring['Minat Karir']['data']['E']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>Percaya diri, ambisius, persuasif, optimistis, kompetitif.</td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['C']['percentage'])) : ?>
            <tr>
              <td>Conventional</td>
              <td>Kaku, kurang fleksibel, tidak kreatif.</td>
              <td><?= ($scoring['Minat Karir']['data']['C']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['C']['percentage'] >= 16 && $scoring['Minat Karir']['data']['C']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['C']['percentage'] >= 33 && $scoring['Minat Karir']['data']['C']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['C']['percentage'] >= 50 && $scoring['Minat Karir']['data']['C']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['C']['percentage'] >= 67 && $scoring['Minat Karir']['data']['C']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['C']['percentage'] >= 83 && $scoring['Minat Karir']['data']['C']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>Terorganisir, teliti, efisien, praktis, patuh pada aturan.</td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['Conc']['percentage'])) : ?>
            <tr>
              <td colspan="2">Kepedulian Karir (CONC)</td>
              <td><?= ($scoring['Minat Karir']['data']['Conc']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conc']['percentage'] >= 16 && $scoring['Minat Karir']['data']['Conc']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conc']['percentage'] >= 33 && $scoring['Minat Karir']['data']['Conc']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conc']['percentage'] >= 50 && $scoring['Minat Karir']['data']['Conc']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conc']['percentage'] >= 67 && $scoring['Minat Karir']['data']['Conc']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conc']['percentage'] >= 83 && $scoring['Minat Karir']['data']['Conc']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>
                Kesadaran akan pentingnya mempersiapkan karir dan optimisme dalam
                merencanakan masa depan.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['Cont']['percentage'])) : ?>
            <tr>
              <td colspan="2">Pengendalian Karir (CONT)</td>
              <td><?= ($scoring['Minat Karir']['data']['Cont']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Cont']['percentage'] >= 16 && $scoring['Minat Karir']['data']['Cont']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Cont']['percentage'] >= 33 && $scoring['Minat Karir']['data']['Cont']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Cont']['percentage'] >= 50 && $scoring['Minat Karir']['data']['Cont']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Cont']['percentage'] >= 67 && $scoring['Minat Karir']['data']['Cont']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Cont']['percentage'] >= 83 && $scoring['Minat Karir']['data']['Cont']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>
                Disiplin diri untuk berhati-hati, teratur, dan mampu membuat
                keputusan selama transisi karir.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['Conp']['percentage'])) : ?>
            <tr>
              <td colspan="2">Konsepsi Karir (CONP)</td>
              <td><?= ($scoring['Minat Karir']['data']['Conp']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conp']['percentage'] >= 16 && $scoring['Minat Karir']['data']['Conp']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conp']['percentage'] >= 33 && $scoring['Minat Karir']['data']['Conp']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conp']['percentage'] >= 50 && $scoring['Minat Karir']['data']['Conp']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conp']['percentage'] >= 67 && $scoring['Minat Karir']['data']['Conp']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conp']['percentage'] >= 83 && $scoring['Minat Karir']['data']['Conp']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>
                Keterbukaan terhadap masukan, mencari informasi, dan berani
                mengambil keputusan realistis.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Minat Karir']['data']['Conf']['percentage'])) : ?>
            <tr>
              <td colspan="2">Penerimaan Karir (CONF)</td>
              <td><?= ($scoring['Minat Karir']['data']['Conf']['percentage'] < 16) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conf']['percentage'] >= 16 && $scoring['Minat Karir']['data']['Conf']['percentage'] < 33) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conf']['percentage'] >= 33 && $scoring['Minat Karir']['data']['Conf']['percentage'] < 50) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conf']['percentage'] >= 50 && $scoring['Minat Karir']['data']['Conf']['percentage'] < 67) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conf']['percentage'] >= 67 && $scoring['Minat Karir']['data']['Conf']['percentage'] < 83) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td><?= ($scoring['Minat Karir']['data']['Conf']['percentage'] >= 83 && $scoring['Minat Karir']['data']['Conf']['percentage'] < 100) ? '<span class="dot">&bull;</span>' : '' ?></td>
              <td>
                Kemampuan menerima, merasa efektif, dan produktif dalam menentukan
                serta menjalani pilihan karir.
              </td>
            </tr>
          <?php endif; ?>
        </table>
        <p>
          Hasil asesmen menunjukkan tipe karir yang sesuai dengan kepribadian
          berdasarkan pendekatan
          <strong>teori minta dari Holland</strong>. Setiap tipe mencerminkan
          preferensi dan kecenderungan Anda dalam lingkungan kerja, Kombinasi
          tipe memberikan gambaran yang komprehensif mengenai potensi karir
          Anda. Selain itu, konsep
          <strong>4C</strong>
          (Kepedulian, Pengendalian, Konsepsi, dan Penerimaan) menyoroti
          kesiapan Anda dalam menghadapi perjalanan karir.
        </p>
      </div>
    <?php endif; ?>

    <?php if (isset($scoring['Self Efficacy']) || isset($scoring['Self Efficacy SMP-SMA'])) : ?>
      <h3 style="padding-top: 20px">2. Self Efficacy</h3>
      <div>
        <table class="table">
          <tr>
            <th rowspan="2" style="width: 15%">Dimensi</th>
            <th colspan="6" style="width: 85%">Skor</th>
          </tr>
          <tr class="tr_table">
            <td>Jumlah Item</td>
            <td>Skor Maksimal</td>
            <td>Skor Diperoleh</td>
            <td>Persentase</td>
            <?php if (isset($scoring['Self Efficacy SMP-SMA'])): ?>
              <td colspan="2" style="width: 20%;">Interpretasi</td>
            <?php elseif (isset($scoring['Self Efficacy'])): ?>
              <td>Interpretasi</td>
              <td style="width: 25%;">Keterangan</td>
            <?php endif; ?>
          </tr>
          <?php if (isset($scoring['Self Efficacy']['data']['Level'])): ?>
            <tr>
              <td>Level</td>
              <td><?= count($scoring['Self Efficacy']['data']['Level']['point']) ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Level']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Level']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Level']['percentage'] ?>%</td>
              <td>
                <?php
                if ($scoring['Self Efficacy']['data']['Level']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy']['data']['Level']['value'] > 2 && $scoring['Self Efficacy']['data']['Level']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy']['data']['Level']['value'] > 3 && $scoring['Self Efficacy']['data']['Level']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
              <td>
                Mengacu pada sejauh mana seseorang yakin dapat menyelesaikan
                tugas-tugas dengan berbagai tingkat kesulitan.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy']['data']['Generality'])): ?>
            <tr>
              <td>Generality</td>
              <td><?= count($scoring['Self Efficacy']['data']['Generality']['point']) ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Generality']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Generality']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Generality']['percentage'] ?>%</td>
              <td>
                <?php
                if ($scoring['Self Efficacy']['data']['Generality']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy']['data']['Generality']['value'] > 2 && $scoring['Self Efficacy']['data']['Generality']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy']['data']['Generality']['value'] > 3 && $scoring['Self Efficacy']['data']['Generality']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
              <td>
                Menggambarkan sejauh mana keyakinan diri berlaku di berbagai
                situasi atau bidang kehidupan.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy']['data']['Persistence'])): ?>
            <tr>
              <td>Persistence</td>
              <td><?= count($scoring['Self Efficacy']['data']['Persistence']['point']) ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Persistence']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Persistence']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Persistence']['percentage'] ?>%</td>
              <td>
                <?php
                if ($scoring['Self Efficacy']['data']['Persistence']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy']['data']['Persistence']['value'] > 2 && $scoring['Self Efficacy']['data']['Persistence']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy']['data']['Persistence']['value'] > 3 && $scoring['Self Efficacy']['data']['Persistence']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
              <td>
                Mengacu pada ketekunan dan ketahanan seseorang dalam menghadapi
                rintangan atau kesulitan.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy']['data']['Strenght'])): ?>
            <tr>
              <td>Strength</td>
              <td><?= count($scoring['Self Efficacy']['data']['Strenght']['point']) ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Strenght']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Strenght']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy']['data']['Strenght']['percentage'] ?>%</td>
              <td>
                <?php
                if ($scoring['Self Efficacy']['data']['Strenght']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy']['data']['Strenght']['value'] > 2 && $scoring['Self Efficacy']['data']['Strenght']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy']['data']['Strenght']['value'] > 3 && $scoring['Self Efficacy']['data']['Strenght']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
              <td>
                Mengacu pada seberapa kuat keyakinan seseorang dalam menghadapi
                tugas atau tantangan.
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy'])) : ?>
            <tr>
              <td>Academic Self-Efficacy</td>
              <td><?= count($scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['point']) ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['percentage'] ?>%</td>
              <td colspan="2">
                <?php
                if ($scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['value'] > 2 && $scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['value'] > 3 && $scoring['Self Efficacy SMP-SMA']['data']['Academic Self-Efficacy']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy'])) : ?>
            <tr>
              <td>Carrer Self-Efficacy</td>
              <td><?= count($scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['point']) ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['percentage'] ?>%</td>
              <td colspan="2">
                <?php
                if ($scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['value'] > 2 && $scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['value'] > 3 && $scoring['Self Efficacy SMP-SMA']['data']['Carrer Self-Efficacy']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy'])) : ?>
            <tr>
              <td>Problem-Solving Efficacy</td>
              <td><?= count($scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['point']) ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['percentage'] ?>%</td>
              <td colspan="2">
                <?php
                if ($scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['value'] > 2 && $scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['value'] > 3 && $scoring['Self Efficacy SMP-SMA']['data']['Problem-Solving Efficacy']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence'])) : ?>
            <tr>
              <td>Initiative & Persistence</td>
              <td><?= count($scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['point']) ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['percentage'] ?>%</td>
              <td colspan="2">
                <?php
                if ($scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['value'] > 2 && $scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['value'] > 3 && $scoring['Self Efficacy SMP-SMA']['data']['Initiative & Persistence']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy'])) : ?>
            <tr>
              <td>Emotional Self-Efficacy</td>
              <td><?= count($scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['point']) ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['percentage'] ?>%</td>
              <td colspan="2">
                <?php
                if ($scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['value'] > 2 && $scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['value'] > 3 && $scoring['Self Efficacy SMP-SMA']['data']['Emotional Self-Efficacy']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
            </tr>
          <?php endif; ?>
          <?php if (isset($scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative'])) : ?>
            <tr>
              <td>Adaptability / Initiative</td>
              <td><?= count($scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['point']) ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['max_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['total_point'] ?></td>
              <td><?= $scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['percentage'] ?>%</td>
              <td colspan="2">
                <?php
                if ($scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['value'] <= 2) {
                  echo 'Rendah';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['value'] > 2 && $scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['value'] <= 3) {
                  echo 'Sedang';
                } elseif ($scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['value'] > 3 && $scoring['Self Efficacy SMP-SMA']['data']['Adaptability / Initiative']['value'] <= 5) {
                  echo 'Tinggi';
                }
                ?>
              </td>
            </tr>
          <?php endif; ?>
        </table>
        <p>
          <strong>Self-efficacy</strong> adalah keyakinan individu terhadap
          kemampuan mereka untuk mengatur dan melaksanakan tindakan yang
          diperlukan guna mencapai tujuan tertentu. Asesmen self-efficacy
          memberikan gambaran tentang tingkat keyakinan diri Anda dalam
          menghadapi tantangan, menyelesaikan tugas, dan mencapai hasil yang
          diharapkan.
        </p>
      </div>
    <?php endif; ?>

    <?php if (isset($scoring['Kesiapan Kerja']) || isset($scoring['Kompetensi'])) : ?>
      <h3>3. <?= isset($scoring['Kesiapan Kerja']) ? 'Kesiapan Kerja' : 'Kompetensi' ?></h3>
      <div>
        <table class="table">
          <tr>
            <th style="width: 30%; text-align: center">Skill</th>
            <th style="width: 60%; text-align: center">Skor</th>
          </tr>
          <?php if (isset($scoring['Kompetensi']['data'])) : ?>
            <?php foreach ($scoring['Kompetensi']['data'] as $keyKompetensi => $valueKompetensi) : ?>
              <tr>
                <?php
                if ($keyKompetensi == 'Decision Making') {
                  $color = 'green';
                } elseif ($keyKompetensi == 'Problem Solving') {
                  $color = 'blue';
                } elseif ($keyKompetensi == 'Self-Management') {
                  $color = 'purple';
                } elseif ($keyKompetensi == 'Initiative and Adaptability') {
                  $color = 'red';
                } elseif ($keyKompetensi == 'Exploration & Growth') {
                  $color = 'orange';
                } elseif ($keyKompetensi == 'Collaboration') {
                  $color = 'light-orange';
                } elseif ($keyKompetensi == 'Emotional Resilience') {
                  $color = 'light-blue';
                } elseif ($keyKompetensi == 'Communication') {
                  $color = 'yellow';
                }
                ?>
                <td class="kode"><?= $keyKompetensi ?></td>
                <td>
                  <table class="graf_bar">
                    <tr>
                      <td class="<?= $color ?>" style="width: <?= $valueKompetensi['percentage'] ?>%"><?= $valueKompetensi['percentage'] ?>%</td>
                      <td></td>
                      <td></td>
                    </tr>
                  </table>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          <?php if (isset($scoring['Kesiapan Kerja']['data'])) : ?>
            <?php foreach ($scoring['Kesiapan Kerja']['data'] as $keyKarir => $valueKarir) : ?>
              <tr>
                <?php
                if ($keyKarir == 'Self-management') {
                  $color = 'green';
                } elseif ($keyKarir == 'Team Work') {
                  $color = 'blue';
                } elseif ($keyKarir == 'Communication Skill') {
                  $color = 'purple';
                } elseif ($keyKarir == 'Problem Solving & Decision Making') {
                  $color = 'red';
                } elseif ($keyKarir == 'Organization & Planning') {
                  $color = 'orange';
                } elseif ($keyKarir == 'Initiative & Enterprise') {
                  $color = 'light-orange';
                }
                ?>
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
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>
        <?php if (isset($scoring['Kesiapan Kerja']['data'])) : ?>
          <p>
            Kesiapan kerja adalah kemampuan dan sikap individu yang mendukung
            mereka untuk berhasil memasuki dan menjalani dunia kerja. Konsep ini
            fokus pada soft skills diperlukan untuk beradaptasi dan berkontribusi
            secara efektif di lingkungan kerja. Karena kesiapan kerja tidak hanya
            berfokus pada keterampilan teknis saja. Soft skills adalah kemampuan
            non-teknis yang mendukung individu untuk berkomunikasi, bekerja sama,
            dan beradaptasi secara efektif di tempat kerja. Soft skills
            mencerminkan kemampuan seseorang untuk berkembang dalam lingkungan
            kerja yang dinamis.
          </p>
        <?php endif; ?>
        <?php if (isset($scoring['Kompetensi']['data'])) : ?>
          <p>
            Kompetensi adalah seperangkat pengetahuan, keterampilan, dan sikap
            yang diperlukan untuk melakukan tugas atau pekerjaan dengan
            efektif. Kompetensi mencakup berbagai aspek, termasuk kemampuan
            teknis, keterampilan interpersonal, dan sikap profesional. Dalam konteks
            dunia kerja, kompetensi mencerminkan kemampuan individu untuk
            menyelesaikan tantangan, berkomunikasi dengan orang lain, dan
            beradaptasi dalam lingkungan kerja yang dinamis.
          </p>
        <?php endif; ?>
        <p style="margin: 10px">
          Mengapa soft skills penting untuk kesiapan kerja ?
        </p>
        <ol style="margin: 0">
          <li>
            Soft skills membantu individu untuk bekerja lebih baik
            dengan orang lain, beradaptasi dalam lingkungan kerja yang
            beragam, dan memberikan kontribusi yang positif di tempat kerja.
            </p>
          </li>
          <li>
            Dengan memiliki soft skills yang kuat, individu tidak
            hanya lebih mudah mendapatkan pekerjaan, tetapi juga
            mempertahankannya dan berkembang dalam karir.
            </p>
          </li>
        </ol>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>