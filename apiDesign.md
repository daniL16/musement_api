## Step 2.

We need to design an endpoint that receives information about weather info for a city and
another one to retrieve it.

Note: we are going to assume that the information we want to store is the one we have obtained in step 1. 
This solution is extensible to store more fields, we would only have to add them in the json and in the database.

### Post forecast for a city.

The endpoint will be as follows:

`POST /api/v3/cities/{id}/forecast`

receiving the following json as params:

```json
{
  "date": "YYYY-mm-dd",
  "condition": "Sunny"
}
```

This data will be stored in a table with the following columns: cityId, date, condition.

Our endpoint returns the following possible responses:

```json
{
  "responses": {
    "201": {
      "description": "Returned when successful"
    },
    "403": {
      "description": "Forbidden, (only if auth is required)"
    },
    "404": {
      "description": "Error: cityId not found "
    },
    "500": {
      "description": "Internal server error"
    },
    "503": {
      "description": "Service is unavailable"
    }
  }
}
```

### Get forecast for a city.

`GET /api/v3/api/cities/{id}/forecast?date='YYYY-mm-dd'`

It just read the data for the pair (cityId, date) from the table where we had stored the information, 
and it will return one of the following responses:

```json
{
  "responses": {
    "200": {
      "description": "Returned when successful",
      "content": {
        "cityId": "",
        "date": "",
        "condition": ""
      }
    },
    "403": {
      "description": "Forbidden, (only if auth is required)"
    },
    "404": {
      "description": "Error: cityId not found "
    },
    "500": {
      "description": "Internal server error"
    },
    "503": {
      "description": "Service is unavailable"
    }
  }
}
```


