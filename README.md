Installation
============

### Requirements
- Download **docker** and **docker-compose** binaries for initialization
- **make** executable

**Step 1:**
- Executing docker as regular user: **(only for linux)**

**Note:** If your docker executable already running by your user then, you can skip this step.

```shell
sudo groupadd docker
sudo usermod -aG docker ${USER}
su -s ${USER}

# For testing
docker --version
```

**Step 2:**

Open a command console, enter your project directory and execute:

```console
$ sudo make init
$ sudo make app-init
```


**Step 3:**

Create .env.local file from .env file:

**Step 4:**

Execute this commands for creating tables and for adding with data

```console
$ sudo make app-migrate
$ sudo make app-fixture-load
```
**Step 5:**

For testing api open the http://127.0.0.1:8888/api/doc url:

