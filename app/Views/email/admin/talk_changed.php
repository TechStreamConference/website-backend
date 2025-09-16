Liebe:r Tech Stream Conference Admin,

es gab Änderungen am Vortrag "<?= $title ?>" von <?= $username ?>. <?php if ($requested_changes != null): ?>Die vorher angeforderten Änderungen lauten:

<?= $requested_changes ?>

<?php else: ?>Es wurden vorher keine Änderungen angefordert.
<?php endif; ?>

Es gab folgende Änderungen:
<?php foreach ($differences as $difference): ?>
    <?= $difference->name ?>:
        Alter Wert: <?= $difference->old ?>

        Neuer Wert: <?= $difference->new ?>

<?php endforeach; ?>


Im Admin-Dashboard kannst du den Vortrag jetzt erneut prüfen.

Viele Grüße,
das Tech Stream Conference Team
