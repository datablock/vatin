<?php
require_once '../vendor/autoload.php';

use Datablock\Vatin\Vatin;

$vatin = new Vatin();


// Setting Country
// --

// Setting country on instance
$vatin = new Vatin("FR");

// Setting country by method
// $vatin->country("FR");



// Getting Data
// --

// print_r( $vatin->data() );



// Getting Rates
// --

// Getting rates values only
// print_r( $vatin->rates() );

// Getting rates values and info
// print_r( $vatin->rates(true) );

// Getting standard rate only
// print_r( $vatin->standardRate() );



// Getting Pattern & Validator
// --

// Getting Pattern
// print_r( $vatin->pattern() );

// Is a valid VATIN
// print_r( $vatin->validator("FR32439351354") ); // Valid
// print_r( $vatin->validator("32439351354") ); // Valid
// print_r( $vatin->validator("31439351354") ); // InValid



// Getting Label
// --

print_r( $vatin->label() );
// print_r( $vatin->label(true) );



// VATIN DATABASE
// --

// Database Object
// print_r( $vatin->database(false) );

// Database Array
// print_r( $vatin->database(true) );