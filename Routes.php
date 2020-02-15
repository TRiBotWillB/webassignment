<?php

Route::set('home', function() {
   Home::CreateView();
});

Route::set('users', function() {
   echo "Users Route";
});