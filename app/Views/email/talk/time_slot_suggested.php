Liebe:r <?= $username ?>,

wie wir dir ja bereits mitgeteilt haben, gefällt uns dein Vortragsthema "<?= $title ?>" sehr gut.

<?php if ($timeSlot->isSpecial): ?>
Das Live-Programm ist bereits voll, aber wir würden deinen Vortrag gerne als Aufzeichnung veröffentlichen. Er würde dann als YouTube-Premiere laufen und im Zeitplan auf unserer Webseite erscheinen. Wir werden uns nochmals bei dir melden, um zu besprechen, wie und bis wann du deinen Vortrag aufzeichnen solltest. Die YouTube-Premiere würde stattfinden am:

<?php else: ?>
Wir möchten dir gerne einen Slot für deinen Vortrag anbieten. Hier sind die Details:

<?php endif; ?>
    Datum: <?= date('d.m.Y', strtotime($timeSlot->startTime)) ?>

    Uhrzeit: <?= date('H:i', strtotime($timeSlot->startTime)) ?> Uhr - <?= date('H:i', strtotime($timeSlot->startTime . ' + ' . $timeSlot->duration . ' minutes')) ?> Uhr

Bitte logge dich in deinem Speaker-Dashboard ein und teile uns mit, ob dieser Termin für dich passt.

Viele Grüße,
das Tech Stream Conference Team
