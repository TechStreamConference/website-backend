Liebe:r Tech Stream Conference Admin,

es gab Änderungen am Vortrag "<?= esc($title) ?>" von <?= esc($username) ?>. <?php if ($requested_changes != null): ?>Die vorher angeforderten Änderungen lauten:

<?= esc($requested_changes) ?>

<?php else: ?>Es wurden vorher keine Änderungen angefordert.
<?php endif; ?>

Es gab folgende Änderungen:
<?php foreach ($differences as $difference): ?>
    <?= esc($difference->name) ?>:
        Alter Wert: <?= esc($difference->old) ?>

        Neuer Wert: <?= esc($difference->new) ?>

<?php endforeach; ?>


Im Admin-Dashboard kannst du den Vortrag jetzt erneut prüfen.

Viele Grüße,
das Tech Stream Conference Team
