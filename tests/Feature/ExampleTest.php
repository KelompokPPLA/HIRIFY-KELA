<?php

test('the application shows the public landing page at the root URL', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('Hirify');
});
