# Drol - ChallengeOne

## Run Locally

Start the server

```bash
  make startserver
```

Start the client

```bash
  make startclient
```

Init DB

```
  make db
```

Fixtures

```bash
  make fixtures
```

Build

```
  npm run build
```

<!-- ## API Reference

#### HTTP: Salons (admin)

```http
  POST - GET http://localhost:8091/api/salon
  DELETE - UPDATE http://localhost:8091/api/salon/${id}
```

| Header   | Type     | Description                    |
| :------- | :------- | :----------------------------- |
| `Bearer` | `string` | **Required**. Token from login |

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |

| Body   | Type     | Description  |
| ------ | -------- | ------------ |
| `name` | `string` | **Required** | -->

<!-- ####

#### HTTP (SSE): Notifications

```http
  http://localhost:8091/subscribe
```

```http
  http://localhost:8091/notif
```

####

#### WS: Salons chat

```http
  ws://localhost:8092
``` -->

## Ecosystem

| Project      | Status      | Description                                    |
| ------------ | ----------- | ---------------------------------------------- |
| api platform | v3.0.0      | Web framework to generate REST API and GraphQL |
| vuejs        | npm v1.17.3 | Open source Javascript framework               |
| vite         | npm v4.0.0  | Frontend Tooling                               |
| vue-router   | npm v8.5.1  | Official Vue Router                            |
| pinia        | npm v6.8.0  | Store for Vue                                  |

## Authors

-   [@OdessaCh](https://github.com/OdessaCh)
-   [@leaifergan](https://github.com/leaifergan)
-   [@rina-myriam](https://github.com/rina-myriam)
-   [@DanLevyM](https://www.github.com/DanLevyM)
