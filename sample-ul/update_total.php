<?php
if (isset($_POST['weeks']) && isset($_POST['price'])) {
    $weeks = intval($_POST['weeks']);
    $price = floatval($_POST['price']);

    $subtotal = $weeks * $price;
    $payable = $subtotal + 20;

    echo json_encode([
        'subtotal' => $subtotal,
        'payable' => $payable
    ]);
}
?>
