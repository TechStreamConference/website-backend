Liebe:r <?= $username ?>,

du hast Änderungen an deinem Vortrag vorgenommen:

<?php foreach ($differences as $difference): ?>
<?= $difference->name ?>:
    Alter Wert: <?= $difference->old ?>

    Neuer Wert: <?= $difference->new ?>

<?php endforeach; ?>


Deine Änderungen werden nun von den Admins geprüft.

Viele Grüße,
das Tech Stream Conference Team
