<html>
<head>
    <title>View Reservations</title>
    <link href="styles.css" type="text/css" rel="stylesheet">

</head>
<body>
    <header>
        <h1>All Reservations</h1>
    </header>
    
    <div class="content-add">
    <table border="1">
        <tr>
            <th>Reservation ID</th>
            <th>Customer ID</th>
            <th>Reservation Time</th>
            <th>Number of Guests</th>
            <th>Special Requests</th>
            <th>Actions</th> 
        </tr>
        <?php if (!empty($reservations)): ?>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['reservationId']) ?></td>
                    <td><?= htmlspecialchars($reservation['customerId']) ?></td>
                    <td><?= htmlspecialchars($reservation['reservationTime']) ?></td>
                    <td><?= htmlspecialchars($reservation['numberOfGuests']) ?></td>
                    <td><?= htmlspecialchars($reservation['specialRequests']) ?></td>
                    <td>
                        <a href="index.php?action=modifyReservation&id=<?= htmlspecialchars($reservation['reservationId']) ?>">Modify</a> |
                        <a href="index.php?action=cancelReservation&id=<?= htmlspecialchars($reservation['reservationId']) ?>" 
                           onclick="return confirm('Are you sure you want to cancel this reservation?');">Cancel</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No reservations found.</td>
            </tr>
        <?php endif; ?>
    </table>
    <a href="index.php?action=home">Back to Home</a>
    </div>
    <footer>
        <p>&copy; 2024 Restaurant Portal IP LLC.<br />
        All rights reserved</p>
    </footer>
</body>
</html>
