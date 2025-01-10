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


<?php if ($timeSlot->isSpecial): ?>
Wir werden uns noch einmal in einer gesonderten E-Mail bei dir melden, um zu besprechen, wie wir die Aufzeichnung deines Vortrags handhaben.
<?php else: ?>
Wir werden dir rechtzeitig vor dem Event in einer gesonderten E-Mail die Links mitteilen, mit denen du dich zum Live-Stream einwählen kannst.
<?php endif; ?>


Viele Grüße,
das Tech Stream Conference Team
