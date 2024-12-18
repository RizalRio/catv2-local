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
        padding: 20px;
        margin: 20px auto;
        max-width: 1200px;
        background: white;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
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
        margin-top: 30px;
      }

      p {
        text-align: justify;
      }

      table th,
      table td {
        padding: 8px;
        text-align: left;
      }
    </style>
  </head>

  <body>
    <header><h1 style="margin: 0">Pendahuluan</h1></header>
    <div class="section">
      <h2>1. Biodata Diri</h2>
      <div
        style="
          margin-bottom: 20px;
          padding: 0.5rem 0 0.5rem 0.75rem;
          text-align: left;
          border: 1px solid #ddd;
          background-color: #dbe8e6;
          border-radius: 8px;
        "
      >
      <table style="border-collapse: collapse; width: 100%">
          <tr>
            <th style="width: 240px">Nama Lengkap</th>
            <td style="width: 10px">:</td>
            <td><?= $fullname ?></td>
          </tr>
          <tr>
            <th>Usia</th>
            <td>:</td>
            <td><?= $age ?> Tahun</td>
          </tr>
          <tr>
            <th>Jenis Kelamin</th>
            <td>:</td>
            <td>
              <?php  
                if($gender == 'L') {
                  echo "Laki - Laki";
                } elseif($gender == 'P') {
                  echo "Perempuan";
                } else {
                  echo "Rahasia";
                }
              ?>
            </td>
          </tr>
          <tr>
            <th>Alamat Domisili</th>
            <td>:</td>
            <td><?= $address ?></td>
          </tr>
          <tr>
            <th>Tingkat Pendidikan Terakhir</th>
            <td>:</td>
            <td><?= $education ?></td>
          </tr>
          <tr>
            <th>Pengalaman Kerja</th>
            <td>:</td>
            <td><?= $duration ?> Tahun</td>
          </tr>
          <tr>
            <th>Pekerjaan Terakhir</th>
            <td>:</td>
            <td><?= $experience ?></td>
          </tr>
          <tr>
            <th>Tanggal Tes</th>
            <td>:</td>
            <td><?= date("d F Y", strtotime($start)) ?></td>
          </tr>
          <tr>
            <th>Tujuan Tes</th>
            <td>:</td>
            <td><?= $purpose ?></td>
          </tr>
        </table>
      </div>
    </div>

    <div class="section">
      <h2>2. Penjelasan Singkat Cara Menggunakan Hasil Tes TIKAR</h2>

      <p>
        Selamat datang di laporan hasil asesmen TIKAR (Titian Karir). Laporan
        ini bertujuan untuk memberikan wawasan menyeluruh mengenai potensi
        karir, tingkat kesiapan untuk menghadapi dunia kerja, serta keyakinan
        diri (self-efficacy) Anda dalam mencapai tujuan karir. Melalui asesmen
        ini, kami berharap dapat membantu Anda memahami diri sendiri lebih baik
        dan mengambil langkah strategis menuju karir yang sesuai dengan potensi
        dan minat Anda.
      </p>
      <div style="margin-top: 1.5rem; text-align: justify; line-height: 1.8">
        <p style="margin: 0">
          TIKAR adalah alat asesmen yang dirancang secara komprehensif untuk:
        </p>
        <ol style="padding-left: 1.5rem; margin: 0 0 1.5rem 0">
          <li>
            <strong>Mengidentifikasi Minat Karir:</strong> Mengungkap preferensi
            Anda terhadap berbagai jenis pekerjaan berdasarkan teori minat karir
            yang relevan.
          </li>
          <li>
            <strong>Mengungkap Kesiapan Kerja:</strong> Menilai sejauh mana Anda
            telah mempersiapkan diri untuk menghadapi dunia kerja melalui
            evaluasi aspek-aspek penting seperti diantaranya kemampuan adaptasi,
            pengelolaan waktu, dan komunikasi.
          </li>
          <li>
            <strong>Menilai Self-Efficacy:</strong> Mengevaluasi tingkat
            keyakinan Anda dalam menghadapi tantangan serta kemampuan Anda untuk
            menyelesaikan tugas-tugas yang berhubungan dengan pekerjaan.
          </li>
        </ol>
        <p style="margin: 0">
          Hasil dari asesmen ini disajikan dalam beberapa bagian utama untuk
          mempermudah interpretasi dan memberikan arahan yang jelas:
        </p>
        <ol style="padding-left: 1.5rem; margin: 0">
          <li><strong>Ringkasan Profil Karir</strong></li>
          <p style="margin: 0">
            Bagian ini memberikan gambaran umum mengenai hasil asesmen Anda
            melalui visualisasi data seperti grafik radar atau batang. Anda
            dapat melihat posisi Anda secara keseluruhan dalam dimensi minat
            karir, kesiapan kerja, dan self-efficacy.
          </p>
          <li><strong>Hasil Per Dimensi</strong></li>
          <p style="margin: 0">
            Penjabaran mendalam mengenai hasil pada masing-masing dimensi
            asesmen:
          </p>
          <ul style="padding-left: 1.5rem">
            <li>
              <strong>Minat Karir:</strong> Menjelaskan preferensi karir Anda,
              dimensi-dimensi yang mendominasi, dan area pekerjaan yang sesuai.
            </li>
            <li>
              <strong>Kesiapan Kerja:</strong> Memberikan penilaian tentang
              kesiapan Anda memasuki dunia kerja, termasuk kekuatan dan aspek
              yang perlu dikembangkan.
            </li>
            <li>
              <strong>Self-Efficacy:</strong> Menilai keyakinan Anda dalam
              menghadapi tugas dan tantangan di dunia kerja.
            </li>
          </ul>
          <li><strong>Rekomendasi dan Rencana Tindak Lanjut</strong></li>
          <p style="margin: 0">
            Berdasarkan hasil asesmen, bagian ini menawarkan saran yang dapat
            diterapkan, seperti pelatihan yang relevan, bidang pekerjaan yang
            sesuai, atau langkah pengembangan keterampilan. Rekomendasi ini
            dirancang untuk membantu mengoptimalkan potensi dan memperluas
            peluang karir Anda. <br /><br />
            Kami berharap laporan ini tidak hanya memberikan informasi yang
            berguna tetapi juga menjadi panduan praktis bagi Anda dalam
            merencanakan dan membangun karir. Apabila Anda memerlukan informasi
            lebih lanjut atau ingin berkonsultasi terkait hasil asesmen ini,
            jangan ragu untuk menghubungi kami. Di …..email dan no chat
          </p>
        </ol>
      </div>
      <p>
        <br />Selamat membaca dan semoga sukses dalam perjalanan karir Anda!
      </p>
    </div>
  </body>
</html>

