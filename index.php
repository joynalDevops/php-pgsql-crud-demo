<?php
$dsn = "pgsql:host=localhost;dbname=cruddb;port=5432";
$user = "cruduser";
$pass = "crudpass";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("❌ DB Connection Failed: " . $e->getMessage());
}

// Create
if (isset($_POST['name']) && isset($_POST['email'])) {
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email) VALUES (:name, :email)");
    $stmt->execute(['name' => $_POST['name'], 'email' => $_POST['email']]);
    header("Location: index.php");
    exit;
}

// Read
$contacts = $pdo->query("SELECT * FROM contacts ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
    $stmt->execute(['id' => $_GET['delete']]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP + PostgreSQL CRUD</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Contacts (PHP + PostgreSQL CRUD)</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Add Contact</button>
    </form>

    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>
        <?php foreach ($contacts as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['id']) ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><a href="?delete=<?= $c['id'] ?>" onclick="return confirm('Delete this contact?')">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
