<?php
partial('home/hero', ['profile' => $profile]);
partial('home/guarantees', ['guarantees' => $guarantees]);
partial('home/purchases', ['categories' => $categories]);
partial('home/channels', ['channels' => $channels]);
partial('home/prices', [
    'gold' => $gold,
    'metals' => $metals,
    'priceSource' => $priceSource,
    'pricesUpdatedAt' => $pricesUpdatedAt,
]);
partial('home/tours', ['tours' => $tours]);
partial('home/agencies', ['agencies' => $agencies, 'regions' => $regions, 'agencyCount' => $agencyCount]);
partial('home/exchange', ['exchange' => $exchange, 'investment' => $investment]);
partial('home/estimation', ['estimationCategories' => $estimationCategories, 'profile' => $profile, 'csrfToken' => $csrfToken]);
