<?php
class RestaurantDatabase {
    private $host = "localhost";
    private $port = "3306";
    private $database = "restaurant_reservations";
    private $user = "root";
    private $password = "mydatabasepassword!";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        echo "Successfully connected to the database<br>";
    }

    public function addCustomer($customerName, $contactInfo) {
        $stmt = $this->connection->prepare(
            "INSERT INTO Customers (customerName, contactInfo) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $customerName, $contactInfo);
        $stmt->execute();
        $stmt->close();
        echo "Customer added successfully<br>";
    }

    public function getCustomerPreferences($customerId) {
        $stmt = $this->connection->prepare(
            "SELECT favoriteTable, dietaryRestrictions FROM DiningPreferences WHERE customerId = ?"
        );
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $preferences = $result->fetch_assoc();
        $stmt->close();
        return $preferences;
    }

    public function addReservation($customerId, $reservationTime, $numberOfGuests, $specialRequests) {
        $stmt = $this->connection->prepare("SELECT customerId FROM Customers WHERE customerId = ?");
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $customerExists = $result->num_rows > 0;
        $stmt->close();
    
        if (!$customerExists) {
            $stmt = $this->connection->prepare(
                "INSERT INTO Customers (customerName, contactInfo) VALUES (?, ?)"
            );
            $newCustomerName = "AutoCustomer_" . $customerId;
            $newContactInfo = "Unknown"; 
            $stmt->bind_param("ss", $newCustomerName, $newContactInfo);
            $stmt->execute();
    
            $customerId = $this->connection->insert_id;
            $stmt->close();
    
            echo "Customer with ID $customerId has been auto-created.<br>";
        }
    
        $stmt = $this->connection->prepare(
            "INSERT INTO Reservations (customerId, reservationTime, numberOfGuests, specialRequests) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isis", $customerId, $reservationTime, $numberOfGuests, $specialRequests);
        if ($stmt->execute()) {
            echo "Reservation added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    

    public function getAllReservations() {
        $query = "SELECT * FROM Reservations";
        $result = $this->connection->query($query);
    
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); 
        } else {
            return []; 
        }
    }


    public function testDatabaseConnection() {
        $query = "SELECT * FROM Reservations";
        $result = $this->connection->query($query);
    
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); 
        } else {
            die("Database query failed: " . $this->connection->error);
        }
    }

    public function deleteReservation($reservationId) {
        $stmt = $this->connection->prepare("DELETE FROM Reservations WHERE reservationId = ?");
        $stmt->bind_param("i", $reservationId);
        $stmt->execute();
        $stmt->close();
    }
    
    public function getReservationById($reservationId) {
        $stmt = $this->connection->prepare("SELECT * FROM Reservations WHERE reservationId = ?");
        $stmt->bind_param("i", $reservationId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation = $result->fetch_assoc();
        $stmt->close();
        return $reservation;
    }
    
    public function updateReservation($reservationId, $reservationTime, $numberOfGuests, $specialRequests) {
        $stmt = $this->connection->prepare(
            "UPDATE Reservations SET reservationTime = ?, numberOfGuests = ?, specialRequests = ? WHERE reservationId = ?"
        );
        $stmt->bind_param("sisi", $reservationTime, $numberOfGuests, $specialRequests, $reservationId);
        $stmt->execute();
        $stmt->close();
    }
    

}


?>