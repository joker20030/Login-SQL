<?php
// connessione al database
try {
    $db = new PDO("mysql:host=localhost;dbname=login", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connessione al database fallita: " . $e->getMessage();
}

// verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recupera i dati inviati dall'utente
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // interrogazione del database
    try {
        $query = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Errore nella query: " . $e->getMessage();
    }
    
    // verifica delle credenziali fornite dall'utente
    if (count($rows) > 0) {
        // le credenziali sono corrette, inizializza la sessione
        session_start();
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        // reindirizza alla pagina protetta
        header("Location: riservata.php");
        exit;
    } else {
        // le credenziali sono errate, visualizza un messaggio di errore
        echo "Username o password non corretti.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="Login">
    </form>
    <a href="registrazione.php">Registrati</a>
</body>
</html>