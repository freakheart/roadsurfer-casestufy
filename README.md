# Product API
Provides an API to handle products and its related details.

# Configure the env variables
Configure the required variables in the .env file. Create a entry in your hosts file.
```bash
127.0.0.1   api.roadsurfer.de
```

## Build the docker container
```bash
docker-compose up -d --build --remove-orphans
```

## Check docker logs
```bash
docker-compose logs -f
```

## API
Go to http://api.roadsurfer.de:8001/api/docs to access the API. 

### API Login
Use these credentials to login and get your JWT token. 
```bash
{
  "username": "admin",
  "password": "admin"
}
```

## Admin Dashboard
Go to http://api.roadsurfer.de:8001/admin to access it.

## Client Generation
Generate the client using the command
```bash
vendor/bin/jane-openapi generate --config-file=config/jane/open_api.php
```

Run cs fixer
```sh
vendor/bin/php-cs-fixer fix src/Client/ --rules=@Symfony
```