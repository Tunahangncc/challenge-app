<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# CHALLENGE APP

This project has been developed as a RestAPI. Its main purpose is to perform in-app purchase transactions and to manage subscription status.


## API Reference

#### POST - Register

```http
  POST {domain}/api/device/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `uid`     | `string` | **Required**. |
| `app_uid` | `string` | **Required**. |

#### POST - Change Device Language

```http
  POST {domain}/api/device/change-language
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `client_token`       | `string` | **Required**. |
| `language`           | `string` | **Required**. |

#### GET - Check Subscription

```http
  GET {domain}/api/device/check-subscription
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `client_token`       | `string` | **Required**. |

#### POST - Purchase

```http
  POST {domain}/api/purchase
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `receipt`            | `string` | **Required**. |
| `client_token`       | `string` | **Required**. |

#### POST - Recovery Purchase

```http
  POST {domain}/api/purchase/recovery
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `receipt`            | `string` | **Required**. |

#### GET - Report | All Device

```http
  GET {domain}/api/report/all-device
```

#### GET - Report | All Device With Operating System

```http
  GET {domain}/api/report/all-device-with-os-information
```


# Configuration

The **fail_alert_mail** parameter in the failed section of the **"config/queue.php"** file located in the root directory of the project should be checked. If this parameter is empty, emails will not be sent from the queues.

# Packages I Use

For maintaining code quality, I've utilized the **rector/rector** and **laravel/pint** packages.

For testing purposes, I've employed the **phpunit/phpunit** package.

To retrieve user system information, I've integrated the **jenssegers/agent** package.

And for saving Excel files sent via email, I've implemented the **maatwebsite/excel** package.


