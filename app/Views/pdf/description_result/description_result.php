<!DOCTYPE html>
<html lang="en">
  <head>
    <style>
      body {
        font-family: "Arial", sans-serif;
        line-height: 1.6;
        margin: 0;
        height: 100vh;
        background-image: url("assets/media/bg/cover.png");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        overflow: hidden;
      }
    </style>
  </head>

  <body>
    <div style="padding: 3rem">
      <div
        style="
          display: flex;
          justify-content: flex-start;
          align-items: center;
          padding: 80px 0px 20px 180px;
        "
      >
        <img src="assets/media/logos/logo.png" alt="" style="max-height: 5rem" />
      </div>

      <div style="padding-left: 7.5rem">
        <h1>LAPORAN HASIL TES TIKAR</h1>
      </div>

      <div
        style="
          width: 50%;
          height: 10px;
          background-color: #577085;
          margin: 40px 50px 30px 50px;
        "
      ></div>

      <div style="text-align: left; padding-left: 3rem">
        <h3 style="margin: 0">Laporan Untuk</h3>
        <h2 style="margin: 0"><?= $fullname ?></h2>
        <h3 style="margin: 0"><?= date("d F Y", strtotime($start)) ?></h3>
      </div>
    </div>
  </body>
</html>
