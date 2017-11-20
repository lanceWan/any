<?php

$router->resource('permission','PermissionController',['except' => ['show']]);