<form method="post" action="">
    <button type="submit" name="create_table">Utwórz tabelę</button>
    <button type="submit" name="load_data">Załaduj dane</button>
    <button type="submit" name="show_data">Wyświetl dane</button>
</form>

<?php

function createTable() {

    $conn = new mysqli('localhost', 'root', '', '3pir_2_baza_pracownikow');

    if ($conn->connect_error) {
        die("BladAkaWielbald: " . $conn->connect_error);
    }

    $sql = "CREATE TABLE pracownicy (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        imie VARCHAR(30) NOT NULL,
        nazwisko VARCHAR(30) NOT NULL,
        stanowisko VARCHAR(50),
        dzial VARCHAR(50),
        miejsce_pracy VARCHAR(50)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Udalo sie utworzyc tabele";
    } else {
        echo "Nie udalo sie utworzyc tabeli: " . $conn->error;
    }

    $conn->close();
}
function loadData() {

    $conn = new mysqli('localhost', 'root', '', '3pir_2_baza_pracownikow');

    if ($conn->connect_error) {
        die("Wielbład: " . $conn->connect_error);
    }

    $filename = "pracownicy.txt";
    $file = fopen($filename, "r");

    while (($data = fgetcsv($file, 1000, "|")) !== FALSE) {
        $imie = $data[1];
        $nazwisko = $data[2];
        $stanowisko = $data[3];
        $dzial = $data[4];
        $miejsce_pracy =$data[5];

        $sql = "INSERT INTO pracownicy (id,imie, nazwisko, stanowisko, dzial, miejsce_pracy) VALUES ('','$imie', '$nazwisko', '$stanowisko', '$dzial', '$miejsce_pracy')";

        if ($conn->query($sql) === TRUE) {
            echo "Dane załadowane takk ooo";
        } else {
            echo "Nie udało się załadować danych: " . $conn->error;
        }
    }

    fclose($file);
    $conn->close();
}
$inputFile="pracownicy.xlsx";
$outputFile="pracownicy.txt";

//MAIN
if(isset($_POST['create_table'])) {
    createTable();
}

if(isset($_POST['load_data'])) {
    loadData();
}

if(isset($_POST['show_data'])) {
    Show();
}
function Show()
{
$conn = new mysqli('localhost', 'root', '', '3pir_2_baza_pracownikow');
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}
$sql = "SELECT * FROM pracownicy";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Stanowisko</th><th>Dzial</th><th>Miejsce Pracy</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["imie"]."</td><td>".$row["nazwisko"]."</td><td>".$row["stanowisko"]."</td><td>".$row["dzial"]."</td><td>".$row["miejsce_pracy"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Brak danych do wyświetlenia";
}
$conn->close();
}
?>

