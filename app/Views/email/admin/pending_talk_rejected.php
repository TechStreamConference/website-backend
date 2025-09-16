Liebe:r Tech Stream Conference Admin,

<?= $admin ?> hat soeben den Talk "<?= $title ?>" von <?= $username ?> abgelehnt. Es handelte sich um einen bisher nicht angenommenen Vortrag ("pending").

<?php if ($reason !== null): ?>Grund für die Ablehnung: <?= $reason ?><?php else:?>Es wurde kein Grund für die Ablehnung angegeben.<?php endif; ?>


Viele Grüße,
das Tech Stream Conference Team
