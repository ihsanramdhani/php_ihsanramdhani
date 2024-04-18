<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SOAL 2</title>
</head>

<body>
  <form method="post">
    <button type="submit" name="show_all">Tampilkan Semua</button>
    <button type="submit" name="show_quantity">Jumlah Person per Hobi</button>
    <input type="text" name="hobby" placeholder="Masukkan hobi">
    <button type="submit" name="filter_hobby">Filter Hobi</button>
  </form>

  <?php
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=php_terakorp', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Display all data
    function displayAllData($pdo)
    {
      echo '<h1>Menampilkan Semua Data</h1>';
      echo '<table border="1">';
      echo '<tr><th>Nama</th><th>Hobi</th></tr>';

      $stmt = $pdo->query("SELECT p.nama, h.hobi
      FROM person p
      JOIN hobi h ON h.person_id = p.id");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['nama'] . '</td>';
        echo '<td>' . $row['hobi'] . '</td>';
        echo '</tr>';
      }
      echo '</table>';
    }

    // display quantity based on hobby
    function displayQuantityByHobby($pdo)
    {
      echo '<h1>Jumlah Person per Hobi</h1>';
      echo '<table border="1">';
      echo '<tr><th>Hobi</th><th>Jumlah Person</th></tr>';

      $stmt = $pdo->query("SELECT hobi, COUNT(*) AS jumlahPerson
      FROM hobi 
      GROUP BY hobi
      ORDER BY jumlahPerson DESC");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['hobi'] . '</td>';
        echo '<td>' . $row['jumlahPerson'] . '</td>';
        echo '</tr>';
      }

      echo '</table>';
    }

    // filter by hobby
    function filterWithHobby($pdo, $hobby)
    {
      echo '<h1>Filter with Hobby: ' . $hobby . '</h1>';
      echo '<table border="1">';
      echo '<tr><th>Nama</th><th>Hobi</th></tr>';

      $stmt = $pdo->prepare("SELECT *
      FROM person p
      JOIN hobi h ON h.person_id = p.id
      WHERE hobi = ?");
      $stmt->execute([$hobby]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['nama'] . '</td>';
        echo '<td>' . $row['hobi'] . '</td>';
        echo '</tr>';
      }

      echo '</table>';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['show_all'])) {
        displayAllData($pdo);
      } elseif (isset($_POST['show_quantity'])) {
        displayQuantityByHobby($pdo);
      } elseif (isset($_POST['filter_hobby'])) {
        $hobby = $_POST['hobby'];
        filterWithHobby($pdo, $hobby);
      }
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>
</body>

</html>