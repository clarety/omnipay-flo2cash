# Omnipay: Flo2cash

** Flo2cash driver for the Omnipay PHP payment processing library **

[![Build Status](https://travis-ci.org/guisea/omnipay-flo2cash.png?branch=master)](https://travis-ci.org/guisea/omnipay-flo2cash)
[![Latest Stable Version](https://poser.pugx.org/guisea/omnipay-flo2cash/v/stable)](https://packagist.org/packages/guisea/omnipay-flo2cash)
[![Total Downloads](https://poser.pugx.org/guisea/omnipay-flo2cash/downloads)](https://packagist.org/packages/guisea/omnipay-flo2cash)
[![Latest Unstable Version](https://poser.pugx.org/guisea/omnipay-flo2cash/v/unstable)](https://packagist.org/packages/guisea/omnipay-flo2cash)
[![Code Climate](https://codeclimate.com/repos/565d7932310a26005901d935/badges/06668d8b3b4c0da47f47/gpa.svg)](https://codeclimate.com/repos/565d7932310a26005901d935/feed)
[![Test Coverage](https://codeclimate.com/repos/565d7932310a26005901d935/badges/06668d8b3b4c0da47f47/coverage.svg)](https://codeclimate.com/repos/565d7932310a26005901d935/coverage)
[![License](https://poser.pugx.org/guisea/omnipay-flo2cash/license)](https://packagist.org/packages/guisea/omnipay-flo2cash)



[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Flo2cash support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "guisea/omnipay-flo2cash": "~2.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Flo2cash 

This is gateway driver to use the gateway provided by Flo2cash. Supports Standard gateway functionality along with token based recurring billing.

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/thephpleague/omnipay-dummy/issues),
or better yet, fork the library and submit a pull request.
