<?php 

it('route / has "CreateIt" in it', function (){
    $page = visit('/');

    $page->assertSee('CreateIt');
});