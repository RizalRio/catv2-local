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
        border: 1px solid #ddd;
        border-radius: 8px;
      }

      h3 {
        color: #384955;
        margin-top: 30px;
      }

      p {
        text-align: justify;
      }
    </style>
  </head>

  <body>
    <header><h1 style="margin: 0">Hasil Tes</h1></header>
    <div class="section" style="margin-bottom: 60px">
      <h3 style="margin: 0">
        4. Rekomendasi Karir
        <hr />
      </h3>
      <p>Berdasarkan hasil tes, berikut adalah beberapa karir yang sesuai:</p>
      <ul>
        <?php foreach($scoring['Minat Karir']['carrer_possibility'] as $value) : ?>
          <li><?= $value ?></li>
        <?php endforeach; ?>
      </ul>

      <h3>
        5. Rekomendasi Pengembangan Diri
        <hr />
      </h3>
      <ol>
        <li>
          Ikuti pelatihan teknis dan kreatif seperti desain CAD atau pelatihan
          perangkat keras.
        </li>
        <li>
          Tingkatkan keterampilan komunikasi untuk menyampaikan ide-ide teknis.
        </li>
        <li>
          Bergabung dalam komunitas profesional untuk memperluas jaringan.
        </li>
        <li>
          Coba magang atau proyek sukarela untuk memperkuat pengalaman Anda.
        </li>
        <li>Pertimbangkan pendidikan lanjutan di bidang teknik atau desain.</li>
      </ol>
    </div>

    <header><h1 style="margin: 0">Penutup</h1></header>
    <div class="section">
      <p>
        Hasil asesmen TIKAR memberikan wawasan yang penting tentang minat karir,
        kesiapan kerja, dan self-efficacy Anda. Informasi ini bertujuan untuk
        membantu Anda memahami potensi diri, mengidentifikasi area pengembangan,
        dan merancang langkah strategis dalam perjalanan karir Anda.
        <br /><br />
        Pengembangan karir tidak hanya tentang menemukan pekerjaan yang sesuai,
        tetapi juga tentang membangun keterampilan, memperkuat keyakinan diri,
        dan beradaptasi dengan dunia kerja yang dinamis. Untuk mendukung
        perjalanan ini, Anda dapat memanfaatkan sumber daya berikut:
      </p>
      <ol>
        <li>
          <strong>O*NET Online</strong>: Basis data karir yang komprehensif
          untuk mengeksplorasi pekerjaan dan keterampilan yang relevan.
          Kunjungi:
          <a
            href="https://www.onetonline.org"
            target="_blank"
            style="color: blue; text-decoration: underline"
            >https://www.onetonline.org</a
          >
        </li>
        <li>
          <strong>LinkedIn Learning</strong>: Platform pembelajaran daring untuk
          meningkatkan keterampilan teknis dan soft skills Anda. Kunjungi:
          <a
            href="https://www.linkedin.com/learning/"
            target="_blank"
            style="color: blue; text-decoration: underline"
            >https://www.linkedin.com/learning/</a
          >
        </li>
        <li>
          <strong>Coursera</strong>: Tempat belajar kursus online dari
          universitas dan institusi ternama. Kunjungi:
          <a
            href="https://www.coursera.org"
            target="_blank"
            style="color: blue; text-decoration: underline"
            >https://www.coursera.org</a
          >
        </li>
        <li>
          <strong>Kementerian Tenaga Kerja RI</strong>: Sumber daya untuk
          informasi pelatihan kerja dan peluang karir di Indonesia. Kunjungi:
          <a
            href="https://kemnaker.go.id"
            target="_blank"
            style="color: blue; text-decoration: underline"
            >https://kemnaker.go.id</a
          >
        </li>
      </ol>
      <p>
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
  </body>
</html>
