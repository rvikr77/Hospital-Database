<?php
// api.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

require_once "config.php";

$conn = new mysqli($server, $user, $pass, "HOSPITALDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the action from the URL parameter
$action = isset($_GET['action']) ? $_GET['action'] : '';
$data = json_decode(file_get_contents("php://input"), true);

switch ($action) {
    case 'get':
        // Get records from HOSPITAL table
        if (isset($_GET['ph']) && isset($_GET['name'])) {
            $ph = $_GET['ph'];
            $name = $_GET['name'];
            $sql = "SELECT * FROM HOSPITAL WHERE PH = ? AND NAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $ph, $name);
        } else {
            $sql = "SELECT * FROM HOSPITAL";
            $stmt = $conn->prepare($sql);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
        break;

    case 'post':
        // Insert or update a record in the HOSPITAL table
        $ph = $data['ph'];
        $name = $data['name'];
        $age = $data['age'];
        $gender = $data['gender'];
        $bp1 = $data['bp1'];
        $bp2 = $data['bp2'];
        $pulse = $data['pulse'];
        $allergies = $data['allergies'];
        $height = $data['height'];
        $weight = $data['weight'];
        $patient_details = $data['patient_details'];

        $sql = "INSERT INTO HOSPITAL (PH, NAME, AGE, GENDER, BP1, BP2, PULSE, ALLERGIES, HEIGHT, WEIGHT, PATIENT_DETAILS) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                NAME = VALUES(NAME), AGE = VALUES(AGE), GENDER = VALUES(GENDER), BP1 = VALUES(BP1), BP2 = VALUES(BP2), 
                PULSE = VALUES(PULSE), ALLERGIES = VALUES(ALLERGIES), HEIGHT = VALUES(HEIGHT), WEIGHT = VALUES(WEIGHT), 
                PATIENT_DETAILS = VALUES(PATIENT_DETAILS)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isisiiisiis", $ph, $name, $age, $gender, $bp1, $bp2, $pulse, $allergies, $height, $weight, $patient_details);
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Record saved successfully"]);
        } else {
            echo json_encode(["message" => "Error saving record: " . $conn->error]);
        }
        break;

        case 'delete':
            // Delete a record from HOSPITAL and optionally from STORAGE
            $data = json_decode(file_get_contents("php://input"), true); // Ensure data is fetched
            $ph = $data['ph'];
            $name = $data['name'];
        
            // Check if the record exists in STORAGE and delete if it does
            $sql = "SELECT * FROM STORAGE WHERE PH = ? AND NAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $ph, $name);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Record exists in STORAGE, so delete it
                $sql = "DELETE FROM STORAGE WHERE PH = ? AND NAME = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $ph, $name);
                if (!$stmt->execute()) {
                    echo json_encode(["message" => "Error deleting record from STORAGE: " . $conn->error]);
                    exit;
                }
            }
        
            // Now delete the record from HOSPITAL
            $sql = "DELETE FROM HOSPITAL WHERE PH = ? AND NAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $ph, $name);
            if ($stmt->execute()) {
                echo json_encode(["message" => "Record deleted successfully"]);
            } else {
                echo json_encode(["message" => "Error deleting record from HOSPITAL: " . $conn->error]);
            }
            break;
        

    case 'put':
        // Move data from HOSPITAL to STORAGE
        $ph = $data['ph'];
        $name = $data['name'];

        $sql = "SELECT * FROM HOSPITAL WHERE PH = ? AND NAME = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $ph, $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $sql = "INSERT INTO STORAGE (PH, NAME, AGE, GENDER, BP1, BP2, PULSE, ALLERGIES, HEIGHT, WEIGHT, PATIENT_DETAILS)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                    AGE = VALUES(AGE), GENDER = VALUES(GENDER), BP1 = VALUES(BP1), BP2 = VALUES(BP2), 
                    PULSE = VALUES(PULSE), ALLERGIES = VALUES(ALLERGIES), HEIGHT = VALUES(HEIGHT), 
                    WEIGHT = VALUES(WEIGHT), PATIENT_DETAILS = VALUES(PATIENT_DETAILS)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isisiiisiis", $row['PH'], $row['NAME'], $row['AGE'], $row['GENDER'],
                $row['BP1'], $row['BP2'], $row['PULSE'], $row['ALLERGIES'],
                $row['HEIGHT'], $row['WEIGHT'], $row['PATIENT_DETAILS']);
            $stmt->execute();

            $sql = "DELETE FROM HOSPITAL WHERE PH = ? AND NAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $ph, $name);
            $stmt->execute();

            echo json_encode(["message" => "Record moved to STORAGE and deleted from HOSPITAL"]);
        } else {
            echo json_encode(["message" => "No record found to move"]);
        }
        break;

        case 'transfer':
            // Move data from STORAGE to HOSPITAL
            $ph = $data['ph'];
            $name = $data['name'];
    
            $sql = "SELECT * FROM STORAGE WHERE PH = ? AND NAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $ph, $name);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
    
            if ($row) {
                $sql = "INSERT INTO HOSPITAL (PH, NAME, AGE, GENDER, BP1, BP2, PULSE, ALLERGIES, HEIGHT, WEIGHT, PATIENT_DETAILS)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE 
                        AGE = VALUES(AGE), GENDER = VALUES(GENDER), BP1 = VALUES(BP1), BP2 = VALUES(BP2), 
                        PULSE = VALUES(PULSE), ALLERGIES = VALUES(ALLERGIES), HEIGHT = VALUES(HEIGHT), 
                        WEIGHT = VALUES(WEIGHT), PATIENT_DETAILS = VALUES(PATIENT_DETAILS)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isisiiisiis", $row['PH'], $row['NAME'], $row['AGE'], $row['GENDER'],
                    $row['BP1'], $row['BP2'], $row['PULSE'], $row['ALLERGIES'],
                    $row['HEIGHT'], $row['WEIGHT'], $row['PATIENT_DETAILS']);
                $stmt->execute();
    
    
                echo json_encode(["message" => "Record moved to STORAGE and deleted from HOSPITAL"]);
            } else {
                echo json_encode(["message" => "No record found to move"]);
            }
            break;
    
    case 'credentials':
        $username = $data['username'];
    $password = $data['password'];

    // Query to check credentials (use prepared statements to prevent SQL injection)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password); // Adjust password handling as needed (e.g., hashing)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Store role in session
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    }

    $stmt->close();
        break;
    default:
        echo json_encode(["message" => "Invalid action"]);
        break;
}

$conn->close();
?>
