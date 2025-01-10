Liebe:r <?= esc($username) ?>,

du hast Änderungen an deinem Vortrag vorgenommen:

<?php foreach ($differences as $difference): ?>
<?= esc($difference->name) ?>:
    Alter Wert: <?= esc($difference->old) ?>

    Neuer Wert: <?= esc($difference->new) ?>

<?php endforeach; ?>


Deine Änderungen werden nun von den Admins geprüft.

Viele Grüße,
das Tech Stream Conference Team
