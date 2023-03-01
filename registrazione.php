<html>
    <body>
        <head>
            <link rel="stylesheet" href="stile.css">
        </head>
<form method="POST" action="registrazione.php">
  <label>Username:</label>
  <input type="text" name="username"><br>
  <label>Email:</label>
  <input type="email" name="email"><br>
  <label>Password:</label>
  <input type="password" name="password"><br>
  <input type="submit" value="Registrati">
</form>

<p>Se sei già registrato effettua il  <a href="login.php">Login</a></p>
</body>
</html>

<?php

// Connessione al database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Ottieni i dati dal form
$username = $_POST["username"];
$email = $_POST['email'];
$password = $_POST["password"];

// Verifica che i campi del form siano stati compilati correttamente
if (empty($username) || empty($email) || empty($password)) {
    die("Si prega di compilare tutti i campi.");
}

// Verifica l'unicità dell'username e dell'email
$sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    die("L'username o l'email esistono già nel database.");
}

// Crea la query di inserimento
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

// Esegui la query di inserimento
if (mysqli_query($conn, $sql)) {
    echo "Utente registrato con successo.";
} else {
    echo "Errore durante la registrazione dell'utente: " . mysqli_error($conn);
}

// Chiudi la connessione al database
mysqli_close($conn);
}
?>
