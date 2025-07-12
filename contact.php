<?php
// Define variables and set to empty values
$name = $email = $subject = $message = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic sanitization
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Send email
        $to = "mahbub.aaman.app@gmail.com";  // Change to your email address
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

        $body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

        if (mail($to, $subject, $body, $headers)) {
            $success = "Thank you! Your message has been sent.";
            $name = $email = $subject = $message = ""; // Clear fields
        } else {
            $error = "There was a problem sending your message. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 500px; margin: auto; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Contact Us</h2>

    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="name" placeholder="Your Name" value="<?php echo $name; ?>" required>
        <input type="email" name="email" placeholder="Your Email" value="<?php echo $email; ?>" required>
        <input type="text" name="subject" placeholder="Subject" value="<?php echo $subject; ?>" required>
        <textarea name="message" placeholder="Message" rows="6" required><?php echo $message; ?></textarea>
        <button type="submit">Send Message</button>
    </form>
</body>
</html>
