
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


