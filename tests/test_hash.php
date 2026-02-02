<?php
$password = '123456';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Generated Hash: " . $hash . "\n";
echo "Verify '123456' against Generated Hash: " . (password_verify($password, $hash) ? 'TRUE' : 'FALSE') . "\n";

$known_hash = '$2y$10$Qj2E.y.gJq.q.t.z/t.X8u.J6/x.L.1p.0a.6.Z.7u.O8x/N.P.2/K';
echo "Verify '123456' against Known Hash: " . (password_verify($password, $known_hash) ? 'TRUE' : 'FALSE') . "\n";
?>