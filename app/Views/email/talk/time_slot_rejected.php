Liebe:r <?= $username ?>,

du hast den vorgeschlagenen Zeit-Slot (<?= date('d.m.Y', strtotime($timeSlot->startTime)) ?>, <?= date('H:i', strtotime($timeSlot->startTime)) ?> Uhr - <?= date('H:i', strtotime($timeSlot->startTime . ' + ' . $timeSlot->duration . ' minutes')) ?> Uhr) abgelehnt.

<?php if ($reason != null): ?>Als Grund hast du angegeben: <?= $reason ?>


<?php endif; ?>
Wir werden dir in Kürze einen neuen Zeit-Slot vorschlagen.

Viele Grüße,
das Tech Stream Conference Team
