<html>
<head>
    <title>Modify Reservation</title>
    <link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Modify Reservation</h1>
    </header>
    <div class="content-add">
    <form method="POST" action="index.php?action=modifyReservation">
        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservationId']) ?>">
        Reservation Time: <input type="datetime-local" name="reservation_time" value="<?= htmlspecialchars($reservation['reservationTime']) ?>" required><br><br>
        Number of Guests: <input type="number" name="number_of_guests" value="<?= htmlspecialchars($reservation['numberOfGuests']) ?>" required><br><br>
        Special Requests: <textarea name="special_requests"><?= htmlspecialchars($reservation['specialRequests']) ?></textarea><br><br>
        <button class="button-add" type="submit">Save Changes</button>
    </form>
        <a href="index.php?action=viewReservations">Cancel</a>
    </div>
    
    <footer>
        <p>&copy; 2024 Restaurant Portal IP LLC.<br />
        All rights reserved</p>
    </footer>
</body>
</html>