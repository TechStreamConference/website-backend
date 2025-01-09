Liebe:r <?= esc($username) ?>,

du hast den vorgeschlagenen Zeit-Slot akzeptiert. Wir freuen uns sehr, dass du bei der Tech Stream Conference dabei bist! Hier sind noch einmal alle Daten zusammengefasst:

    Titel: <?= esc($title) ?>

<?php if ($timeSlot->isSpecial): ?>
    Zeitpunkt der YouTube-Premiere: <?= date('d.m.Y', strtotime($timeSlot->startTime)) ?>, <?= date('H:i', strtotime($timeSlot->startTime)) ?> Uhr
    Länge: <?= $timeSlot->duration ?> Minuten
<?php else: ?>
    Datum: <?= date('d.m.Y', strtotime($timeSlot->startTime)) ?>
    Uhrzeit: <?= date('H:i', strtotime($timeSlot->startTime)) ?> Uhr - <?= date('H:i', strtotime($timeSlot->startTime . ' + ' . $timeSlot->duration . ' minutes')) ?> Uhr
<?php endif; ?>

// TODO: Communicate how we will handle the YouTube recording or when the links for the live stream will be shared

Viele Grüße,
das Tech Stream Conference Team
