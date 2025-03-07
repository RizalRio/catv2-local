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
      padding: 10px 30px 10px 30px;
      margin: 20px auto;
      max-width: 1200px;
      background: white;
      border: 1px solid #ddd;
      border-radius: 8px;
    }

    .career-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }

    .career-column {
      background: #f4f4f4;
      padding: 15px;
      border-radius: 5px;
    }

    h3 {
      color: #384955;
      margin-top: 30px;
    }

    p,
    ul,
    ol {
      text-align: justify;
    }

    br {
      content: "";
      margin: 1em;
      display: block;
      font-size: 10%;
    }
  </style>
</head>

<body>
  <header>
    <h1 style="margin: 0">Hasil Tes</h1>
  </header>
  <div class="section" style="margin-bottom: 60px; page-break-after: always;">
    <h3 style="margin: 0">
      4. Rekomendasi Karir
      <hr />
    </h3>
    <p>Setelah mengetahui kombinasi tiga kode RIASEC Anda, penting untuk memanfaatkan rekomendasi karir sebagai panduan dalam memilih pekerjaan dan karir yang mendekati dengan kecenderungan kepribadian, berikut ini bebebrapa rekomendasi potensi karir yang sesuai dengna kode utama:</p>
    <?php

    use PhpOffice\PhpSpreadsheet\Chart\Title;

    foreach ($scoring['Minat Karir']['carrer_possibility'] as $value) : ?>
      <ul>
        <li><?= $value['title'] ?> - <?= $value['bright_outlook'] ?></li>
        <p style="margin: 0;"><?= $value['description'] ?></p>
      </ul>
    <?php endforeach; ?>
    <p>Berikut ini adalah bebebrapa langkah praktis untuk membantu penerapan dari hasil asesmen TIKAR ini, diantaranya berikut ini:</p>
    <ul>
      <li>Eksplorasi Peluang Karir yang Sesuai</li>
      <li>Gunakan daftar rekomendasi karir untuk mengeksplorasi bidang pekerjaan yang sejalan dengan minat dan kepribadian Anda.</li>
      <li>Lakukan riset lebih lanjut mengenai profesi yang disebutkan, seperti deskripsi pekerjaan, persyaratan pendidikan, dan keterampilan yang dibutuhkan.</li>
      <li>Manfaatkan platform seperti ONET, LinkedIn, atau situs lowongan kerja lokal untuk memahami lebih dalam tentang peluang di bidang tersebut.</li>
    </ul>

    <h3>
      5. Rekomendasi Pengembangan Diri
      <hr />
    </h3>
    <p>Pengembangan diri merupakan langkah penting dalam mencapai potensi terbaik seseorang, baik dalam karir maupun kehidupan pribadi. Berdasarkan teori kepribadian Holland, pengembangan diri dapat disesuaikan dengan kombinasi kode yang mencerminkan minat, kepribadian, dan preferensi individu terhadap berbagai aktivitas. Setiap kode dalam RIASEC memiliki karakteristik unik yang menggambarkan pendekatan seseorang terhadap pekerjaan, interaksi sosial, dan tantangan profesional. Oleh karena itu, rekomendasi pengembangan diri ini dirancang untuk membantu memahami ketrampilan-ketrampilan tertentu yang perlu dikembangkan. Berikut ini beberapa saran untuk pengembangan diri dengan mengacu pada kode utama:</p>
    <ol>
      <?php foreach ($scoring['Minat Karir']['development'] as $recommendations) : ?>
        <li><?= $recommendations['development'] ?></li>
      <?php endforeach; ?>
    </ol>
    <p>Berikut pengembangan diri untuk mepersiapkan diri anda dalam bekerja : </p>
    <ol>
      <?php foreach ($scoring['Kesiapan Kerja']['recommendation'] as $key => $value) : ?>
        <li><?= $value ?></li>
      <?php endforeach; ?>
    </ol>
  </div>

  <header>
    <h1 style="margin: 0">Penutup</h1>
  </header>
  <div class="section">
    <p style="margin: 0;">
      Hasil asesmen TIKAR memberikan wawasan yang penting tentang minat karir,
      kesiapan kerja, dan self-efficacy Anda. Informasi ini bertujuan untuk
      membantu Anda memahami potensi diri, mengidentifikasi area pengembangan,
      dan merancang langkah strategis dalam perjalanan karir Anda.
      <br /><br>
      Pengembangan karir tidak hanya tentang menemukan pekerjaan yang sesuai,
      tetapi juga tentang membangun keterampilan, memperkuat keyakinan diri,
      dan beradaptasi dengan dunia kerja yang dinamis. Untuk mendukung
      perjalanan ini, Anda dapat memanfaatkan sumber daya berikut:
    </p>
    <ol style="margin: 0">
      <li>
        <strong>O*NET Online</strong>: Basis data karir yang komprehensif
        untuk mengeksplorasi pekerjaan dan keterampilan yang relevan.
        Kunjungi:
        <a
          href="https://www.onetonline.org"
          target="_blank"
          style="color: blue; text-decoration: underline">https://www.onetonline.org</a>
      </li>
      <li>
        <strong>LinkedIn Learning</strong>: Platform pembelajaran daring untuk
        meningkatkan keterampilan teknis dan soft skills Anda. Kunjungi:
        <a
          href="https://www.linkedin.com/learning/"
          target="_blank"
          style="color: blue; text-decoration: underline">https://www.linkedin.com/learning/</a>
      </li>
      <li>
        <strong>Coursera</strong>: Tempat belajar kursus online dari
        universitas dan institusi ternama. Kunjungi:
        <a
          href="https://www.coursera.org"
          target="_blank"
          style="color: blue; text-decoration: underline">https://www.coursera.org</a>
      </li>
      <li>
        <strong>Kementerian Tenaga Kerja RI</strong>: Sumber daya untuk
        informasi pelatihan kerja dan peluang karir di Indonesia. Kunjungi:
        <a
          href="https://kemnaker.go.id"
          target="_blank"
          style="color: blue; text-decoration: underline">https://kemnaker.go.id</a>
      </li>
    </ol>
    <p style="margin-bottom: 5px;">
      Gunakan hasil asesmen ini sebagai panduan untuk terus belajar,
      mengeksplorasi peluang baru, dan memperkuat kemampuan Anda. Ingatlah
      bahwa setiap langkah kecil yang Anda ambil hari ini adalah bagian dari
      perjalanan besar menuju kesuksesan karir di masa depan. Semoga sukses
      dalam perjalanan karir Anda, dan jangan ragu untuk terus mengembangkan
      potensi terbaik Anda! <br /><br />
      Terima kasih telah mengikuti tes TIKAR. Kami berharap laporan ini
      membantu Anda dalam merancang langkah strategis menuju karir yang
      memuaskan dan bermakna. Jika Anda memiliki pertanyaan atau memerlukan
      bantuan lebih lanjut, jangan ragu untuk menghubungi kami.

      <br /><br />Hormat kami, <br /><br />
      Tim Pengembangan Karir
    </p>
  </div>
  <div class="section" style="text-align: center">
    <p style="text-align: center; margin: 0"><strong>Catatan Penting:</strong></p>
    <p style="margin-top: 5px;">Rekomendasi ini adalah langkah awal untuk membantu Anda menemukan jalur karir yang sesuai. Setiap individu memiliki perjalanan karir yang unik, dan fleksibilitas serta keterbukaan untuk belajar akan membantu Anda mencapai tujuan karir yang diinginkan.</p>
  </div>
</body>

</html>