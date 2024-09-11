<?php include 'header.php'; ?>
<h1>Descubra seu Signo</h1>
<form action="show_zodiac_sign.php" method="post">
    <label for="birthdate">Data de Aniversário:</label>
    <input type="date" id="birthdate" name="birthdate" required>
    <button type="submit">Descobrir Signo</button>
</form>
<?php include 'footer.php'; ?>
