<h1><?= $res ?></h1>

<?php if ($res === "CORRECT!") : ?>
    <p>You found the number on try no.<?= 6 - $tries ?>!</p>
<?php endif; ?>

<?php if ($res === "YOU LOSE!") : ?>
    <p>The correct number was <?= $number ?>.</p>
<?php endif; ?>

<form action="init">
    <input type="submit" name="doInit" value="Play again?">
</form>
