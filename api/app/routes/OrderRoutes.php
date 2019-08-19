<?php
    $app->get('/orders', 'OrderController:selectOrders');
    $app->post('/orders','OrderController:insertOrder');
?>