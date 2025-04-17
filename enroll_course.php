<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = "enroll_course.php?course_id=" . $_GET['course_id'];
    header("Location: course_login.php");
    exit();
}

if (!isset($_GET['course_id'])) {
    die("Invalid request.");
}

$course_id = $_GET['course_id'];
$query = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    die("Course not found.");
}

// Check if the user is already enrolled
$user_id = $_SESSION['user_id'];
$check_query = "SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?";
$stmt_check = $conn->prepare($check_query);
$stmt_check->bind_param("ii", $user_id, $course_id);
$stmt_check->execute();
$stmt_check->store_result();
$is_enrolled = $stmt_check->num_rows > 0;
$stmt_check->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in <?php echo htmlspecialchars($course['title']); ?></title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        h1 {
            color: #343a40;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .terms-container {
            border: 1px solid #ddd;
            padding: 10px;
            max-height: 150px;
            overflow-y: auto;
            background-color: #f9f9f9;
            margin-bottom: 15px;
            text-align: left;
        }
        .terms-container h3 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 10px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 15px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enroll in <?php echo htmlspecialchars($course['title']); ?></h1>
        
        <?php if ($is_enrolled): ?>
            <p class="error-message">You are already enrolled in this course.</p>
            <a href="courses.php?course_id=<?php echo $course_id; ?>">
                <button>Go Back to Course</button>
            </a>
        <?php else: ?>
            <div class="terms-container">
                <h3>Terms & Conditions</h3>
                <p>By enrolling in this course, you agree to abide by our policies, including attendance, participation, and ethical guidelines. Refunds may not be available after enrollment. Ensure you meet all prerequisites before proceeding.</p>
            </div>
            
            <form action="process_enrollment.php" method="POST" onsubmit="return checkTerms()">
                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
                
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>
                </div>
                
                <div class="checkbox-container">
                    <input type="checkbox" id="agree" name="agree">
                    <label for="agree">I agree to the Terms & Conditions</label>
                </div>
                
                <button type="submit">Enroll</button>
            </form>
        <?php endif; ?>
    </div>
    
    <script>
        function checkTerms() {
            if (!document.getElementById('agree').checked) {
                alert("You must agree to the Terms & Conditions before enrolling.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>