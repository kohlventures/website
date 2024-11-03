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

    // Handling resume file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $resume_tmp_path = $_FILES['resume']['tmp_name'];
        $resume_name = basename($_FILES['resume']['name']);
        $resume_type = $_FILES['resume']['type'];
        $resume_content = file_get_contents($resume_tmp_path);
    } else {
        echo "Error uploading resume.";
        exit;
    }

    // Prepare email content
    $to = "hr@suckventures.com";
    $subject = "New Application from $name";
    $message = "You have received a new application.\n\n" .
               "Name: $name\n" .
               "Email: $email\n" .
               "Phone: $phone\n" .
               "Location: $location\n" .
               "Position of Interest: $position\n" .
               "Cover Letter: $cover_letter\n" .
               "LinkedIn Profile: $linkedin\n" .
               "Gender: $gender\n" .
               "Hispanic/Latino: $hispanic\n" .
               "Race: $race\n" .
               "Disability Status: $disability_status\n" .
               "Veteran Status: $veteran_status\n";

    // Boundary for attachments
    $boundary = md5(uniqid(time()));

    // Headers
    $headers = "From: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Message Body with attachment
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message . "\r\n";
    
    // Add the resume attachment
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: $resume_type; name=\"$resume_name\"\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$resume_name\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($resume_content)) . "\r\n";
    $body .= "--$boundary--";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "Application submitted successfully.";
    } else {
        echo "There was an error sending the application. Please try again later.";
    }
}
?>
