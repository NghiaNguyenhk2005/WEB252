<h1>Contact Us</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">
        Message sent successfully!
    </p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red;">
        Invalid form data!
    </p>
<?php endif; ?>

<form method="POST" action="index.php?url=contact/submit">

    <input type="text" name="name" placeholder="Name">

    <br><br>

    <input type="email" name="email" placeholder="Email">

    <br><br>

    <textarea name="message" placeholder="Message"></textarea>

    <br><br>

    <button type="submit">
        Send
    </button>

</form>