<?php

test('returns a successful response', function () {
    $response = $this->get(route('fr.home'));

    $response->assertOk();
});
