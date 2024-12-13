<html>
<head>
    <title>Add Reservation</title>
    <link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Add Reservation</h1>
    </header>

    <div class="content-add">
        <form method="POST" action="/last-project/index.php?action=addReservation">
            Customer ID: <input type="text" name="customer_id"><br><br>
            Reservation Time: <input type="datetime-local" name="reservation_time"><br><br>
            Number of Guests: <input type="number" name="number_of_guests"><br><br>
            Special Requests: <textarea name="special_requests"></textarea><br><br>
            <button class="button-add" type="submit">Submit</button>
        </form>
        <a href="index.php?action=home">Back to Home</a>
    </div>
    <footer>
        <p>&copy; 2024 Restaurant Portal IP LLC.<br />
        All rights reserved</p>
    </footer>
</body>
</html>
