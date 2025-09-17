Liebe:r Tech Stream Conference Admin,

<?= $admin ?> hat soeben einen Zeit-Slot für den Talk "<?= $title ?>" von <?= $username ?> vorgeschlagen. Der Termin lautet:

    Datum: <?= date('d.m.Y', strtotime($timeSlot->startTime)) ?>

    Uhrzeit: <?= date('H:i', strtotime($timeSlot->startTime)) ?> Uhr - <?= date('H:i', strtotime($timeSlot->startTime . ' + ' . $timeSlot->duration . ' minutes')) ?> Uhr
    Typ: <?= $timeSlot->isSpecial ? 'YouTube-Vortrag' : 'Live-Vortrag' ?>


Viele Grüße,
das Tech Stream Conference Team
