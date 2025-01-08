Liebe:r Tech Stream Conference Admin,

<?= esc($admin) ?> hat soeben den Talk "<?= esc($title) ?>" von <?= esc($username) ?> abgelehnt. Es handelte sich um einen bisher nicht angenommenen Vortrag ("pending").

<?php if ($reason !== null): ?>Grund für die Ablehnung: <?= esc($reason) ?><?php else:?>Es wurde kein Grund für die Ablehnung angegeben.<?php endif; ?>


Viele Grüße,
das Tech Stream Conference Team
