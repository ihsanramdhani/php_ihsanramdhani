<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SOAL 1</title>
</head>

<body>
  <?php
  if (!isset($_POST['submit_second'])) {
    echo '<form method="post">';
    if (!isset($_POST['submit_first'])) {
      // tampilan no 1
      echo '<label for="rows">Inputkan Jumlah Baris: </label>';
      echo '<input type="number" id="rows" name="rows" min="1"><br>';
      echo '<label for="cols">Inputkan Jumlah Kolom: </label>';
      echo '<input type="number" id="cols" name="cols" min="1"><br>';
      echo '<input type="submit" value="Submit" name="submit_first">';
    } else {
      // tampilan no 2
      $rows = isset($_POST['rows']) ? (int) $_POST['rows'] : 0;
      $cols = isset($_POST['cols']) ? (int) $_POST['cols'] : 0;
      echo '<form method="post">';
      for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
          $placeholder = $i+1 . "." . $j+1 . " ";
          echo "{$placeholder}<input type=\"text\" name=\"cell[" . $i . '][' . $j . ']">' . " ";
        }
        echo '<br>';
      }
      echo '<input type="submit" value="Submit" name="submit_second">';
      echo '</form>';
    }
  } else {
    // tampilan no 3
    $grid = $_POST['cell'];
    $row = 1;
    $column = 1;
    echo '<table border="0">';
    foreach ($grid as $rows) {
      $row = 1;
      foreach ($rows as $value) {
        $result = $column . "." . $row . " : " . $value;
        echo '<tr>';
        echo '<td>' . htmlspecialchars($result) . '</td>';
        echo '</tr>';
        $row++;
      }
      $column++;
    }

    echo '</table>';
  }
  ?>
</body>
</html>