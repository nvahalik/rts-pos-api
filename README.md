This API Library provides a PHP 5.3+ interface to the [RTS Point of Sale System][rts-pos]. This library is only useful 
if you are an existing client of theirs and need to interface to your POS system.

Currently, this library provides the following functionality:

* Querying gift card information (such as balance and registration)
* Purchasing gift cards and processing the related payment

Additional functionality can be added by extending the existing Response and Request classes and ideally by adding 
helper functions to the main client class.

[rts-pos]: http://www.rts-solutions.com/

Copyright 2015 Nicholas Vahalik

This code is licensed under the GPL v3.0. You can find the license here: http://www.gnu.org/licenses/gpl.html
