<?php
    
    session_start(); // to keep the record of the entered data and display it later

        // Taking all values from the signup form 
		if($_SERVER["REQUEST_METHOD"]=="POST"){
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
        $email = $_POST["email"];
		$number = $_POST["number"];
		$password = $_POST["password"];
		$confirmpassword = $_POST["confirmpassword"];
			
		//for validatig and sanitizing user input
		$firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
        $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
		$email = filter_var($email,FILTER_SANITIZE_EMAIL);
		$number = filter_var($number, FILTER_SANITIZE_STRING);

          // Initialized error array. used in the sign up form for displaying the errors that occur
         $errors = [];

         // to Check if first name contains only alphabets
         if (!preg_match("/^[A-Za-z]+$/", $firstname)) {
            $errors[] = "First name must contain only alphabets.";
            }

         // to Check if last name contains only alphabets
            if (!preg_match("/^[A-Za-z]+$/", $lastname)) {
          $errors[] = "Last name must contain only alphabets.";
        }

		//to check if password are matching
		if($password !== $confirmpassword)
		{
            $errors[] = "Passwords do not match.";
		}
        // to Check password complexity
        if (!preg_match('/^(?=.*[!@#$%^&*(),.?":{}|<>]).{6,}$/', $password)) {
        $errors[] = "Password must be at least 6 characters long and contain at least 2 special characters.";
       }
       
        // conn to database
			$servername = "localhost";
			$username = "root";
			$password ="" ;
			$dbname ="form";
		$conn = new mysqli($servername,$username, $password, $dbname);
	
		 //to Check conn to database
		 if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //to Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM signup WHERE email = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            //if the email is already existing
            $errors[] = "This email is already registered. Please use a different email.";
        }
            $stmt->close();

            // If no errors, we can insert a new user
    if (empty($errors))
         {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO signup (firstname, lastname, email, number, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $number, $hashed_password);

            if ($stmt->execute()) {
                 //  session variables
                 $_SESSION['email'] = $email;
                 $_SESSION['firstname'] = $firstname;
                 $_SESSION['lastname'] = $lastname;
                 $_SESSION['number']= $number;
                // Registration successful
                header("Location:profile.php");
                exit; // exiting the loop to prevent furthr execution
            } else {
                $errors[] = "Registration failed: " . $stmt->error;
            }
            $stmt->close();
        }
        // Close connection
        $conn->close();

         // Stores the errors in session and returns back to the signup form
    $_SESSION['errors'] = $errors;
    header("Location:signup.php");
    exit;
    }

?>