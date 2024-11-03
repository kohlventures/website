<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $location = htmlspecialchars($_POST['location']);
    $position = htmlspecialchars($_POST['position']);
    $cover_letter = htmlspecialchars($_POST['cover_letter']);
    $linkedin = htmlspecialchars($_POST['linkedin']);
    $gender = htmlspecialchars($_POST['gender']);
    $hispanic = htmlspecialchars($_POST['hispanic']);
    $race = htmlspecialchars($_POST['race']);
    $disability_status = htmlspecialchars($_POST['disability_status']);
    $veteran_status = htmlspecialchars($_POST['veteran_status']);

    // Prepare email content
    $to = "treasuregoblinportal@gmail.com"; // Change to your HR email
    $subject = "New Application from $name";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $message = "You have received a new application:\n\n" .
               "Name: $name\n" .
               "Email: $email\n" .
               "Phone: $phone\n" .
               "Location: $location\n" .
               "Position of Interest: $position\n" .
               "Cover Letter:\n$cover_letter\n" .
               "LinkedIn Profile: $linkedin\n" .
               "Gender: $gender\n" .
               "Hispanic/Latino: $hispanic\n" .
               "Race: $race\n" .
               "Disability Status: $disability_status\n" .
               "Veteran Status: $veteran_status\n";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Application submitted successfully.";
    } else {
        echo "There was an error sending the application. Please try again later.";
    }
}
?>
