Liebe:r Tech Stream Conference Admin,

<?= esc($username) ?> hat soeben den Zeit-Slot für den Talk "<?= esc($title) ?>" abgelehnt.

    Datum: <?= date('d.m.Y', strtotime($timeSlot->startTime)) ?>

    Uhrzeit: <?= date('H:i', strtotime($timeSlot->startTime)) ?> Uhr - <?= date('H:i', strtotime($timeSlot->startTime . ' + ' . $timeSlot->duration . ' minutes')) ?> Uhr
    Typ: <?= $timeSlot->isSpecial ? 'YouTube-Vortrag' : 'Live-Vortrag' ?>


<?php if ($reason != null): ?>
Als Grund hat <?= esc($username) ?> angegeben: <?= esc($reason) ?>
<?php else: ?>
<?= esc($username) ?> hat keinen Grund angegeben.
<?php endif; ?>


Viele Grüße,
das Tech Stream Conference Team
