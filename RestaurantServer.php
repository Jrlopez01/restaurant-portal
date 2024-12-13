<?php
require_once 'restaurantDatabase.php';

class RestaurantPortal {
    private $db;

    public function __construct() {
        $this->db = new RestaurantDatabase();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';
    
        switch ($action) {
            case 'addReservation':
                $this->addReservation();
                break;
            case 'viewReservations':
                $this->viewReservations();
                break;
            case 'modifyReservation':
                $this->modifyReservation();
                break;
            case 'cancelReservation':
                $this->cancelReservation();
                break;
            default:
                $this->home();
        }
    }
    

    private function home() {
        include 'templates/home.php';
    }

    private function addReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerId = $_POST['customer_id'];
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = $_POST['number_of_guests'];
            $specialRequests = $_POST['special_requests'];

            $this->db->addReservation($customerId, $reservationTime, $numberOfGuests, $specialRequests);
            header("Location: index.php?action=viewReservations&message=Reservation Added");
            exit; 
        } else {
            include 'templates/addReservation.php';
        }
    }

    private function viewReservations() {
        $reservations = $this->db->getAllReservations(); 

        include 'templates/viewReservations.php'; 
    }

    private function testDatabase() {
        $reservations = $this->db->testDatabaseConnection();
        var_dump($reservations);
        die();
    }

    private function cancelReservation() {
        if (isset($_GET['id'])) {
            $reservationId = intval($_GET['id']);
            $this->db->deleteReservation($reservationId);
            header("Location: index.php?action=viewReservations&message=Reservation Canceled");
            exit;
        } else {
            die("Invalid reservation ID.");
        }
    }
    
    private function modifyReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservationId = intval($_POST['reservation_id']);
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = intval($_POST['number_of_guests']);
            $specialRequests = $_POST['special_requests'];
    
            $this->db->updateReservation($reservationId, $reservationTime, $numberOfGuests, $specialRequests);
            header("Location: index.php?action=viewReservations&message=Reservation Modified");
            exit;
        } elseif (isset($_GET['id'])) {
            $reservationId = intval($_GET['id']);
            $reservation = $this->db->getReservationById($reservationId);
            include 'templates/modifyReservation.php';
        } else {
            die("Invalid reservation ID.");
        }
    }
    


}



