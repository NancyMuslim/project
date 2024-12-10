<?php

include 'header.php';
require_once 'config.php';

try {
    $query = "SELECT * FROM paitents";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $paitents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

?>

<table >
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($paitents)): ?>
            <?php foreach ($paitents as $paitent): ?>
                <tr>
                    <td><?php echo htmlspecialchars($paitent['id']); ?></td>
                    <td><?php echo htmlspecialchars($paitent['username']); ?></td>
                    <td><?php echo htmlspecialchars($paitent['email']); ?></td>
                    <td><?php echo htmlspecialchars($paitent['date']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No records found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
